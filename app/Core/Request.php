<?php

namespace App\Core;

class Request
{
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function uri()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function input($key = null)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            $data = $_POST + $_GET;
        }

        return $key ? ($data[$key] ?? null) : $data;
    }
}
