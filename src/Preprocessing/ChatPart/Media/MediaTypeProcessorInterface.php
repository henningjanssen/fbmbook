<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media;

use Wildledersessel\Fbmbook\Message\MediaType;

interface MediaTypeProcessorInterface
{
    public function process(Media $media): void;

    /**
     * @return MediaType[]
     */
    public function supportedMediaTypes(): array;
}
