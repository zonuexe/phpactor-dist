<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Expression;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\DelimitedList\MatchExpressionArmList;
use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Token;
class MatchExpression extends Expression
{
    /** @var Token `match` */
    public $matchToken;
    /** @var Token */
    public $openParen;
    /** @var Node|null */
    public $expression;
    /** @var Token */
    public $closeParen;
    /** @var Token */
    public $openBrace;
    /** @var MatchExpressionArmList|null */
    public $arms;
    /** @var Token */
    public $closeBrace;
    const CHILD_NAMES = ['matchToken', 'openParen', 'expression', 'closeParen', 'openBrace', 'arms', 'closeBrace'];
}
