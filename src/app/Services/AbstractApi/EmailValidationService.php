<?php
namespace App\Services\AbstractApi;

use App\Contracts\EmailValidationInterface;
use App\DTO\EmailValidationResult;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class EmailValidationService implements EmailValidationInterface{
  private string $baseUrl = 'https://emailvalidation.abstractapi.com/v1/';
  public function __construct(private string $apiKey)
  {  
  }

  public function varify(string $email): EmailValidationResult
  {

    $stack = HandlerStack::create();
    $maxRetry = 3;

    $stack->push($this->getRetryMiddleware($maxRetry));

    $client = new Client([
      'base_uri'  => $this->baseUrl,
      'timeout'   => 5,
      'handler'   => $stack,
    ]);

    $params = [
      'api_key' => $this->apiKey,
      'email'  => $email,
    ];

    $response =  $client->get('', ['query' => $params]);

    $body = json_decode($response->getBody()->getContents(), true);

    return new EmailValidationResult($body['quality_score'] * 100 ,$body['deliverability'] === 'DELIVERABLE');
  }

  public function getRetryMiddleware(int $maxRetry): callable{
    
    return  Middleware::retry(
        function(
          int $retries,
          RequestInterface $request,
          ?ResponseInterface $response = null,
          ?RuntimeException $e = null
        )use($maxRetry)
        {
          if ($retries >= $maxRetry) {
            return false;
          }

          if ($response && in_array($response->getStatusCode(),[249,429,503])) {
            return true;
          }

          if ($e instanceof ConnectException) {
            return true;
          }

          return false;
        }
      );
  }
}