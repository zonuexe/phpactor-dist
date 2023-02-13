<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Expression;

use PhpactorDist\Microsoft\PhpParser\Node\DelimitedList;
use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Node\QualifiedName;
use PhpactorDist\Microsoft\PhpParser\Token;
class CallExpression extends Expression
{
    /** @var QualifiedName|Expression */
    public $callableExpression;
    /** @var Token */
    public $openParen;
    /** @var DelimitedList\ArgumentExpressionList|null */
    public $argumentExpressionList;
    /** @var Token */
    public $closeParen;
    const CHILD_NAMES = ['callableExpression', 'openParen', 'argumentExpressionList', 'closeParen'];
}
