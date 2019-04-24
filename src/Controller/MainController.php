<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Company;
use App\Entity\Customer;


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
        $companyWorkPhotos = array();

        $path  = getcwd() . '/build/img/company/samples/' . $companyId . "/";
        $files = scandir($path);

        $domainURLForImages = $_SERVER['HTTP_HOST'] . "/build/img/company/samples/" . $companyId. "/";

        if (strpos($domainURLForImages, "localhost:8000") == false){ // For localhost develop
            $domainURLForImages = "http://localhost:8000" . "/build/img/company/samples/" . $companyId. "/";
        }

        $companyWorkPhotos = array(
            'Image 1' => $domainURLForImages . $files[2],
            'Image 2' => $domainURLForImages . $files[3],
            'Image 3' => $domainURLForImages . $files[4]
        );        

        return $this->render('profile.html.twig', [
        	'company' => $company,
            'companyWorkPhotos' => $companyWorkPhotos
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

    /**
	 * @Route("/customerData", name="customerData")
	 */
    public function customerData(Request $request) {
    	if ($request->isXmlHttpRequest()) {
    		
    		$entityManager = $this->getDoctrine()->getManager();

	        $customer = new Customer();
	        $customer->setName($request->request->get('nameFieldVal'));
	        $customer->setPhone($request->request->get('phoneFieldVal'));
	        $customer->setEmail($request->request->get('emailFieldVal'));
	        $customer->setServicesDesired($request->request->get('servicesDesiredFieldVal'));
	        $customer->setMessage($request->request->get('messageFieldVal'));

	        $entityManager->persist($customer);
	        $entityManager->flush();

	        return $this->json(array("alert" => "Thanks, your message has been sent! We'll be in touch soon."), $status = 200, $headers = array(), $context = array());
    	}

    	throw $this->createNotFoundException('Request incorrect');
    }
}
