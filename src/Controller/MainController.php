<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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

    /**
	 * @Route("/searchCompany", name="searchCompany")
	 */
    public function searchCompany(Request $request) {
    	if ($request->isXmlHttpRequest()) {
    		
    		$selectedState = $request->request->get('selectedState');
    		$selectedCounty = $request->request->get('selectedCounty');
    		$selectedCity = $request->request->get('selectedCity');

    		$companies = $this->getDoctrine()->getRepository(Company::class)->findBy([
    			"state" => $selectedState,
    			"county" => $selectedCounty,
    			"city" => $selectedCity,
    		]);

    		if (count($companies) < 1) {
    			$htmlCode = "<div class='small-12 cell text-center'><div class='callout primary'><p>There are no Upholsters in that location. Please choose a different search.</p></div></div>";
    		} else {
    			$htmlCode = "";
				foreach ($companies as $company) {
					$htmlCode .= $this->renderView('partials/companyCard.html.twig', ['company' => $company]);
				}
    		}

    		return $this->json(array("htmlCode" => $htmlCode), $status = 200, $headers = array(), $context = array());
    	}

    	throw $this->createNotFoundException('Request incorrect');
    }
}
