<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

use Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media\Media;

final class ChatMessage implements ChatPartInterface
{
    /**
     * @param Media[] $media
     * @param Reaction[] $reactions
     */
    public function __construct(
        public readonly string $author,
        public readonly int $timestampInMs,
        public readonly ?string $message,
        public readonly array $media,
        public readonly array $reactions,
        public readonly array $attachedLinks,
    ) {
    }
}
