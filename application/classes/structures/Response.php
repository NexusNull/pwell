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
    // [Info 1xx]
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_Processing = 102;
    // [Successful 2xx]
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    // [Redirection 3xx]
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_UNUSED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    // [Client Error 4xx]
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    // [Server Error 5xx]
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;


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


    public function toString($type = "xml")
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

        $response = array('status' => $this->status, 'msg' => $this->msg, 'data' => $data);

        if ($type == "json") {
            return json_encode($response);
        } elseif ($type == "xml") {
            return $this->xml_encode($response);
        } else {
            return json_encode($response);
        }
    }

    public function output($statusCode)
    {
        $type = Response::getBestSupportedMimeType(["application/json","application/xml"]);
        if($type == "application/xml") {
            set_status_header($statusCode);
            header("Content-Type: application/xml");
            echo $this->toString("xml");
        } else if($type == "application/xml") {
            set_status_header($statusCode);
            header("Content-Type: application/json");
            echo $this->toString("json");
        } else {
            set_status_header($statusCode);
            header("Content-Type: application/json");
            echo $this->toString("json");
        }
        exit;
    }

    private static function xml_encode($data)
    {
        // creating object of SimpleXMLElement
        $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

        // function call to convert array to xml
        Response::array_to_xml($data, $xml_data);
        return $xml_data->asXML();
    }

    private static function array_to_xml($data, &$xml_data)
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item' . $key; //dealing with <0/>..<n/> issues
            }
            if (is_array($value)) {
                $subnode = $xml_data->addChild($key);
                Response::array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
    private static function getBestSupportedMimeType($mimeTypes = null) {
        // Values will be stored in this array
        $AcceptTypes = Array ();

        // Accept header is case insensitive, and whitespace isn’t important
        $accept = strtolower(str_replace(' ', '', $_SERVER['HTTP_ACCEPT']));
        // divide it into parts in the place of a ","
        $accept = explode(',', $accept);
        foreach ($accept as $a) {
            // the default quality is 1.
            $q = 1;
            // check if there is a different quality
            if (strpos($a, ';q=')) {
                // divide "mime/type;q=X" into two parts: "mime/type" i "X"
                list($a, $q) = explode(';q=', $a);
            }
            // mime-type $a is accepted with the quality $q
            // WARNING: $q == 0 means, that mime-type isn’t supported!
            $AcceptTypes[$a] = $q;
        }
        arsort($AcceptTypes);

        // if no parameter was passed, just return parsed data
        if (!$mimeTypes) return $AcceptTypes;

        $mimeTypes = array_map('strtolower', (array)$mimeTypes);

        // let’s check our supported types:
        foreach ($AcceptTypes as $mime => $q) {
            if ($q && in_array($mime, $mimeTypes)) return $mime;
        }
        // no mime-type found
        return null;
    }
}
