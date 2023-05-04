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
use PhpactorDist\Microsoft\PhpParser\Node\EnumInterfaceClause;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Node\EnumMembers;
use PhpactorDist\Microsoft\PhpParser\Token;
class EnumDeclaration extends StatementNode implements NamespacedNameInterface, ClassLike
{
    use NamespacedNameTrait;
    /** @var AttributeGroup[]|null */
    public $attributes;
    /** @var Token */
    public $enumKeyword;
    /** @var EnumInterfaceClause|null */
    public $enumInterfaceClause;
    /** @var Token */
    public $name;
    /** @var Token|null */
    public $colonToken;
    /** @var Token|null */
    public $enumType;
    /** @var EnumMembers */
    public $enumMembers;
    const CHILD_NAMES = ['attributes', 'enumKeyword', 'name', 'colonToken', 'enumType', 'enumInterfaceClause', 'enumMembers'];
    public function getNameParts() : array
    {
        return [$this->name];
    }
}
