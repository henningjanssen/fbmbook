<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

enum CallType: string
{
    case AUDIO = 'CALLTYPE_AUDIO';
    case VIDEO = 'CALLTYPE_VIDEO';
}
