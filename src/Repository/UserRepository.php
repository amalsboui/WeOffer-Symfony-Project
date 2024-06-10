<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    // public function findOneBySomeField($userId): ?User
    //{
    //  return $this->createQueryBuilder('u')
    //    ->andWhere('u.id = :userId')
    //  ->setParameter('userId', $userId)
    //   ->getQuery()
    //   ->getOneOrNullResult()
    // ;
    // }
    public function countJobSeekers(): int
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('COUNT(u.id)')
            ->where('u.user_type = :jobSeekerType')
            ->setParameter('jobSeekerType', 'job_seeker');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countRecruiters(): int
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('COUNT(u.id)')
            ->where('u.user_type = :recruiterType')
            ->setParameter('recruiterType', 'recruiter');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
    public function countUsers():int
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('COUNT(u.id) as totalUsers');
        return (int) $qb->getQuery()->getSingleScalarResult();
    }




}
