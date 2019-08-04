<?php

namespace App\Entity\Eav;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class EavAttributesOption
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $attributeId;

    /**
     * @ORM\Column(type="string", length=255)
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

    public function getValue(){
        return $this->value;
    }

    public function setValue($value){
        $this->value = $value;
    }
}