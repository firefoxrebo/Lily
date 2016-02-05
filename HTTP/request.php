<?php
namespace Lily\HTTP;

final class Request
{

    /**
     * @var object The POST RAW DATA
     */
    private $_POSTData;

    /**
     * @var object The GET SUPER GLOBAL ARRAY DATA
     */
    private $_GETData;

    /**
     * @var object The SERVER SUPER GLOBAL ARRAY DATA
     */
    private $_SERVERData;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        if($this->isPost()) {
            $this->setPostData();
        }

        if($this->isGet()) {
            $this->setGetData();
        }

        $this->setServerData();
    }

    /**
     * Check wither the request is an AJAX Request
     * @return bool
     */
    public function isXMLHTTPRequest()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHttpRequest') {
            return true;
        }
        return false;
    }

    /**
     * Get the REFERER header
     * @return mixed
     */
    public function getReferer()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * Check wither the request is a POST request
     * @return bool
     */
    public function isPost()
    {
        return isset($_POST) && !empty($_POST);
    }

    /**
     * Check wither the request is a POST request
     * @return bool
     */
    public function isGet()
    {
        return isset($_GET) && !empty($_GET);
    }

    /**
     * Sets the POST RAW Data
     */
    public function setPostData()
    {
        if($this->isPost()) {
            $phpWrapper = 'php://input';
            $postRawContent = file_get_contents($phpWrapper);
            if(strlen($postRawContent) > 0) {
                parse_str($postRawContent, $postData);
                $this->_POSTData = (object) $postData;
            }
        }
    }

    /**
     * Sets the GET Object Data
     */
    public function setGetData()
    {
        if($this->isGet()) {
            $this->_GETData = (object) $_GET;
        }
    }

    /**
     * Sets the SERVER object Data
     */
    public function setServerData()
    {
        $this->_SERVERData = (object) $_SERVER;
    }

    /**
     * Returns a given value from the POST DATA
     * @param $key
     * @return mixed
     */
    public function getPostValue($key)
    {
        if(!property_exists($this->_POSTData, $key)) {
            trigger_error('The requested ' . $key . ' does not exists in the POST request', E_USER_NOTICE);
        }
        return $this->_POSTData->$key;
    }

    /**
     * Returns a given value from the GET DATA
     * @param $key
     * @return mixed
     */
    public function getQueryValue($key)
    {
        if(!property_exists($this->_GETData, $key)) {
            trigger_error('The requested ' . $key . ' does not exists in the GET request', E_USER_NOTICE);
        }
        return $this->_GETData->$key;
    }

    /**
     * Returns a given value from the SERVER DATA
     * @param $key
     * @return mixed
     */
    public function getServerValue($key)
    {
        if(!property_exists($this->_SERVERData, $key)) {
            trigger_error('The requested ' . $key . ' does not exists in the SERVER Super Global', E_USER_NOTICE);
        }
        return $this->_SERVERData->$key;
    }

    /**
     * Check wither a value exists in the POST RAW DATA
     * @param $property
     * @return bool
     */
    public function postHas($property)
    {
        return property_exists($this->_POSTData, $property);
    }

    /**
     * Check wither a value exists in the GET DATA
     * @param $property
     * @return bool
     */
    public function getHas($property)
    {
        return property_exists($this->_GETData, $property);
    }

    /**
     * Returns the URL PATH
     * @return mixed
     */
    public function getPath()
    {
        return parse_url($this->getServerValue('REQUEST_URI'), PHP_URL_PATH);
    }

    /**
     * Returns the HTTP Request Method
     * @return mixed
     */
    public function getMethod()
    {
        return $this->_SERVERData->REQUEST_METHOD;
    }

}