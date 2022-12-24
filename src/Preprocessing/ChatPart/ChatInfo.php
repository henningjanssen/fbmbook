<?php

declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

class ChatInfo implements ChatPartInterface
{
    /**
     * @param string[] $participants
     */
    public function __construct(
        public readonly string $title,
        public readonly array $participants,
    ) {}
}
