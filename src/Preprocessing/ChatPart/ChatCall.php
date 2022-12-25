<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

final class ChatCall implements ChatPartInterface
{
    public function __construct(
        public readonly string $author,
        public readonly int $timestamp,
        public readonly CallType $type,
        public readonly int $duration,
    )
    {
        
    }
}
