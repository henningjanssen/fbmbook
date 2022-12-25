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

    public function save(ChatMessage $message): void
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(ChatMessage::class)->findAll();
    }
}
