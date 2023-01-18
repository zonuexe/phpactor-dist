<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\Core\CoreExtension;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\LanguageServer\Service\OnDevelopWarningService;
class LanguageServerExtraExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register(OnDevelopWarningService::class, function (Container $container) {
            return new OnDevelopWarningService($container->get(ClientApi::class), $container->get('application.status'), $container->getParameter(CoreExtension::PARAM_WARN_ON_DEVELOP));
        }, [LanguageServerExtension::TAG_SERVICE_PROVIDER => []]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\LanguageServerExtraExtension', 'Phpactor\\Extension\\LanguageServer\\LanguageServerExtraExtension', \false);
