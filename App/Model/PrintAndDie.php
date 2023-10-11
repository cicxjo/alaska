<?php

declare(strict_types = 1);

namespace App\Model;

class PrintAndDie
{
    public static function vars(...$vars): void
    {
        foreach ($vars as $var) {
            echo( '<pre>' . print_r($var, true) . '</pre>');
        }

        exit();
    }
}
