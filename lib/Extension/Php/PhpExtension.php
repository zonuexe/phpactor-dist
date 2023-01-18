<?php

namespace Phpactor202301\Phpactor\Extension\Php;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\Php\Model\ChainResolver;
use Phpactor202301\Phpactor\Extension\Php\Model\ComposerPhpVersionResolver;
use Phpactor202301\Phpactor\Extension\Php\Model\ConstantPhpVersionResolver;
use Phpactor202301\Phpactor\Extension\Php\Model\PhpVersionResolver;
use Phpactor202301\Phpactor\Extension\Php\Model\RuntimePhpVersionResolver;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class PhpExtension implements Extension
{
    const PARAM_VERSION = 'php.version';
    public function load(ContainerBuilder $container) : void
    {
        $container->register(PhpVersionResolver::class, function (Container $container) {
            $pathResolver = $container->get(FilePathResolverExtension::SERVICE_FILE_PATH_RESOLVER);
            $composerPath = $pathResolver->resolve('%project_root%/composer.json');
            return new ChainResolver(new ConstantPhpVersionResolver($container->getParameter(self::PARAM_VERSION)), new ComposerPhpVersionResolver($composerPath), new RuntimePhpVersionResolver());
        });
    }
    public function configure(Resolver $schema) : void
    {
        $schema->setDefaults([self::PARAM_VERSION => null]);
        $schema->setDescriptions([self::PARAM_VERSION => <<<'EOT'
Consider this value to be the project\'s version of PHP (e.g. `7.4`). If omitted
it will check `composer.json` (by the configured platform then the PHP requirement) before
falling back to the PHP version of the current process.
EOT
]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Php\\PhpExtension', 'Phpactor\\Extension\\Php\\PhpExtension', \false);
