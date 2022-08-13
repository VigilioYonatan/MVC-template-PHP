<?php

function debuguear($var): void
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

function request()
{
    return $_SERVER['REQUEST_METHOD'];
}

function statusCode($num = 200)
{
    http_response_code($num);
}
function cleanHtml($html): string
{
    return htmlspecialchars($html);
}