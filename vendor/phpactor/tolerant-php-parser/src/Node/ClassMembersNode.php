<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Token;
class ClassMembersNode extends Node
{
    /** @var Token */
    public $openBrace;
    /** @var Node[] */
    public $classMemberDeclarations;
    /** @var Token */
    public $closeBrace;
    const CHILD_NAMES = ['openBrace', 'classMemberDeclarations', 'closeBrace'];
}
