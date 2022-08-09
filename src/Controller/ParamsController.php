<?php

namespace App\Controller;





use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ParamsController extends AbstractController
{
    /**
     * @Route("/params", name="params")
     */
    public function index(): Response
    {
        return $this->render('params/index.html.twig');
    }

    
}



    
    

    
    



