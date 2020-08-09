<?php
namespace App\ApplicationBundle\EventListener;
 
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
 
class ApiExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
 
      $exception = $event->getThrowable();
      $response =  new JsonResponse($this->buildResponseData($exception));
      $event->setResponse($response);
  
    }
 
    private function buildResponseData($exception)
    {
        $messages = json_decode($exception->getMessage());
        if (!is_array($messages)) {
            $messages = $exception->getMessage() ? [$exception->getMessage()] : [];
        }
        return [
            'error' => [
                'code' => $exception->getCode(),
                'messages' => $messages
            ]];
    }
}