<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

abstract class BaseChatMessage
{
    public function __construct(
        public readonly string $author,
        public readonly int $timestamp,
    ) {}
}
