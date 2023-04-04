<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements DataPersisterInterface{

    private $entityManager;
    private $userPasswordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)

    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function supports($data): bool { 
        return $data instanceof User;
    }

    /**
     * 
     * @param User $data 
     * @return object|void 
     * @throws ORMInvalidArgumentException 
     * @throws ORMException 
     * @throws OptimisticLockException 
     */
    public function persist($data) {
        if($data->getPlainPassword()){
            $data->setPassword(
                $this->userPasswordHasher->hashPassword($data, $data->getPlainPassword())
            );
            $data->eraseCredentials();
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
     }

    public function remove($data) { 
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

}