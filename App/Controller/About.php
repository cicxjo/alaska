<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Render;

class About extends AbstractController
{
    public function goToAbout(): void
    {
        $render = new Render('Page', 'About');
        $render->process([
            'title' => 'À propos',
            'url' => $this->config->getWebsiteUrl(),
            'domain' => $this->config->getWebsiteDomain(),
        ]);
    }
}
