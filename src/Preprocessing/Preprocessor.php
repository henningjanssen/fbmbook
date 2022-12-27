<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing;

use Doctrine\ORM\EntityManagerInterface;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\ProcessorInterface;

final class Preprocessor
{
    public function __construct(
        private readonly InputParserInterface $inputParser,
        private readonly ProcessorInterface $partProcessor,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function execute(string $srcDir): void
    {
        foreach ($this->inputParser->iterate($srcDir) as $msg) {
            $this->partProcessor->process($msg);
        }

        $this->entityManager->flush();
    }

    public function __invoke(string $srcDir): void
    {
        $this->execute($srcDir);
    }
}
