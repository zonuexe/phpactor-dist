<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Expression;

use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Token;
class EvalIntrinsicExpression extends Expression
{
    /** @var Token */
    public $evalKeyword;
    /** @var Token */
    public $openParen;
    /** @var Expression */
    public $expression;
    /** @var Token */
    public $closeParen;
    const CHILD_NAMES = ['evalKeyword', 'openParen', 'expression', 'closeParen'];
}