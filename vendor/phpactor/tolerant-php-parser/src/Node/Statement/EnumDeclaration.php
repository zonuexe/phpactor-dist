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
use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Node\EnumMembers;
use Phpactor202301\Microsoft\PhpParser\Token;
class EnumDeclaration extends StatementNode implements NamespacedNameInterface, ClassLike
{
    use NamespacedNameTrait;
    /** @var AttributeGroup[]|null */
    public $attributes;
    /** @var Token */
    public $enumKeyword;
    /** @var Token */
    public $name;
    /** @var Token|null */
    public $colonToken;
    /** @var Token|null */
    public $enumType;
    /** @var EnumMembers */
    public $enumMembers;
    const CHILD_NAMES = ['attributes', 'enumKeyword', 'name', 'colonToken', 'enumType', 'enumMembers'];
    public function getNameParts() : array
    {
        return [$this->name];
    }
}
