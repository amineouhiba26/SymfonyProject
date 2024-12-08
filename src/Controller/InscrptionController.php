<?php

namespace App\Controller;
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Attribute\Route;

class InscrptionController extends AbstractController
{
    #[Route('/number', name: 'app_number')]
    public function number(): Response


    {
        
        $number = random_int(0,100) ;
        return $this->render('Inscription/accueil.html.twig', [
            'number' => $number,
            ]);

            
    }
    #[Route('/voir/{id}', name: 'voir')]

    public function voirAction($id){
        return $this->render('Inscription/voir.html.twig',
        array('id'=>$id));
        }
}
