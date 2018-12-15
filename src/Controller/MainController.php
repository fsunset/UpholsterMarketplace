<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController {
	/**
	 * @Route("/")
	 */
    public function index() {
        $number = random_int(0, 3);

        return $this->render('index.html.twig', [
            'number' => $number,
        ]);
    }
}
