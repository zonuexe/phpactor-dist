<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflector;

use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
interface SourceCodeReflectorFactory
{
    public function create(ServiceLocator $serviceLocator) : SourceCodeReflector;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflector\\SourceCodeReflectorFactory', 'Phpactor\\WorseReflection\\Core\\Reflector\\SourceCodeReflectorFactory', \false);
