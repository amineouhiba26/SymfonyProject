<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    #[Route('/lucky', name: 'app')]
    public function ss(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>piw piw</body></html>'
        );
    }
}
