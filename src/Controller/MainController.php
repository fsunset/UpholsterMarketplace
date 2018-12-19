<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Company;


class MainController extends AbstractController {
    /**
	 * @Route("/", name="home")
	 */
    public function index() {
    	$companies = $this->getDoctrine()->getRepository(Company::class)->findAll();

        return $this->render('index.html.twig', [
        	'companies' => $companies,
     	]);
    }

	/**
	 * @Route("/profile/{companyId}/{companyName}", name="profile")
	 */
    public function companyProfile($companyId, $companyName) {
    	$company = $this->getDoctrine()->getRepository(Company::class)->findOneById($companyId);

        return $this->render('profile.html.twig', [
        	'company' => $company,
        ]);
    }
}
