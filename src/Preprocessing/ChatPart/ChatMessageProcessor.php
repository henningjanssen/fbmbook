<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

use Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media\MediaProcessorInterface;

class ChatMessageProcessor implements ChatPartProcessorInterface
{
    public function __construct(
        protected readonly MediaProcessorInterface $mediaProcessor
    ) {}

    public function process(ChatPartInterface $msg): void
    {
        // TODO: db stuff

        foreach($msg->media as $m) {
            $this->mediaProcessor->process($m);
        }
    }

    public function supports(ChatPartInterface $part): bool
    {
        return $part instanceof ChatMessage;
    }
}
