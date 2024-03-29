<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Repository;

use Wildledersessel\Fbmbook\Entity\ChatMessage;

interface ChatMessageRepositoryInterface
{
    public function save(ChatMessage $message, bool $flush = true): void;

    /**
     * @return ChatMessage[]
     */
    public function findAll(): array;
}
