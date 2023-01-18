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
use Phpactor202301\Microsoft\PhpParser\Node\InterfaceBaseClause;
use Phpactor202301\Microsoft\PhpParser\Node\InterfaceMembers;
use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Token;
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
