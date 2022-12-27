<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media;

interface MediaProcessorInterface
{
    public function process(Media $media): void;
}
