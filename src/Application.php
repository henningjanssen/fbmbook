<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct(iterable $commands)
    {
        foreach($commands as $command) {
            $this->add($command);
        }

        parent::__construct();
    }
}
