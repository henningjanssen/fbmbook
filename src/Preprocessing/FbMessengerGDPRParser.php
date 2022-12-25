<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Wildledersessel\Fbmbook\Message\MediaType;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\CallType;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\ChatCall;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\ChatInfo;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\ChatMessage;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\DeletedMessage;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media\Media;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\Reaction;

final class FbMessengerGDPRParser implements InputParserInterface
{
    /**
     * {@inheritdoc}
     * @throws \JsonException
     */
    public function iterate(string $srcDir): iterable {
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
                // is it a deleted message?
                if (isset($msg['is_unsent'])) {
                    yield new DeletedMessage(
                        $msg['sender_name'],
                        $msg['timestamp_ms'],
                    );
                    continue;
                }

                // is it a call?
                if (isset($msg['call_duration'])) {
                    yield new ChatCall(
                        $msg['sender_name'],
                        $msg['timestamp_ms'],
                        str_contains($msg['content'], 'video') ? CallType::VIDEO : CallType::AUDIO, // TODO: better and language agnostic detection
                        $msg['call_duration'],
                    );
                    continue;
                }

                // is it a system-message like change of group name, etc.?
                if (false) {
                    // TODO: detect system messages
                    continue;
                }

                // probably a normal message, possibly containing media
                $media = array_merge(
                    $this->aggregateMedia($msg['audio_files'] ?? [], MediaType::AUDIO),
                    $this->aggregateMedia($msg['files'] ?? [], MediaType::FILE), // TODO: find the correct key
                    $this->aggregateMedia($msg['gifs'] ?? [], MediaType::GIF),
                    $this->aggregateMedia($msg['photos'] ?? [], MediaType::IMAGE),
                    $this->aggregateMedia($msg['videos'] ?? [], MediaType::VIDEO),
                    isset($msg['sticker']) ? [new Media($msg['sticker']['uri'], MediaType::STICKER, -1)] : [],
                );

                $reactions = [];
                foreach (($msg['reactions'] ?? []) as $r) {
                    $reactions[] = new Reaction(
                        $r['actor'],
                        $r['reaction'],
                    );
                }

                yield new ChatMessage(
                    $msg['sender_name'],
                    $msg['timestamp_ms'],
                    $msg['content'] ?? null,
                    $media,
                    $reactions,
                    isset($msg['share']) ? [$msg['share']['link']] : [],
                );
            }
        }
    }

    /**
     * @param array<int, array<string, mixed>> $media
     * @return Media[]
     */
    private function aggregateMedia(array $media, MediaType $type): array {
        $agg = [];
        foreach ($media as $m) {
            $agg[] = new Media(
                $this->normalizeMediaSource($m['uri']),
                $type,
                $media['creation_timestamp'] ?? -1,
            );
        }

        return $agg;
    }

    private function normalizeMediaSource(string $src): string {
        // TODO
        return $src;
    }
}
