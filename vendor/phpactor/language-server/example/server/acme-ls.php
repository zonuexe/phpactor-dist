#!/usr/bin/env php
<?php 
namespace PhpactorDist;

require __DIR__ . '/../../vendor/autoload.php';
use PhpactorDist\AcmeLs\AcmeLsDispatcherFactory;
use Phpactor\LanguageServer\LanguageServerBuilder;
use PhpactorDist\Psr\Log\NullLogger;
$logger = new NullLogger();
LanguageServerBuilder::create(new AcmeLsDispatcherFactory($logger))->build()->run();
