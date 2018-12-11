<?php


/**
 * Class Response
 */


class Response {


    public $status;
    public $data;
    public $error;
    public $errors;


    /**
     * Verify the response status.
     *
     * @return boolean True if success.
     */
    public function is_success() {
        return isset($this->status)
            && (
                ($this->status == 200)
                || ($this->status == 201)
                || ($this->status == 204));
    }
    /**
     * Check if response has data
     *
     * @return boolean True if success.
     */
    public function has_data() {
        return isset($this->data);
    }


}