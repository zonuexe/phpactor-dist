<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Token;
class ForeachValue extends Node
{
    /** @var Token|null */
    public $ampersand;
    /** @var Expression */
    public $expression;
    const CHILD_NAMES = ['ampersand', 'expression'];
}
