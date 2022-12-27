<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

final class Reaction
{
    public function __construct(
        public readonly string $author,
        public readonly string $reaction,
    ) {}
}
