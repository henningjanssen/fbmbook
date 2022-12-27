<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Message;

enum MediaType: string
{
    case AUDIO = 'MEDIATYPE_AUDIO';
    case FILE = 'MEDIATYPE_FILE';
    case GIF = 'MEDIATYPE_GIF';
    case IMAGE = 'MEDIATYPE_IMAGE';
    case STICKER = 'MEDIATYPE_STICKER';
    case VIDEO = 'MEDIATYPE_VIDEO';
}
