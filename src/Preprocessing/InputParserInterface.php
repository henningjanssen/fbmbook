<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing;

interface InputParserInterface
{
    /**
     * @return iterable<ChatParts\ChatPartInterface>
     */
    public function iterate(string $srcDir): iterable;
}
