<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;  // Add this line
use Symfony\Component\Routing\Annotation\Route;
class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]

    public function ss(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    } 
}
