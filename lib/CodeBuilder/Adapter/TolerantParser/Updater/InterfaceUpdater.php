<?php

namespace Phpactor\CodeBuilder\Adapter\TolerantParser\Updater;

use Phpactor\CodeBuilder\Domain\Renderer;
use Phpactor\CodeBuilder\Adapter\TolerantParser\Edits;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
use Phpactor\CodeBuilder\Domain\Prototype\InterfacePrototype;
class InterfaceUpdater
{
    private \Phpactor\CodeBuilder\Adapter\TolerantParser\Updater\InterfaceMethodUpdater $methodUpdater;
    public function __construct(private Renderer $renderer)
    {
        $this->methodUpdater = new \Phpactor\CodeBuilder\Adapter\TolerantParser\Updater\InterfaceMethodUpdater($renderer);
    }
    public function updateInterface(Edits $edits, InterfacePrototype $classPrototype, InterfaceDeclaration $classNode) : void
    {
        $this->methodUpdater->updateMethods($edits, $classPrototype, $classNode);
    }
}
