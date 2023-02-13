<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Expression;

use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Token;
class BracedExpression extends Expression
{
    /** @var Token */
    public $openBrace;
    /** @var Expression */
    public $expression;
    /** @var Token */
    public $closeBrace;
    const CHILD_NAMES = ['openBrace', 'expression', 'closeBrace'];
}
