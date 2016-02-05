<?php
namespace Lily\HTTP;

final class Request
{

    private $_POSTData;
    private $_GETData;
    private $_SERVERData;

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

    public function isXMLHTTPRequest()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHttpRequest') {
            return true;
        }
        return false;
    }

    public function getReferer()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    public function isPost()
    {
        return isset($_POST) && !empty($_POST);
    }

    public function isGet()
    {
        return isset($_GET) && !empty($_GET);
    }

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

    public function setGetData()
    {
        if($this->isGet()) {
            $this->_GETData = (object) $_GET;
        }
    }

    public function setServerData()
    {
        $this->_SERVERData = (object) $_SERVER;
    }

    public function getPostValue($key)
    {
        if(!property_exists($this->_POSTData, $key)) {
            trigger_error('The requested ' . $key . ' does not exists in the POST request', E_USER_NOTICE);
        }
        return $this->_POSTData->$key;
    }

    public function getQueryValue($key)
    {
        if(!property_exists($this->_GETData, $key)) {
            trigger_error('The requested ' . $key . ' does not exists in the GET request', E_USER_NOTICE);
        }
        return $this->_GETData->$key;
    }

    public function getServerValue($key)
    {
        if(!property_exists($this->_SERVERData, $key)) {
            trigger_error('The requested ' . $key . ' does not exists in the SERVER Super Global', E_USER_NOTICE);
        }
        return $this->_SERVERData->$key;
    }

    public function postHas($property)
    {
        return property_exists($this->_POSTData, $property);
    }

    public function getHas($property)
    {
        return property_exists($this->_GETData, $property);
    }

    public function getPath()
    {
        return parse_url($this->getServerValue('REQUEST_URI'), PHP_URL_PATH);
    }

}