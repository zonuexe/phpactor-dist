<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\MissingToken;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Token;
class Parameter extends Node
{
    /** @var AttributeGroup[]|null */
    public $attributes;
    /** @var Token|null */
    public $visibilityToken;
    /** @var Token[]|null */
    public $modifiers;
    /** @var Token|null */
    public $questionToken;
    /** @var DelimitedList\QualifiedNameList|MissingToken|null */
    public $typeDeclarationList;
    /** @var Token|null */
    public $byRefToken;
    /** @var Token|null */
    public $dotDotDotToken;
    /** @var Token */
    public $variableName;
    /** @var Token|null */
    public $equalsToken;
    /** @var null|Expression */
    public $default;
    const CHILD_NAMES = ['attributes', 'visibilityToken', 'modifiers', 'questionToken', 'typeDeclarationList', 'byRefToken', 'dotDotDotToken', 'variableName', 'equalsToken', 'default'];
    public function isVariadic()
    {
        return $this->byRefToken !== null;
    }
    public function getName()
    {
        if ($this->variableName instanceof Token && ($name = \substr($this->variableName->getText($this->getFileContents()), 1))) {
            return $name;
        }
        return null;
    }
}