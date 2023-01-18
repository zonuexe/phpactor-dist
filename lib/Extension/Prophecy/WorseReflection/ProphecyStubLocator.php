<?php

namespace Phpactor202301\Phpactor\Extension\Prophecy\WorseReflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\InternalLocator;
class ProphecyStubLocator implements SourceCodeLocator
{
    private InternalLocator $locator;
    public function __construct()
    {
        $this->locator = new InternalLocator(['Phpactor202301\\Prophecy\\Prophecy\\ObjectProphecy' => __DIR__ . '/../stubs/Prophecy.stub', 'Phpactor202301\\Prophecy\\Prophecy\\MethodProphecy' => __DIR__ . '/../stubs/Prophecy.stub']);
    }
    public function locate(Name $name) : SourceCode
    {
        return $this->locator->locate($name);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Prophecy\\WorseReflection\\ProphecyStubLocator', 'Phpactor\\Extension\\Prophecy\\WorseReflection\\ProphecyStubLocator', \false);
