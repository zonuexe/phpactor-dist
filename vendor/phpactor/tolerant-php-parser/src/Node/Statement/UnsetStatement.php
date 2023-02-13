<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Statement;

use PhpactorDist\Microsoft\PhpParser\Node\DelimitedList;
use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Token;
class UnsetStatement extends Expression
{
    /** @var Token */
    public $unsetKeyword;
    /** @var Token */
    public $openParen;
    /** @var DelimitedList\ExpressionList */
    public $expressions;
    /** @var Token */
    public $closeParen;
    /** @var Token */
    public $semicolon;
    const CHILD_NAMES = ['unsetKeyword', 'openParen', 'expressions', 'closeParen', 'semicolon'];
}
