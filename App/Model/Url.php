<?php

declare(strict_types = 1);

namespace App\Model;

class Url
{
    private static ?self $instance = null;

    public static function getInstance(): self
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function build(string $action, ?int $id = null, ?array $parameters = null): string
    {
        $url = '/' . $action;

        if ($id) {
            $url .= '/' . $id;
        }

        if ($parameters) {
            for ($i=0; $i < count(array_keys($parameters)); $i++) {
                if ($i === 0) {
                    $url .= '?' . array_keys($parameters)[$i] . '=' . $parameters[array_keys($parameters)[$i]];
                } else {
                    $url .= '&' . array_keys($parameters)[$i] . '=' . $parameters[array_keys($parameters)[$i]];
                }
            }
        }

        return $url;
    }
}
