<?php

namespace App\Service;

use App\Entity\Chix;
use App\Entity\ChixApprove;
use App\Entity\User;
use App\Repository\ChixApproveRepository;
use App\Repository\ChixRepository;
use App\Value\FamousStatement;
use Doctrine\ORM\EntityManagerInterface;

class ChixService
{
    /** @var ChixRepository */
    private $chixRepository;

    /** @var ChixApproveRepository */
    private $approveRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ChixRepository $chixRepository,
        ChixApproveRepository $approveRepository,
        EntityManagerInterface $entityManager

    ) {
        $this->chixRepository = $chixRepository;
        $this->approveRepository = $approveRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $chixId
     * @param User $user
     * @return array
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function get(int $chixId, User $user): array
    {
        $chix = $this->chixRepository->get($chixId);

        $isCanApprove = !$chix->getUser()->isEqual($user);

        if ($isCanApprove) {
            $approve = $this->approveRepository->findOneByUserAndChix($user->getId(), $chixId);
            $isCanApprove = $approve === null;
        }

        $statement = new FamousStatement($chix->getCreatedAt()->getTimestamp());

        return compact('chix', 'isCanApprove', 'statement');
    }

    /**
     * @param User $user
     * @return int
     */
    public function add(User $user): int
    {
        $chix = new Chix();
        $chix->setUser($user);

        $this->entityManager->persist($chix);
        $this->entityManager->flush();

        return $chix->getId();
    }

    /**
     * @param int $chixId
     * @param User $user
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function approve(int $chixId, User $user): void
    {
        $chix = $this->chixRepository->get($chixId);

        $username = $user->getUsername();
        if ($chix->getUser()->isEqual($user)) {
            throw new \LogicException("Denied approve for yourself: $username");
        }

        $approve = $this->approveRepository->findOneByUserAndChix($user->getId(), $chixId);

        if ($approve) {
            throw new \LogicException("Approve already has: {$approve->getId()}, user: $username");
        }

        $approve = new ChixApprove();
        $approve->setUser($user);
        $approve->setChix($chix);

        $this->entityManager->persist($approve);
        $this->entityManager->flush();
    }
}
