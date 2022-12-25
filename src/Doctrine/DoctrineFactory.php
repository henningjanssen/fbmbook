<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Doctrine;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Bridge\Doctrine\Types\UuidType;

final class DoctrineFactory
{
    public static function create(): EntityManager
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__."/../Entity"),
            isDevMode: true,
        );

        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/../../data/db.sqlite',
        ], $config);

        Type::addType(UuidType::NAME, UuidType::class);

        return new EntityManager($connection, $config);
    }
}