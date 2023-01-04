<?php

namespace K3\Notification\Repository;

use K3\Notification\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use K3\Repository\Repository as K3Repository;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends K3Repository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Notification::class);
        $this->security = $security;
    }

    public function getFiltersCriteria(array $filters): Criteria
    {
        $filtersBag = $this->prepareFiltersCriteria($filters);

        $criteria = Criteria::create();

        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $user = $this->security->getUser();
            if ($user !== null) {
                $criteria->andWhere(Criteria::expr()->eq('username', $user->getUsername()));
            }
        }
        if ($filtersBag->has('daily')) {
            $criteria->andWhere(Criteria::expr()->gt('created', (new \DateTime())->modify('-1 day')));
        }

        return $criteria;
    }

}
