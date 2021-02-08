<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\AppUser;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class AppUserPersister implements ContextAwareDataPersisterInterface
{
    private $decorated;

    public function __construct(
        ContextAwareDataPersisterInterface $decorated,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->decorated = $decorated;
        $this->encoder = $encoder;
    }

    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    public function persist($data, array $context = [])
    {
        if ($data instanceof AppUser) {
            $encoded = $this->encoder->encodePassword($data, $data->getPassword());

            $data->setPassword($encoded);
        } 
        
        $result = $this->decorated->persist($data, $context);

        return $result;
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}
