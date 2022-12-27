<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

final class ChatEvent implements ChatPartInterface
{
    /**
     * @param string[] $affectedUsers
     */
    public function __construct(
        public readonly string $author,
        public readonly ChatEventType $type,
        public readonly array $affectedUsers,
        public readonly string $value,
    ){}
}
