<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use App\Entity\Eav\EavAttributesOption as EavAttributesOptionEntity;

class EavAttributesOption extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EavAttributesOptionEntity::class);
    }

    public function findAllOptions() {
        $result = $this->findAll();

        $data = [];
        foreach($result as $item) {
            $data[] = [
                "value" => $item->getAttributeId(),
                "label" => $item->getValue()
            ];
        }

        return $data;
    }
}