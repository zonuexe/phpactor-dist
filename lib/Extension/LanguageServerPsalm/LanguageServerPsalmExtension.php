<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPsalm;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\OptionalExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\DiagnosticProvider\PsalmDiagnosticProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model\Linter;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model\Linter\PsalmLinter;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model\PsalmConfig;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model\PsalmProcess;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class LanguageServerPsalmExtension implements OptionalExtension
{
    public const PARAM_PSALM_BIN = 'language_server_psalm.bin';
    public const PARAM_PSALM_SHOW_INFO = 'language_server_psalm.show_info';
    public function load(ContainerBuilder $container) : void
    {
        $container->register(PsalmDiagnosticProvider::class, function (Container $container) {
            return new PsalmDiagnosticProvider($container->get(Linter::class));
        }, [LanguageServerExtension::TAG_DIAGNOSTICS_PROVIDER => []]);
        $container->register(Linter::class, function (Container $container) {
            return new PsalmLinter($container->get(PsalmProcess::class));
        });
        $container->register(PsalmProcess::class, function (Container $container) {
            $binPath = $container->get(FilePathResolverExtension::SERVICE_FILE_PATH_RESOLVER)->resolve($container->getParameter(self::PARAM_PSALM_BIN));
            $root = $container->get(FilePathResolverExtension::SERVICE_FILE_PATH_RESOLVER)->resolve('%project_root%');
            $shouldShowInfo = $container->getParameter(self::PARAM_PSALM_SHOW_INFO);
            return new PsalmProcess($root, new PsalmConfig($binPath, $shouldShowInfo), LoggingExtension::channelLogger($container, 'PSALM'));
        });
    }
    public function configure(Resolver $schema) : void
    {
        $schema->setDefaults([self::PARAM_PSALM_BIN => '%project_root%/vendor/bin/psalm', self::PARAM_PSALM_SHOW_INFO => \true]);
        $schema->setDescriptions([self::PARAM_PSALM_BIN => 'Path to pslam if different from vendor/bin/psalm', self::PARAM_PSALM_SHOW_INFO => 'If infos from psalm should be displayed']);
    }
    public function name() : string
    {
        return 'language_server_psalm';
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPsalm\\LanguageServerPsalmExtension', 'Phpactor\\Extension\\LanguageServerPsalm\\LanguageServerPsalmExtension', \false);
