<?php

namespace App\Repository;

use App\Entity\User\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class User extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }

    /**
     * @param $userId
     * @return array
     * @throws Exception
     */
    public function load($userId) {
        $user = $this->findOneById($userId);

        if($user) {
            $eavTypes = $this->getEavTypes();
            if(count($eavTypes) > 0) {
                $em = $this->getEntityManager();
                $userAttributes = [];
                foreach($eavTypes as $eavType) {
                    $query = $em->createQuery(
                        'SELECT a.attributeCode, a.entityTypeId, a.label, a.type, b.value
                            FROM App\Entity\Eav\EavAttributes a
                            INNER JOIN App\Entity\User\UserEntity'.ucfirst($eavType).' b
                            WITH a.id = b.attributeId
                            WHERE b.entityId ='.$userId
                    );
                    $result = $query->execute();
                    foreach($result as $attribute) {
                        $userAttributes[($attribute['attributeCode'])] = $attribute;
                    }
                }
            }

            $userData = [
                "id" => $user->getId(),
                "firstname" => $user->getFirstname(),
                "lastname" => $user->getLastname(),
                "email" => $user->getEmail(),
                "description" => $user->getDescription()
            ];

            if(isset($userAttributes)) {
                $userData['attributes'] = $userAttributes;
            }

            return $userData;
        } else {
            throw new Exception("Nie znaleziono użytkownika");
        }
    }

    /**
     * @return array
     */
    private function getEavTypes() {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT a.eavType FROM App\Entity\Eav\EavAttributes a
                GROUP BY a.eavType'
        );

        $data = [];
        foreach($query->execute() as $item) {
            $data[] = $item['eavType'];
        }

        return $data;
    }
}