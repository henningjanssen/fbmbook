<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\ChatInfo;

final class GDPRParser implements InputParserInterface
{
    /**
     * {@inheritdoc}
     * @throws \JsonException
     */
    public function iterate(string $srcDir): iterable
    {
        $finder = new Finder();
        $finder
            ->files()
            ->in($srcDir)
            ->name('message_*.json')
        ;

        if (!$finder->hasResults()) {
            // TODO: custom exception
            throw new \Exception('I');
        }

        foreach ($finder as $file) {
            $fileContent = $file->getContents();
            $data = json_decode($fileContent, true, flags: JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR);
            
            $participants = [];
            foreach ($data['participants'] as $p) {
                $participants[] = $p['name'];
            }
            yield new ChatInfo($data['title'], $participants);

            foreach ($data['messages'] as $msg) {
                //
            }
        }
    }

    private function validate(string $srcDir): bool
    {
        if(true) {
            return true;
        }
        return true;
    }
}
