<?php

namespace Phpactor\CodeBuilder\Adapter\TolerantParser\Updater;

use PhpactorDist\Microsoft\PhpParser\ClassLike;
use PhpactorDist\Microsoft\PhpParser\Node\InterfaceMembers;
use Phpactor\CodeBuilder\Domain\Renderer;
use Phpactor\CodeBuilder\Domain\Prototype\Method;
use PhpactorDist\Microsoft\PhpParser\Node;
/**
 * @extends AbstractMethodUpdater<InterfaceMembers>
 */
class InterfaceMethodUpdater extends \Phpactor\CodeBuilder\Adapter\TolerantParser\Updater\AbstractMethodUpdater
{
    /**
     * @return InterfaceMembers
     */
    public function memberDeclarationsNode(ClassLike $classNode)
    {
        return $classNode->interfaceMembers;
    }
    public function renderMethod(Renderer $renderer, Method $method) : string
    {
        return $renderer->render($method) . ';';
    }
    /** @return array<Node> */
    protected function memberDeclarations(ClassLike $classNode) : array
    {
        return $classNode->interfaceMembers->interfaceMemberDeclarations;
    }
}
