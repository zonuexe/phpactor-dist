<?php

namespace Phpactor\CodeBuilder\Adapter\TolerantParser\Updater;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor\CodeBuilder\Adapter\TolerantParser\Edits;
use Phpactor\CodeBuilder\Domain\Prototype\TraitPrototype;
class TraitUpdater extends \Phpactor\CodeBuilder\Adapter\TolerantParser\Updater\ClassLikeUpdater
{
    public function updateTrait(Edits $edits, TraitPrototype $classPrototype, TraitDeclaration $classNode) : void
    {
        if (\false === $classPrototype->applyUpdate()) {
            return;
        }
        $this->updateProperties($edits, $classPrototype, $classNode->traitMembers);
        $this->methodUpdater->updateMethods($edits, $classPrototype, $classNode);
    }
    /**
     * @return Node[]
     */
    protected function memberDeclarations(Node $node) : array
    {
        return $node->traitMemberDeclarations;
    }
}
