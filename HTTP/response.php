<?php

namespace Lily\HTTP;

final class Response
{

    // TODO: Read more about the response object
    public function setStatusCode($code)
    {
        http_response_code($code);
    }

    public function sendNotFoundHeader($url)
    {
        session_write_close();
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        include (NOT_FOUND_404);
        exit;
    }
}