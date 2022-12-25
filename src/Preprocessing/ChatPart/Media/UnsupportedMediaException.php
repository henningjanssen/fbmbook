<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media;

use Wildledersessel\Fbmbook\Message\MediaType;

class UnsupportedMediaException extends \Exception {
    public function __construct(MediaType $type)
    {
        parent::__construct(sprintf('Media type %s not supported.', $type->value));
    }
}
