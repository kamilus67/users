<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use App\Entity\Eav\EavAttributes as EavAttributeEntity;

class EavAttributes extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EavAttributeEntity::class);
    }

    public function getAttributesByEntityTypeId($typeId) {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT a.attributeCode, a.label, a.type FROM App\Entity\Eav\EavAttributes a
                                      WHERE a.entityTypeId IN (:defaultTypeId, :typeId)')
            ->setParameter('defaultTypeId', '0')
            ->setParameter('typeId', $typeId);

        return $query->execute();
    }
}