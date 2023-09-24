<?php

declare(strict_types = 1);

namespace App\Model;

class Url
{
    private static ?self $instance = null;
    private bool $rewrite;

    private function __construct()
    {
        $this->rewrite = Config::getWebsiteRewrite();
    }

    private static function getInstance(): self
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function buildWithoutRewrite(
        string $action,
        ?array $parameter = null
    ): string {
        $url = '?action=' . $action;

        if ($parameter) {
            foreach ($parameter as $key => $value) {
                $url .= '&' . $key . '=' . $value;
            }
        }

        return $url;
    }

    private function buildWithRewrite(
        string $action,
        ?array $parameter = null
    ): string {
        $url = '/' . $action;

        if ($parameter) {
            foreach ($parameter as $key => $value) {
                $url .= '/' . $value;
            }
        }

        return $url;
    }

    public static function build(
        string $action,
        ?array $parameters = null
    ): string {
        $instance = self::getInstance();
        $url = $instance->rewrite
            ? $instance->buildWithRewrite($action, $parameters)
            : $instance->buildWithoutRewrite($action, $parameters);

        return Config::getUrl() . $url;
    }
}
