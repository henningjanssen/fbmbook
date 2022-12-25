<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
#[Table('chat_message')]
final class ChatMessage
{
    #[Id]
    #[Column(name: "uuid", type: UuidType::NAME)]
    public Uuid $uuid;
}