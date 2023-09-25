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
            for ($i=0; $i < count($parameters); $i++) {
                $parameters = current($parameters);

                if ($i === 0) {
                    $url .= '?' . key($parameters[$i]) . '=' . $parameters[$i];
                } else {
                    $url .= '&' . key($parameters[$i]) . '=' . $parameters[$i];
                }
            }
        }

        return $url;
    }
}
