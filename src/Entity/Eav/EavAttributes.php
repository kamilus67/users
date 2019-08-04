<?php

namespace App\Entity\Eav;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class EavAttributes
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
    private $attributeCode;

    /**
     * @ORM\Column(type="integer")
     */
    private $entityTypeId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $eavType;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getAttributeCode(){
        return $this->attributeCode;
    }

    public function setAttributeCode($attributeCode){
        $this->attributeCode = $attributeCode;
    }

    public function getEntityTypeId(){
        return $this->entityTypeId;
    }

    public function setEntityTypeId($entityTypeId){
        $this->entityTypeId = $entityTypeId;
    }

    public function getLabel(){
        return $this->label;
    }

    public function setLabel($label){
        $this->label = $label;
    }

    public function getType(){
        return $this->type;
    }

    public function setType($type){
        $this->type = $type;
    }

    public function getEavType(){
        return $this->eavType;
    }

    public function setEavType($eavType){
        $this->eavType = $eavType;
    }
}