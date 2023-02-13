<?php

namespace Phpactor\CodeBuilder\Adapter\TolerantParser\Updater;

use PhpactorDist\Microsoft\PhpParser\ClassLike;
use Phpactor\CodeBuilder\Domain\Renderer;
use Phpactor\CodeBuilder\Domain\Prototype\Method;
class InterfaceMethodUpdater extends \Phpactor\CodeBuilder\Adapter\TolerantParser\Updater\AbstractMethodUpdater
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
