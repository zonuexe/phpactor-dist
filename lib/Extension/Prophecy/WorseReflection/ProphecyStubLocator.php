<?php

namespace Phpactor\Extension\Prophecy\WorseReflection;

use Phpactor\WorseReflection\Core\Name;
use Phpactor\WorseReflection\Core\SourceCode;
use Phpactor\WorseReflection\Core\SourceCodeLocator;
use Phpactor\WorseReflection\Core\SourceCodeLocator\InternalLocator;
class ProphecyStubLocator implements SourceCodeLocator
{
    private InternalLocator $locator;
    public function __construct()
    {
        $this->locator = new InternalLocator(['PhpactorDist\\Prophecy\\Prophecy\\ObjectProphecy' => __DIR__ . '/../stubs/Prophecy.stub', 'PhpactorDist\\Prophecy\\Prophecy\\MethodProphecy' => __DIR__ . '/../stubs/Prophecy.stub']);
    }
    public function locate(Name $name) : SourceCode
    {
        return $this->locator->locate($name);
    }
}
