<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Wildledersessel\Fbmbook\Entity\ChatMessage;

class DoctrineChatMessageRepository implements ChatMessageRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function save(ChatMessage $message, bool $flush = true): void
    {
        $this->entityManager->persist($message);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function findAll(): array
    {
        $repository = $this->entityManager->getRepository(ChatMessage::class);
        $qb = $repository->createQueryBuilder('m');

        $qb
            ->orderBy('m.dateTime', 'ASC')
        ;


        return $qb->getQuery()->getResult();
    }
}
