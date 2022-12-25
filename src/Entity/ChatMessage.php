<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
#[Table('chat_message')]
class ChatMessage
{
    #[Id]
    #[Column(name: "uuid", type: UuidType::NAME)]
    private Uuid $uuid;

    public function __construct(
        #[Column(name: "author", type: Types::STRING)]
        private string $author,
        #[Column(name: "content", type: Types::STRING)]
        private string $content,
        #[Column(name: "datetime", type: Types::DATETIME_IMMUTABLE)]
        private \DateTimeImmutable $dateTime,
    ) {
        $this->uuid = Uuid::v4();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDateTime(): \DateTimeImmutable
    {
        return $this->dateTime;
    }
}
