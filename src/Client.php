<?php

namespace NomorePackage\ZeroBounce;

use Exception;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 *
 * @author Martin V.P
 */
class Client {

    private $domain;
    private $guzzle;
    private $key;

    /**
     * Client constructor.
     */
    public function __construct() {

        $this->domain = config('zerobounce.domain');
        $this->key = config('zerobounce.key');

        $this->guzzle = new Guzzle;
    }


    public function request($email) {

        try {

            $url = $this->format_url($email);

            $response = $this->guzzle->request('GET', $url);

            return $this->createResponse($response);

        } catch (Exception $e) { return ['success' => false, 'message' => $e->getMessage()]; }

    }

    private function format_url($email){

        return $this->domain . 'validate?apikey=' . $this->key . '&email=' . urlencode($email);

    }

    protected function createResponse(GuzzleResponse $response) {
        return (array)json_decode($response->getBody());
    }


}