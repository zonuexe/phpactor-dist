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
use PhpactorDist\Microsoft\PhpParser\Node\InterfaceBaseClause;
use PhpactorDist\Microsoft\PhpParser\Node\InterfaceMembers;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Token;
class InterfaceDeclaration extends StatementNode implements NamespacedNameInterface, ClassLike
{
    use NamespacedNameTrait;
    /** @var AttributeGroup[]|null */
    public $attributes;
    /** @var Token */
    public $interfaceKeyword;
    /** @var Token */
    public $name;
    /** @var InterfaceBaseClause|null */
    public $interfaceBaseClause;
    /** @var InterfaceMembers */
    public $interfaceMembers;
    const CHILD_NAMES = ['attributes', 'interfaceKeyword', 'name', 'interfaceBaseClause', 'interfaceMembers'];
    public function getNameParts() : array
    {
        return [$this->name];
    }
}
