<?php

namespace App\Controller;

class IndexController extends AbstractController
{
    public function home(): string
    {
        return $this->twig->render('home.html.twig');
    }

    public function about(): string
    {
        return "Page à propos";
    }
}
