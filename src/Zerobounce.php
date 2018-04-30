<?php

namespace NomorePackage\ZeroBounce;

class Zerobounce extends Utility {

    /**
     * Always call this function to set the email and re-initiate the parent constructor
     *
     * @param $email
     * @return $this
     */
    public function email($email) {

        parent::__construct($email);

        return $this;
    }


    /**
     * Runs through all the available checks and returns the result
     *
     * @return $this
     */
    public function full_check(){

        $this->isValid();

        $this->isToxic();

        $this->isDisposable();

        return $this;

    }

    /**
     * Checks if the email is either a valid|catch-all|unknown origin
     *
     * @return $this
     */
    public function isValid(){

        if(!isset($this->response->status)) {
            $this->is_valid = false;

            return $this;
        }

        elseif(strtolower($this->response->status) == '') $this->is_valid = true;

        elseif(strtolower($this->response->status) == 'valid') $this->is_valid = true;

        elseif(strtolower($this->response->status) == 'unknown') $this->is_valid = true;

        elseif(strtolower($this->response->status) == 'catch-all') $this->is_valid = true;

        else $this->is_valid = false;

        return $this;
    }

    /**
     * Check if the email is from a toxic domain
     *
     * @return $this
     */
    public function isToxic(){

        if(!isset($this->response->toxic)) $this->is_toxic = false;

        else $this->is_toxic = $this->response->toxic;

        return $this;
    }

    /**
     * Checks if the email is from a known minute mail provider
     * (emails that expires after e.g. 10min or 20min)
     *
     * @return $this
     */
    public function isDisposable(){

        if(!isset($this->response->disposable)) $this->is_disposable = false;

        elseif($this->response->disposable) {
            $this->is_disposable = true;

            $this->return_message = 'Sorry we don\'t accept minute mails';

        } else $this->is_disposable = false;

        return $this;
    }

}