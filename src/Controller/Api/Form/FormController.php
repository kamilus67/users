<?php

namespace App\Controller\Api\Form;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Eav\EavAttributesOption;

class FormController extends AbstractController
{
    /**
     * @Route("/api/user", name="api_user_options", methods={"OPTIONS"})
     */
    public function optionsAction() {
        $response = new Response();
        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->headers->set("Access-Control-Allow-Methods", "GET");
        return $response;
    }

    /**
     * @Route("/api/form/get-options", name="api_form_get_options", methods={"GET"})
     */
    public function getOptions(Request $request) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $em = $this->getDoctrine()->getManager();

        try {
            $result = $em->getRepository(EavAttributesOption::class)->findAllOptions();

            $response->setContent(json_encode([
                "result" => true,
                "content" => $result
            ]));
        } catch(Exception $e) {
            $response->setStatusCode(500);
            $response->setContent(json_encode([
                "result" => false,
                "message" => $e->getMessage()
            ]));
        }

        return $response;
    }
}