<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Render;

class HTTPError extends AbstractController
{
    private int $code;
    private array $httpStatus = [
        404 => 'Ressource introuvable',
        405 => 'Méthode de requête non autorisée',
    ];

    public function __construct(int $code)
    {
        parent::__construct();

        $this->code = $code;
    }

    public function send(): void
    {
        $render = new Render('Page', 'HTTPError');

        http_response_code($this->code);
        $render->process([
            'title' => $this->code . ' - ' . $this->httpStatus[$this->code],
            'url' => $this->config->getWebsiteUrl(),
            'domain' => $this->config->getWebsiteDomain(),
            'message' => $this->code . ' - ' . $this->httpStatus[$this->code],
        ]);
    }
}
