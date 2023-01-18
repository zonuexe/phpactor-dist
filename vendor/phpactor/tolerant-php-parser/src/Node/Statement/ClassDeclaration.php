<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Statement;

use Phpactor202301\Microsoft\PhpParser\ClassLike;
use Phpactor202301\Microsoft\PhpParser\NamespacedNameInterface;
use Phpactor202301\Microsoft\PhpParser\NamespacedNameTrait;
use Phpactor202301\Microsoft\PhpParser\Node\AttributeGroup;
use Phpactor202301\Microsoft\PhpParser\Node\ClassBaseClause;
use Phpactor202301\Microsoft\PhpParser\Node\ClassInterfaceClause;
use Phpactor202301\Microsoft\PhpParser\Node\ClassMembersNode;
use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Token;
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
