<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\JokeRepository;



class JokeController extends AbstractController
{
    private $jokeRepository;
    private  $entityManager;
    
    public function __construct(JokeRepository $jokeRepository)
    {
        $this->jokeRepository = $jokeRepository;
    }
    /**
     * @Route("/", name="")
     * @Template
     */
    public function index()
    {

    }

    /**
     * @Route("/jokes", name="create_joke", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $content = $data['content'];
        if (empty($name) || empty($content)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }
        $joke = $this->jokeRepository->createJoke($name, $content);
        return new JsonResponse($joke->toArray(), Response::HTTP_CREATED);
    }

    /**
     * @Route("/jokes/{id}", name="get_joke", methods={"GET"})
     */
    public function get($id): JsonResponse
    { 
        $joke = $this->jokeRepository->findOneBy(['id' => $id]);
        if (empty($joke)) {
            throw new NotFoundHttpException('invalid Joke id');
        }
        return new JsonResponse($joke->toArray(), Response::HTTP_OK);
    }
    
    /**
     * @Route("/jokes/{id}", name="update_joke", methods={"PUT"})
    */
    public function update($id, Request $request): JsonResponse
    {
        $joke = $this->jokeRepository->findOneBy(['id' => $id]);
        if (empty($joke)) {
            throw new NotFoundHttpException('invalid Joke id');
        }
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $joke->setName($data['name']);
        empty($data['content']) ? true : $joke->setContent($data['content']);

        $updatedJoke = $this->jokeRepository->updateJoke($joke);

        return new JsonResponse($updatedJoke->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/jokes/random-joke", name="getRandomJoke_joke",  priority=1, methods={"GET"})
     */
    public function getRandomJoke(): JsonResponse
    {   
        $randomJokes = $this->jokeRepository->createQueryBuilder('joke')
        ->orderBy('RAND()')
        ->getQuery()
        ->setMaxResults(1)
        ->getResult();
        if (empty($randomJokes)) { // if empty create one
            $joke = $this->jokeRepository->createJoke('Name'.rand(5, 20), 'Content'.rand(5, 20));
        }
        else {
            $joke = reset($randomJokes);
        }
        return new JsonResponse($joke->toArray(), Response::HTTP_OK);
     
    }

    /**
    * @Route("/jokes/{id}", name="delete_joke", methods={"DELETE"})
    */
    public function delete($id): JsonResponse
    {
        $joke = $this->jokeRepository->findOneBy(['id' => $id]);
        if (empty($joke)) {
            throw new NotFoundHttpException('invalid Joke id');
        }
        $this->jokeRepository->deleteJoke($joke);
        return new JsonResponse(['status' => 'Joke deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
    * @Route("/jokes/", name="lists_joke", methods={"GET"})
    */
    public function lists(Request $request): JsonResponse
    {
        $query = $this->jokeRepository->createQueryBuilder('joke')
                    ->getQuery();
        if (empty($request->query->get('page-size')) || empty($request->query->get('page'))) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }
        if (!is_numeric($request->query->get('page-size')) || !is_numeric($request->query->get('page'))) {
            throw new NotAcceptableHttpException('invalid data type');
        }

        $pageSize = $request->query->get('page-size');
        $page = $request->query->get('page');
        // load doctrine Paginator
        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
    
        $totalJokes = count($paginator);
        $pagesCount = ceil($totalJokes / $pageSize);
      
        $offset = $pageSize * ($page-1);
        $jokesData = $this->jokeRepository->findBy([], null, $pageSize, $offset);
            
        $jokes =  array();
        foreach ($jokesData as $jokeData) {
            $jokes[] = $jokeData->toArray(); 
        }
      return  new JsonResponse(['jokes'=>$jokes, 'totalItems' => $totalJokes], Response::HTTP_OK);
    }
}
