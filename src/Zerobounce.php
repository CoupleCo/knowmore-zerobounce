<?php

namespace NomorePackage\ZeroBounce;

class Zerobounce {

    private $email;
    private $client;
    private $response;
    private $error_message;

    private $response_checked = false;

    /**
     * Zerobounce constructor.
     * @param $email
     */
    public function __construct($email) {

        $this->email = $email;

        $this->client = new Client();
    }

    public function clean(){

        $response = $this->client->request($this->email);

        return (object)$response;

    }

    public function check(){

        if(!$this->response_handling()) return $this->response;

        $this->response_checked = true;

        if(!$this->valid()) return ['success' => false, 'message' => $this->error_message];

        if(!$this->toxic()) return ['success' => false, 'message' => $this->error_message];

        if(!$this->disposable()) return ['success' => false, 'message' => $this->error_message];

        return ['success' => true, 'message' => 'nothing seems out of the ordinary'];
    }

    public function valid(){

        if(!$this->response_handling()) return $this->response;

        if(!isset($this->response->status)) return false;

        if(strtolower($this->response->status) == 'valid') return true;

        if(strtolower($this->response->status) == 'catch-all') return true;

        return false;
    }

    public function toxic(){

        if(!$this->response_handling()) return $this->response;

        return  !$this->response->toxic;

    }

    public function disposable(){

        if(!$this->response_handling()) return $this->response;

        if(!$this->response->disposable) return true;

        $this->error_message = 'Sorry we don\'t accept minute mails';

        return false;
    }

    public function sub_status(){

        if($this->response->sub_status == '') return 'No error found';

        return str_replace('_', ' ', $this->response->sub_status);
    }

    private function response_handling(){

        if(is_null($this->response)) $this->response = $this->clean();

        if($this->response_checked) return true;

        if(isset($this->response->success) && !$this->response->success) return false;

        $this->error_message = $this->sub_status();

        return true;
    }
}