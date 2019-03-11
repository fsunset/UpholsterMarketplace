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

        $companyWorkPhotos = array(
            'Detailed Boat Upholstery' => 'http://www.stjohnsucccoop.org/wp-content/uploads/2018/09/Endearing-yacht-upholstery-Backyard-Plans-Free-For-custom-yacht-interior-design.jpg-Gallery.jpg',
            'Furniture Upholstery' => 'http://rvwanderlust.com/wp-content/uploads/2014/03/Before-After-RV-Upholstery-Painting.jpg',
            'Gaming Tables' => 'https://img.evbuc.com/https%3A%2F%2Fcdn.evbuc.com%2Fimages%2F53707362%2F246563307534%2F1%2Foriginal.20181207-221730?w=1000&auto=compress&rect=98%2C0%2C966%2C483&s=0fc604dbaeb58f3cdbf9ad68934bfcef'
        );

        if ($companyId == 4) {
            $companyWorkPhotos = array(
                'Detailed Boat Upholstery' => 'https://static.wixstatic.com/media/761601_37193ad10e1a4bbc9db90c97389bdade~mv2_d_4032_3024_s_4_2.jpg/v1/fill/w_444,h_319,al_c,q_80,usm_0.66_1.00_0.01/tiered%20seating%20with%20our%20cushions.webp',
                'Furniture Upholstery' => 'https://static.wixstatic.com/media/761601_cae4e191ed41435abb67f2a77e9cda00~mv2_d_2468_1512_s_2.jpg/v1/fill/w_707,h_433,al_c,q_80,usm_0.66_1.00_0.01/shop%20dog_JPG.webp',
                'Gaming Tables' => 'https://static.wixstatic.com/media/761601_f229e87e2be545b88ba4e78064509fc0~mv2_d_3264_2448_s_4_2.jpg/v1/fill/w_448,h_334,al_c,q_80,usm_0.66_1.00_0.01/pig%201_JPG.webp'
            );
        }

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
