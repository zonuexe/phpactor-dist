<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Expression;

use PhpactorDist\Microsoft\PhpParser\MissingToken;
use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Token;
class SubscriptExpression extends Expression
{
    /** @var Expression */
    public $postfixExpression;
    /** @var Token */
    public $openBracketOrBrace;
    /** @var Expression|MissingToken */
    public $accessExpression;
    /** @var Token */
    public $closeBracketOrBrace;
    const CHILD_NAMES = ['postfixExpression', 'openBracketOrBrace', 'accessExpression', 'closeBracketOrBrace'];
}
