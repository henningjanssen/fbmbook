<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Latex;

use Wildledersessel\Fbmbook\Entity\ChatMessage;

final class LatexPrinter
{
    public function print(ChatMessage $message): string
    {
        $author = $message->getAuthor();
        $content = str_replace(['\\', '{', '}', '%', '^', '#', '$', '_', '&'], ['\\\\', '\{', '\}', '\%', '\^{}', '\#', '\$', '\_{}', '\&'], $message->getContent());

        $ret = '';
        $content = preg_replace('/([^\p{L}\p{P}\x00-\x7F]+)/u', '\\emoji{\1}', $content);
        $ret .= "\\fbmessage{" . PHP_EOL;
        $ret .= "\datetime{" . $message->getDateTime()->format('d.m.Y H:i') . "}" . PHP_EOL;
        $ret .= "\sender{" . $author . "}" . PHP_EOL;
        $ret .= "\content{" . $content . "}" . PHP_EOL;
        $ret .= "}" . PHP_EOL;
        $ret .= PHP_EOL;

        return $ret;
    }
}
