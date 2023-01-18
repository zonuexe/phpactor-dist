<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Expression;

use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Token;
class ThrowExpression extends Expression
{
    /** @var Token */
    public $throwKeyword;
    /** @var Expression */
    public $expression;
    const CHILD_NAMES = ['throwKeyword', 'expression'];
}
