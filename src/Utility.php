<?php

namespace NomorePackage\ZeroBounce;


abstract class Utility {


    protected $client;
    protected $email;
    protected $response;
    protected $return_message;

    protected $is_valid;
    protected $is_toxic;
    protected $is_disposable;


    /**
     * Utility constructor.
     *
     * Create an instance of the client
     * Call the response handling if email isn't null
     *
     * @param null $email
     */
    public function __construct($email = null) {

        $this->email = $email;

        $this->client = new Client();

        if (!is_null($email)) $this->response_handling();

    }

    /**
     * If called in sequence returns success and message in an array
     * If called directly return the direct response from zerobounce
     *
     * @return array
     */
    public function get() {

        if (is_null($this->is_valid) && is_null($this->is_toxic) && is_null($this->is_disposable)) {
            return $this->response;
        }

        $boolean_to_return = $this->trueOrFalse();

        return ['success' => $boolean_to_return, 'message' => $this->return_message];


    }

    /**
     * full_check -> true = valid in all checks | false if any fails
     * isDisposable -> true = then the email is prob a minute mail | false not a disposable mail
     * isToxic -> true = then the email is toxic | false not a toxic mail
     * isValid -> true = then the is valid (valid|catch-all|unknown origin) | false not a valid mail
     *
     * @return bool
     */
    public function trueOrFalse() {

        if(is_null($this->is_valid) && is_null($this->is_toxic) && is_null($this->is_disposable)){
            return true;
        }

        if(is_null($this->is_valid) || is_null($this->is_toxic) || is_null($this->is_disposable)){
            if(!is_null($this->is_valid) && !$this->is_valid ) return false;
            if(!is_null($this->is_toxic) && !$this->is_toxic ) return false;
            if(!is_null($this->is_disposable) && !$this->is_disposable ) return false;

            return true;
        }

        if (!$this->is_valid || $this->is_toxic || $this->is_disposable) {

            return false;
        }

        return true;
    }


    /**
     * Always called to make sure we have a response to return
     * - also fetched the error message if any
     *
     * @return bool
     */
    protected function response_handling() {

        $this->response = $this->make_request();

        if (isset($this->response->success) && !$this->response->success) return false;

        $this->return_message = $this->sub_status();

        return true;
    }

    /**
     * Make the request to our client, then directly over to zerobounce api
     *
     * @return object
     */
    private function make_request() {

        $response = $this->client->request($this->email);

        return (object)$response;
    }

    /**
     * Function used to get the error message from zerobounce
     *
     * @return mixed|string
     */
    private function sub_status() {

        if ($this->response->sub_status == '') return 'No error found';

        return str_replace('_', ' ', $this->response->sub_status);
    }

}