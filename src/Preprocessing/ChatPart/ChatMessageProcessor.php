<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

use Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media\MediaProcessorInterface;
use Wildledersessel\Fbmbook\Repository\ChatMessageRepositoryInterface;
use Wildledersessel\Fbmbook\Entity;

class ChatMessageProcessor implements ChatPartProcessorInterface
{
    public function __construct(
        protected readonly MediaProcessorInterface $mediaProcessor,
        protected readonly ChatMessageRepositoryInterface $entityManager,
    ) {}

    public function process(ChatPartInterface $msg): void
    {
        assert($msg instanceof ChatMessage);
        // TODO: db stuff

        $this->entityManager->save(new Entity\ChatMessage($msg->author, $msg->message ?? "no content", (new \DateTimeImmutable())->setTimestamp($msg->timestamp)));

        foreach($msg->media as $m) {
            $this->mediaProcessor->process($m);
        }
    }

    public function supports(ChatPartInterface $part): bool
    {
        return $part instanceof ChatMessage;
    }
}
