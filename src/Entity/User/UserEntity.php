<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;

use App\Entity\User\UserEntityInt;
use App\Entity\User\UserEntityVarchar;
use App\Entity\Eav\EavAttributes;

/**
 * @ORM\Entity(repositoryClass="App\Repository\User")
 */
class UserEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getFirstname(){
        return $this->firstname;
    }

    public function setFirstname($firstname){
        $this->firstname = $firstname;
    }

    public function getLastname(){
        return $this->lastname;
    }

    public function setLastname($lastname){
        $this->lastname = $lastname;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function setUser($em, $data) {
        if(empty($data['firstname']) || empty($data['lastname']) || empty($data['email'])) {
            throw new Exception("Uzupełnij wszystkie wymagane pola formularza");
        }

        $this->setFirstname($data['firstname']);
        $this->setLastname($data['lastname']);
        $this->setEmail($data['email']);
        $this->setDescription(($data['description']) ?: '');

        try {
            $em->persist($this);
            $em->flush();
        } catch(Exception $e) {
            throw new Exception("Wystąpił błąd podczas dodawania użytkownika do bazy danych");
        }

        if(count((array)$data['attribute']) > 0) {
            foreach ($data['attribute'] as $attributeCode => $attributeValue) {
                $eavAttribute = $em->getRepository(EavAttributes::class)->findOneByAttributeCode($attributeCode);

                $eavClassName = 'App\Entity\User\UserEntity' . ucfirst($eavAttribute->getEavType());
                $eavClass = new $eavClassName();
                $eavClass->setAttributeId($eavAttribute->getId());
                $eavClass->setEntityId($this->getId());
                $eavClass->setValue($attributeValue);

                try {
                    $em->persist($eavClass);
                    $em->flush();
                } catch (Exception $e) {
                    throw new Exception("Wystąpił błąd podczas dodawania użytkownika do bazy danych");
                }
            }
        }

        return true;
    }

    public function deleteUser($em, $userId) {
        $message = "Wystąpił błąd podczas usuwania użytkownika";

        if(empty($userId)) {
            throw new Exception($message);
        }

        $user = $em->getRepository(UserEntity::class)->findOneById($userId);

        if($user) {
            try {
                $em->remove($user);
                $em->flush();

                $eavInt = $em->getRepository(UserEntityInt::class)->findByEntityId($userId);

                foreach ($eavInt as $item) {
                    try {
                        $em->remove($item);
                        $em->flush();

                        $eavVarchar = $em->getRepository(UserEntityVarchar::class)->findByEntityId($userId);

                        foreach ($eavVarchar as $item) {
                            try {
                                $em->remove($item);
                                $em->flush();
                            } catch (Exception $e) {
                                throw new Exception($message);
                            }
                        }
                    } catch (Exception $e) {
                        throw new Exception($message);
                    }
                }
            } catch (Exception $e) {
                throw new Exception($message);
            }
        } else {
            throw new Exception("Nie znaleziono użytkownika");
        }

        return true;
    }
}