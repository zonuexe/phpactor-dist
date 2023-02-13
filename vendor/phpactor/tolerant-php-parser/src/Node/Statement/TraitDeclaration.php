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
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Node\TraitMembers;
use PhpactorDist\Microsoft\PhpParser\Token;
class TraitDeclaration extends StatementNode implements NamespacedNameInterface, ClassLike
{
    use NamespacedNameTrait;
    /** @var AttributeGroup[]|null */
    public $attributes;
    /** @var Token */
    public $traitKeyword;
    /** @var Token */
    public $name;
    /** @var TraitMembers */
    public $traitMembers;
    const CHILD_NAMES = ['attributes', 'traitKeyword', 'name', 'traitMembers'];
    public function getNameParts() : array
    {
        return [$this->name];
    }
}
