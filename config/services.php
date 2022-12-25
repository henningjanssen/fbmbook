<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Wildledersessel\Fbmbook\Application;
use Wildledersessel\Fbmbook\Command\PreprocessCommand;
use Wildledersessel\Fbmbook\Doctrine\DoctrineFactory;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\ChatPartProcessorInterface;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media\DelegatingMediaProcessor;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\Media\MediaTypeProcessorInterface;
use Wildledersessel\Fbmbook\Preprocessing\ChatPart\Processor;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;
    $services
        ->instanceof(Command::class)
        ->tag('command')
        ->public()
    ;
    $services
        ->instanceof(MediaTypeProcessorInterface::class)
        ->tag('preprocess.mediatype')
    ;
    $services
        ->instanceof(ChatPartProcessorInterface::class)
        ->tag('preprocess.chattype')
    ;

    $services->load('Wildledersessel\\Fbmbook\\', '../src/');


    $services
        ->set(Application::class)
        ->public()
        ->args([tagged_iterator('command')])
    ;

    $services
        ->set(DelegatingMediaProcessor::class)
        ->public()
        ->args([tagged_iterator('preprocess.mediatype')])
    ;

    $services
        ->set(Processor::class)
        ->public()
        ->args([tagged_iterator('preprocess.chattype')])
    ;

    $services
        ->set(EntityManagerInterface::class, EntityManager::class)
        ->factory(DoctrineFactory::class . '::create')
        ->public()
    ;
};