<?php

namespace App\Controller\Api\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user", name="api_user_options", methods={"OPTIONS"})
     */
    public function optionsAction() {
        $response = new Response();
        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->headers->set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE");
        return $response;
    }

    /**
     * @Route("/api/user", name="api_user_get_collection", methods={"GET"})
     */
    public function getCollectionAction(Request $request) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $response->setContent(json_encode([
            "result" => true,
            "content" => "..."
        ]));

        return $response;
    }

    /**
     * @Route("/api/user/{userId}", name="api_user_get", methods={"GET"})
     */
    public function getAction(Request $request, $userId) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $response->setContent(json_encode([
            "result" => true,
            "content" => $userId
        ]));

        return $response;
    }

    /**
     * @Route("/api/user", name="api_user_post", methods={"POST"})
     */
    public function postAction(Request $request) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $response->setContent(json_encode([
            "result" => true,
            "content" => "..."
        ]));

        return $response;
    }

    /**
     * @Route("/api/user/{userId}", name="api_user_put", methods={"PUT"})
     */
    public function putAction(Request $request, $userId) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $response->setContent(json_encode([
            "result" => true,
            "content" => $userId
        ]));

        return $response;
    }

    /**
     * @Route("/api/user/{userId}", name="api_user_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $userId) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $response->setContent(json_encode([
            "result" => true,
            "content" => $userId
        ]));

        return $response;
    }
}