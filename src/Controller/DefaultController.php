<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\SearchBarController;
use App\Form\SearchMenuType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index(): Response
    {

        return $this->render('default/index.html.twig');

    }
}
