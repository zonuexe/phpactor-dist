<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node;

use PhpactorDist\Microsoft\PhpParser\MissingToken;
use PhpactorDist\Microsoft\PhpParser\ModifiedTypeInterface;
use PhpactorDist\Microsoft\PhpParser\ModifiedTypeTrait;
use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use PhpactorDist\Microsoft\PhpParser\Token;
class PropertyDeclaration extends Node implements ModifiedTypeInterface
{
    use ModifiedTypeTrait;
    /** @var AttributeGroup[]|null */
    public $attributes;
    /** @var Token|null question token for PHP 7.4 type declaration */
    public $questionToken;
    /** @var QualifiedNameList|MissingToken|null */
    public $typeDeclarationList;
    /** @var DelimitedList\ExpressionList */
    public $propertyElements;
    /** @var Token */
    public $semicolon;
    const CHILD_NAMES = ['attributes', 'modifiers', 'questionToken', 'typeDeclarationList', 'propertyElements', 'semicolon'];
}
