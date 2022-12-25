<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

interface ChatPartProcessorInterface
{
    public function process(ChatPartInterface $part): void;
    public function supports(ChatPartInterface $part): bool;
}
