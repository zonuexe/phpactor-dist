<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\Updater;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Renderer;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\Edits;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\InterfacePrototype;
class InterfaceUpdater
{
    private InterfaceMethodUpdater $methodUpdater;
    public function __construct(private Renderer $renderer)
    {
        $this->methodUpdater = new InterfaceMethodUpdater($renderer);
    }
    public function updateInterface(Edits $edits, InterfacePrototype $classPrototype, InterfaceDeclaration $classNode) : void
    {
        $this->methodUpdater->updateMethods($edits, $classPrototype, $classNode);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\TolerantParser\\Updater\\InterfaceUpdater', 'Phpactor\\CodeBuilder\\Adapter\\TolerantParser\\Updater\\InterfaceUpdater', \false);
