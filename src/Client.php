<?php

namespace NomorePackage\ZeroBounce;

use Exception;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 *  A sample class
 *
 *  Use this section to define what this class is doing, the PHPDocumentator will use this
 *  to automatically generate an API documentation using this information.
 *
 * @author yourname
 */
class Client {

    private $domain;
    private $guzzle;
    private $key;

    /**
     * Client constructor.
     */
    public function __construct() {

        $this->domain = env('ZEROBOUNCE_DOMAIN');
        $this->key = env('ZEROBOUNCE_KEY');

        $this->guzzle = new Guzzle;
    }


    public function request($method, $endpoint, $content = []) {
        try {

            $url = $this->domain . $endpoint;
            $response = $this->guzzle->request(
                $method,
                $url,
                [
                    'json' => $content,
                    'auth' => [$this->username . '/token', $this->token],
                ]
            );

//            $this->logRateLimit($response->getHeaders());

            return $this->createResponse($response);

        } catch (Exception $e) {
            dd($e);
        }

    }

    public function test($email){

        $url = $this->format_url($email);

        $response = $this->guzzle('GET', $url);

        return $this->createResponse($response);

    }

    private function format_url($email){

        return $this->domain . 'validate?apikey=' . $this->key . '&email=' - urlencode($email);

    }

    protected function createResponse(GuzzleResponse $response) {
        return (array)json_decode($response->getBody()->__toString());
    }



//    protected function logRateLimit($headers) {
//
//
//        $rate_limit = $headers['X-Rate-Limit-Remaining'][0];
//
//        if(isset($headers['Retry-After'])) Slack::freshdeskRateLimitReset();
//
//        if(intval($rate_limit) < 10){
//            Slack::freshdeskRateLog(intval($rate_limit));
//        }
//    }

}