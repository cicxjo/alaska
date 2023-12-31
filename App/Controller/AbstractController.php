<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Config;
use App\Model\Exception\HTTPException;
use App\Model\Url;

abstract class AbstractController
{
    protected Config $config;
    protected Url $url;

    public function __construct()
    {
        $this->config = Config::getInstance();
        $this->url = Url::getInstance();
    }

    protected function isValidId(string $id): bool
    {
        if (ctype_digit($id)) {
            return true;
        } else {
            throw new HTTPException(404);
            return false;
        }
    }

    protected function isNotEmpty(string $string): bool
    {
        return !empty($string) && !ctype_space($string) ? true : false;
    }
}
