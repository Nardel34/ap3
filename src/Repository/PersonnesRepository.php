<?php

namespace App\Repository;

use App\Entity\Personnes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method Personnes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personnes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personnes[]    findAll()
 * @method Personnes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnesRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personnes::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Personnes) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findByRole(string $role, $id)
    {
        return $this->createQueryBuilder('u')
            ->Where('u.id <> :id')
            ->andWhere('u.roles LIKE :role')
            ->setParameter('id', $id)
            ->setParameter('role', '%ROLE_' . $role . '%')
            ->getQuery()
            ->getResult();
    }
}
