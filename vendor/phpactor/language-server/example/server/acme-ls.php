#!/usr/bin/env php
<?php 
namespace Phpactor202301;

require __DIR__ . '/../../vendor/autoload.php';
use Phpactor202301\AcmeLs\AcmeLsDispatcherFactory;
use Phpactor\LanguageServer\LanguageServerBuilder;
use Phpactor202301\Psr\Log\NullLogger;
$logger = new NullLogger();
LanguageServerBuilder::create(new AcmeLsDispatcherFactory($logger))->build()->run();
