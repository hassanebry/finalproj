<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ConfigController extends AbstractController
{
    private $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/themes/theme/{theme}", name="theme")
     */
    public function changementTheme($theme, Request $request)
    {
      $this->session->set('theme',$theme);
      return $this->redirect($request->server->get('HTTP_REFERER'));
    }
}
