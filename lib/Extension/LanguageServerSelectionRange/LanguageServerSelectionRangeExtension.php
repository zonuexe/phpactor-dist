<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerSelectionRange;

use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\LanguageServerSelectionRange\Handler\SelectionRangeHandler;
use Phpactor202301\Phpactor\Extension\LanguageServerSelectionRange\Model\RangeProvider;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class LanguageServerSelectionRangeExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register(SelectionRangeHandler::class, function (Container $container) {
            return new SelectionRangeHandler($container->get(LanguageServerExtension::SERVICE_SESSION_WORKSPACE), $container->get(RangeProvider::class));
        }, [LanguageServerExtension::TAG_METHOD_HANDLER => []]);
        $container->register(RangeProvider::class, function (Container $container) {
            return new RangeProvider(new Parser());
        });
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerSelectionRange\\LanguageServerSelectionRangeExtension', 'Phpactor\\Extension\\LanguageServerSelectionRange\\LanguageServerSelectionRangeExtension', \false);
