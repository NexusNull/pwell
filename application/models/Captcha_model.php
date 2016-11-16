<?php

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 10/16/16
 * Time: 4:48 PM
 */
class Captcha_model extends CI_Model
{
    public $errors = NULL;
    public $valid = FALSE;
    private $url = 'https://www.google.com/recaptcha/api/siteverify';
    private $secret = "6LeXZQkUAAAAACCZz0yikjdAELhazoNNQc4cCr7U";
    private $result = NULL;
    private $hostname = NULL;
    private $challenge_ts = NULL;

    public function __construct()
    {
        parent::__construct();
    }

    public function validate($response = NULL, $ip = NULL, $opt = "FGC")
    {
        if ($response == NULL)
            return;

        $fields = array(
            'response' => urlencode($response),
            'secret' => urlencode($this->secret),
        );

        if ($ip != NULL)
            $fields['remoteip'] = urlencode($ip);

        if ($opt != "CURL") {
            $this->file_get_contents($fields);
        } else {
            $this->curl($fields);
        }

        //TODO implement further readouts
        if ($this->result != NULL) {
            if (isset($this->result->success))
                if ($this->result->success) {
                    $this->valid = TRUE;
                } else {
                    if (isset($this->result->errors)) {
                        $this->errors = $this->result->errors;
                    }
                }
        }
    }

    private function file_get_contents($fields)
    {
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($fields)
            )
        );
        $context = stream_context_create($options);
        $this->result = json_decode(file_get_contents($this->url, FALSE, $context));
    }

    private function curl($fields)
    {
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        $this->result = json_decode(curl_exec($ch));
        curl_close($ch);
    }

}