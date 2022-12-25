<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media;

use Wildledersessel\Fbmbook\Message\MediaType;

final class Media
{
    public function __construct(
        public readonly string $src,
        public readonly MediaType $type,
        public readonly int $creationTs,
    ) {}
}
