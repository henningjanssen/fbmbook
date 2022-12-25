<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media;

use Exception;

final class DelegatingMediaProcessor implements MediaProcessorInterface
{
    /**
     * @var array<string, MediaTypeProcessorInterface[]>
     */
    private readonly array $mediaProcessors;

    /**
     * @param iterable<MediaTypeProcessorInterface> $mediaProcessors
     */
    public function __construct(iterable $mediaProcessors)
    {
        foreach ($mediaProcessors as $mp) {
            foreach ($mp->getSupportedTypes as $type) {
                if (!isset($this->mediaProcessors[$type->value])) {
                    $this->mediaProcessors[$type->value] = [];
                }
                $this->mediaProcessors[$type->value] = $mp;
            }
        }
    }

    public function process(Media $media): void
    {
        if (!isset($this->mediaProcessors[$media->type])) {
            throw new UnsupportedMediaException($media->type);
        }

        foreach ($this->mediaProcessors[$media->type] as $proc) {
            $proc->process($media);
        }
    }
}
