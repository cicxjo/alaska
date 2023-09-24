<?php

declare(strict_types = 1);

namespace App\Model;

class Render
{
    private $viewPath;
    private string $layout;
    private string $template;

    public function __construct(string $layout, string $template)
    {
        $this->layout = $layout;
        $this->template = $template;
        $this->viewPath = realpath(getcwd() . '/View/');
    }

    private function getLayoutPath(): string
    {
        return realpath($this->viewPath . '/Layout/' . $this->layout . '.phtml');
    }

    private function getTemplatePath(): string
    {
        return realpath($this->viewPath . '/Template/' . $this->template . '.phtml');
    }

    public function process(array $vars = []): void
    {
        foreach ($vars as $key => $value) {
            $$key = $value;
        }

        ob_start();
        require_once($this->getTemplatePath());
        $vars = ob_get_clean();
        require_once($this->getLayoutPath());
    }
}
