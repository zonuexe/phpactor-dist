<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflector;

use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Parser\CachedParser;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCodeReflectorFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCodeReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Microsoft\PhpParser\Parser;
class TolerantFactory implements SourceCodeReflectorFactory
{
    private Parser $parser;
    public function __construct(Parser $parser = null)
    {
        $this->parser = $parser ?: new CachedParser();
    }
    public function create(ServiceLocator $serviceLocator) : SourceCodeReflector
    {
        return new TolerantSourceCodeReflector($serviceLocator, $this->parser);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflector\\TolerantFactory', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflector\\TolerantFactory', \false);
