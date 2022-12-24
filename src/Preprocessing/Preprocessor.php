<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing;

final class Preprocessor
{
    public function __construct(
        private readonly InputParserInterface $inputParser
    ) {}

    public function execute(string $srcDir): void
    {
        $this->inputParser->iterate($srcDir);
    }

    public function __invoke(string $srcDir): void
    {
        $this->execute($srcDir);
    }
}
