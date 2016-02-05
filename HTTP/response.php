<?php

namespace Lily\HTTP;

final class Response
{

    // TODO: Read more about the response object
    public function setStatusCode($code)
    {
        http_response_code($code);
    }

    public function sendNotFoundHeader()
    {
        session_write_close();
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        exit;
    }
}