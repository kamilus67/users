<?php

namespace App\Controller\Api\User;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User\UserEntity;
use App\Helper\Email;

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
     * @Route("/api/user/{userId}", name="api_user_options_id", methods={"OPTIONS"})
     */
    public function optionsUserIdAction() {
        return $this->optionsAction();
    }

    /**
     * @Route("/api/user", name="api_user_get_collection", methods={"GET"})
     */
    public function getCollectionAction(Request $request) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $em = $this->getDoctrine()->getManager();

        try {
            $result = $em->getRepository(UserEntity::class)->load();

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

    /**
     * @Route("/api/user/{userId}", name="api_user_get", methods={"GET"})
     */
    public function getAction(Request $request, $userId) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $em = $this->getDoctrine()->getManager();

        try {
            $result = $em->getRepository(UserEntity::class)->load($userId);

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

    /**
     * @Route("/api/user", name="api_user_post", methods={"POST"})
     */
    public function postAction(Request $request) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $data = [
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'description' => $request->get('description'),
            'attribute' => $request->get('attribute'),
        ];

        $user = new UserEntity();
        $em = $this->getDoctrine()->getManager();

        try {
            $user->setUser($em, $data);

            $email = new Email();
            $email->sendHello($em->getRepository(UserEntity::class)->load($user->getId()), $em);

            $response->setContent(json_encode([
                "result" => true
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

    /**
     * @Route("/api/user/{userId}", name="api_user_put", methods={"PUT"})
     */
    public function putAction(Request $request, $userId) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $data = [
            'user_id' => $userId,
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'description' => $request->get('description'),
            'attribute' => $request->get('attribute'),
        ];

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(UserEntity::class)->findOneById($userId);

        try {
            if($user) {
                $user->updateUser($em, $data);

                $response->setContent(json_encode([
                    "result" => true
                ]));
            } else {
                throw new Exception("Nie znaleziono użytkownika");
            }
        } catch(Exception $e) {
            $response->setStatusCode(500);
            $response->setContent(json_encode([
                "result" => false,
                "message" => $e->getMessage()
            ]));
        }

        return $response;
    }

    /**
     * @Route("/api/user/{userId}", name="api_user_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $userId) {
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        $user = new UserEntity();
        $em = $this->getDoctrine()->getManager();

        try {
            $user->deleteUser($em, $userId);

            $response->setContent(json_encode([
                "result" => true
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