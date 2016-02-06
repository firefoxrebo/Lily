<?php
namespace Lily\Session;

class SessionManager extends \SessionHandler
{

    /**
     * @var string The Session Cookie name
     */
    private $sessionName = SESSION_NAME;

    /**
     * @var int The maximum time life in seconds for the session to live
     */
    private $sessionMaxLifetime = SESSION_LIFE_TIME;

    /**
     * @var bool Sending Sessions only using Secure Connections or not
     */
    private $sessionSSL = SESSION_USE_SSL;

    /**
     * @var bool Accessing Sessions using HTTP only or not
     */
    private $sessionHTTPOnly = SESSION_HTTP_ONLY;

    /**
     * @var string The path on which the session is valid
     */
    private $sessionPath = SESSION_PATH;

    /**
     * @var mixed|string The domain name on which the sesion is valid
     */
    private $sessionDomain = SESSION_DOMAIN_NAME;

    /**
     * @var string The session files storage directory path
     */
    private $sessionSavePath = SESSION_SAVE_PATH;

    /**
     * @var string The MCRYPT Cipher Algorithm used to encrypt session data
     */
    private $sessionCipherAlgorithm = SESSION_CIPHER_ALGORITHM;

    /**
     * @var string The MCRYPT Cipher Mode
     */
    private $sessionCipherMode = SESSION_CIPHER_MODE;

    /**
     * @var string A user cipher key
     */
    private $sessionCipherKey = SESSION_USER_CIPHER_KEY;

    /**
     * @var int the minimum time to live used for the session before replacing the cookie
     * with a new id
     */
    private $ttl = 30;

    /**
     * SessionManager constructor.
     */
    public function __construct()
    {

        $this->sessionSSL = isset($_SERVER['HTTPS']) ? true : false;
        $this->sessionDomain = str_replace('www.', '', $_SERVER['SERVER_NAME']);

        // TODO: move these settings to the session config file
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.save_handler', 'files');

        session_name($this->sessionName);

        session_save_path($this->sessionSavePath);

        session_set_cookie_params(
            $this->sessionMaxLifetime, $this->sessionPath,
            $this->sessionDomain, $this->sessionSSL,
            $this->sessionHTTPOnly
        );

        session_set_save_handler($this, true);
    }

    /**
     * Gets a value from the session
     * @param $key
     * @return mixed
     */
    public function __get($key) {
        if(isset($_SESSION[$key])) {
            $data = @unserialize($_SESSION[$key]);
            if($data === false) {
                return $_SESSION[$key];
            } else {
                return $data;
            }
        } else {
            trigger_error('No session key ' . $key . ' exists', E_USER_NOTICE);
        }
    }

    /**
     * Adds a value to the session
     * @param $key
     * @param $value
     */
    public function __set($key, $value) {
        if(is_object($value)) {
            $_SESSION[$key] = serialize($value);
        } else {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * __isset magic method
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($_SESSION[$key]) ? true : false;
    }

    /**
     * Reads data from session
     * @param string $id The session id
     * @return string session data
     */
    public function read($id)
    {
        return mcrypt_decrypt($this->sessionCipherAlgorithm, $this->sessionCipherKey, parent::read($id), $this->sessionCipherMode);
    }

    /**
     * Writes data to session
     * @param string $id the session id
     * @param string $data session data to write
     * @return bool
     */
    public function write($id, $data)
    {
        return parent::write($id, mcrypt_encrypt($this->sessionCipherAlgorithm, $this->sessionCipherKey, $data, $this->sessionCipherMode));
    }

    /**
     * Starts or resuming a session
     */
    public function start()
    {
        if('' === session_id()) {
            if(session_start()) {
                $this->setSessionStartTime();
                $this->checkSessionValidity();
            }
        }
    }

    /**
     * Sets the session start time to compare against the TTL property
     * @return bool
     */
    private function setSessionStartTime()
    {
        if(!isset($this->sessionStartTime)) {
            $this->sessionStartTime = time();
        }
        return true;
    }

    /**
     * Check wither the session file is valid or not
     * @return bool
     */
    private function checkSessionValidity()
    {
        if((time() - $this->sessionStartTime) > ($this->ttl * 60)) {
            $this->renewSession();
            $this->generateFingerPrint();
        }
        return true;
    }

    /**
     * Renews the session with a new one
     * @return bool
     */
    private function renewSession()
    {
        $this->sessionStartTime = time();
        return session_regenerate_id(true);
    }

    /**
     * Kills the session and purge the session data
     */
    public function kill()
    {
        session_unset();

        setcookie(
            $this->sessionName, '', time() - 1000,
            $this->sessionPath, $this->sessionDomain,
            $this->sessionSSL, $this->sessionHTTPOnly
        );

        session_destroy();
    }

    /**
     * Generate a session finger print
     */
    private function generateFingerPrint()
    {
        $userAgentId = $_SERVER['HTTP_USER_AGENT'];
        $this->cipherKey = mcrypt_create_iv(16);
        $sessionId = session_id();
        $this->fingerPrint = md5($userAgentId . $this->cipherKey . $sessionId);
    }

    /**
     * Check if the session is used on the original browser on which
     * it was generated
     * @return bool
     */
    public function isValidFingerPrint()
    {
        if(!isset($this->fingerPrint)) {
            $this->generateFingerPrint();
        }

        $fingerPrint = md5($_SERVER['HTTP_USER_AGENT'] . $this->cipherKey . session_id());

        if($fingerPrint === $this->fingerPrint) {
            return true;
        }

        return false;
    }

    /**
     * Dumps the session data for development purposes
     */
    public function dumpSessionVariables()
    {
        var_dump($_SESSION);
    }

    /**
     * Garbage collecting the session old files
     * @param int $maxLifetime
     * @return void
     */
    public function gc($maxLifetime)
    {
        parent::gc($maxLifetime);
    }
}