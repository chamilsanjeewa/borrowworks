<?php

namespace App\Repository;

use App\Entity\Joke;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @method Joke|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joke|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joke[]    findAll()
 * @method Joke[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JokeRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Joke::class);
        $this->manager = $manager;
 
    }

    public function createJoke($name, $content): Joke
    {
        $joke = new Joke();
        $joke->setName($name);
        $joke->setContent($content);
        $this->manager->persist($joke);
        $this->manager->flush();
        return $joke;
    }

    public function updateJoke(Joke $joke): Joke
    {
        
        $this->manager->persist($joke);
        $this->manager->flush();
        return $joke;
    }

    public function getRandomJoke(): Joke
    {   
        $randomJokes = $this->createQueryBuilder('joke')
            ->orderBy('RAND()')
            ->getQuery()
            ->setMaxResults(1)
            ->getResult();
        if (empty($randomJokes)) { // if empty create one and return
            return $this->createJoke('Name'.rand(5, 20), 'Content'.rand(5, 20));
        }
        return reset($randomJokes);
    }

    public function deleteJoke(Joke $joke)
    {
        $this->manager->remove($joke);
        $this->manager->flush();
        $this->manager->clear();
    }
}
