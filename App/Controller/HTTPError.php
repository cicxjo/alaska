<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Config;
use App\Model\Render;

class HTTPError
{
    private static array $httpStatus = [404 => 'Ressource introuvable'];

    public static function send(int $code)
    {
        $render = new Render('Page', 'HTTPError');

        http_response_code($code);
        $render->process([
            'title' => $code . ' - ' . self::$httpStatus[$code],
            'url' => Config::getUrl(),
            'domain' => Config::getDomain(),
            'message' => $code . ' - ' . self::$httpStatus[$code],
        ]);
    }
}
