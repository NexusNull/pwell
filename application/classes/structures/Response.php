<?php

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 10/30/16
 * Time: 4:36 PM
 */
class Response
{
    public $status;
    public $msg;
    public $data;

    public function __construct($status = "failure", $msg = "", $data = array())
    {
        $this->msg = $msg;
        $this->status = $status;
        $this->data = $data;

    }


    public function appendMsg($msg = "")
    {
        $this->msg .= "\n" . $msg;
    }

    /**
     * @param string $msg
     */
    public function setMsg($msg = "")
    {
        $this->msg = $msg;
    }

    /**
     * @param array $data
     */
    public function setData($data = array())
    {
        $this->data = $data;
    }


    public function toString()
    {
        if (is_object($this->data) && method_exists($this->data, "toArray")) {
            $data = $this->data->toArray();
        } else if (is_array($this->data)) {
            $data = $this->data;
        } else if (is_string($this->data)) {
            $data = $this->data;
        } else {
            throw (new Exception("Not convertible"));
        }

        $response = array(
            'status' => $this->status,
            'msg' => $this->msg,
            'data' => $data);
        return json_encode($response);
    }
}