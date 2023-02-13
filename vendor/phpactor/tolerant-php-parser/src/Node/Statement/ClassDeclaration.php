<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Statement;

use PhpactorDist\Microsoft\PhpParser\ClassLike;
use PhpactorDist\Microsoft\PhpParser\NamespacedNameInterface;
use PhpactorDist\Microsoft\PhpParser\NamespacedNameTrait;
use PhpactorDist\Microsoft\PhpParser\Node\AttributeGroup;
use PhpactorDist\Microsoft\PhpParser\Node\ClassBaseClause;
use PhpactorDist\Microsoft\PhpParser\Node\ClassInterfaceClause;
use PhpactorDist\Microsoft\PhpParser\Node\ClassMembersNode;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Token;
class ClassDeclaration extends StatementNode implements NamespacedNameInterface, ClassLike
{
    use NamespacedNameTrait;
    /** @var AttributeGroup[]|null */
    public $attributes;
    /** @var Token abstract/final/readonly modifier */
    public $abstractOrFinalModifier;
    /** @var Token[] additional abstract/final/readonly modifiers */
    public $modifiers;
    /** @var Token */
    public $classKeyword;
    /** @var Token */
    public $name;
    /** @var ClassBaseClause */
    public $classBaseClause;
    /** @var ClassInterfaceClause */
    public $classInterfaceClause;
    /** @var ClassMembersNode */
    public $classMembers;
    const CHILD_NAMES = ['attributes', 'abstractOrFinalModifier', 'modifiers', 'classKeyword', 'name', 'classBaseClause', 'classInterfaceClause', 'classMembers'];
    public function getNameParts() : array
    {
        return [$this->name];
    }
}
