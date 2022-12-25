<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

final class ChatInfoProcessor implements ChatPartProcessorInterface
{
    public function process(ChatPartInterface $msg): void
    {
        // TODO
    }

    public function supports(ChatPartInterface $part): bool
    {
        return $part instanceof ChatInfo;
    }
}
