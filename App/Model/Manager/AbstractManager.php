<?php

declare(strict_types = 1);

namespace App\Model\Manager;

use App\Model\Config;
use App\Model\PDOHandler;

abstract class AbstractManager
{
    protected PDOHandler $pdoHandler;
    protected Config $config;

    public function __construct()
    {
        $this->pdoHandler = PDOHandler::getInstance();
        $this->config = Config::getInstance();
    }
}
