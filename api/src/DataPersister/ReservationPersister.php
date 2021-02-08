<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Reservation;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class ReservationPersister implements ContextAwareDataPersisterInterface
{
    private TokenStorageInterface $tokenStorage;
    private EntityManager $em;
    
    public function __construct(TokenStorageInterface $security, EntityManager $entityManager)
    {
        $this->tokenStorage = $security;
        $this->em = $entityManager;
    }
    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Reservation;
    }

    public function persist($data, array $context = [])
    {
        $user = $this->tokenStorage->getToken()->getUser();
        
        $data->setAppUser($user);
        
        $this->em->persist($data);
        $this->em->flush();
        
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}
