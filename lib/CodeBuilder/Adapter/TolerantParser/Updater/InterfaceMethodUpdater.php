<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\Updater;

use Phpactor202301\Microsoft\PhpParser\ClassLike;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Renderer;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Method;
class InterfaceMethodUpdater extends AbstractMethodUpdater
{
    public function memberDeclarationsNode(ClassLike $classNode)
    {
        return $classNode->interfaceMembers;
    }
    public function renderMethod(Renderer $renderer, Method $method)
    {
        return $renderer->render($method) . ';';
    }
    protected function memberDeclarations(ClassLike $classNode)
    {
        return $classNode->interfaceMembers->interfaceMemberDeclarations;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\TolerantParser\\Updater\\InterfaceMethodUpdater', 'Phpactor\\CodeBuilder\\Adapter\\TolerantParser\\Updater\\InterfaceMethodUpdater', \false);
