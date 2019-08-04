<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserEntityInt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $attributeId;

    /**
     * @ORM\Column(type="integer")
     */
    private $entityId;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getAttributeId(){
        return $this->attributeId;
    }

    public function setAttributeId($attributeId){
        $this->attributeId = $attributeId;
    }

    public function getEntityId(){
        return $this->entityId;
    }

    public function setEntityId($entityId){
        $this->entityId = $entityId;
    }

    public function getValue(){
        return $this->value;
    }

    public function setValue($value){
        $this->value = $value;
    }
}