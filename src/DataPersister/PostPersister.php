<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Personnes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PostPersister implements DataPersisterInterface
{
    public function __construct(protected UserPasswordHasherInterface $hasher, protected EntityManagerInterface $em)
    {
    }

    public function supports($data): bool
    {
        return $data instanceof Personnes;
    }

    public function persist($data)
    {
        $data->setPassword($this->hasher->hashPassword($data, $data->getPassword()));
        $data->setDateEntree(date_format(date_create('now'), 'd-m-Y'));

        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}
