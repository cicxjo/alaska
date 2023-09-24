<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Config;
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
}
