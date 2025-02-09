<?php

declare(strict_types=1);

/**
 * Copyright (C) Rafał Brauner
 */

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MakerBundle\MakerBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Twig\Extra\TwigExtraBundle\TwigExtraBundle;

return [
    FrameworkBundle::class => ['all' => true],
    DoctrineBundle::class => ['all' => true],
    DoctrineMigrationsBundle::class => ['all' => true],
    MakerBundle::class => ['dev' => true],
    MonologBundle::class => ['all' => true],
    TwigBundle::class => ['all' => true],
    TwigExtraBundle::class => ['all' => true],
    DoctrineFixturesBundle::class => ['dev' => true, 'test' => true],
    DebugBundle::class => ['dev' => true],
    WebProfilerBundle::class => ['dev' => true, 'test' => true],
];
