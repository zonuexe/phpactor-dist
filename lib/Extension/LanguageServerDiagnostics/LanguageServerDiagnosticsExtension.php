<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerDiagnostics;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\LanguageServerDiagnostics\Model\PhpLinter;
use Phpactor202301\Phpactor\Extension\LanguageServerDiagnostics\Provider\PhpLintDiagnosticProvider;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
class LanguageServerDiagnosticsExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register(PhpLintDiagnosticProvider::class, function (Container $container) {
            return new PhpLintDiagnosticProvider(new PhpLinter(\PHP_BINARY), $container->get(TextDocumentLocator::class));
        }, [LanguageServerExtension::TAG_DIAGNOSTICS_PROVIDER => ['name' => 'php']]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerDiagnostics\\LanguageServerDiagnosticsExtension', 'Phpactor\\Extension\\LanguageServerDiagnostics\\LanguageServerDiagnosticsExtension', \false);
