<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

use Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media\UnsupportedMediaException;

class Processor implements ProcessorInterface
{
    /**
     * @var ChatPartProcessorInterface[]
     */
    protected readonly array $partProcessors;

    /**
     * @param iterable<ChatPartProcessorInterface> $partProcessors
     */
    public function __construct(
        iterable $partProcessors
    ) {
        $this->partProcessors = iterator_to_array($partProcessors);
    }

    public function process(ChatPartInterface $msg): void
    {
        foreach ($this->partProcessors as $p) {
            if ($p->supports($msg)) {
                try {
                    $p->process($msg);
                } catch (UnsupportedMediaException) {
                    // TODO: None implemented yet
                }
            }
        }
    }
}
