<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Expression;

use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Token;
class PrintIntrinsicExpression extends Expression
{
    /** @var Token */
    public $printKeyword;
    /** @var Expression */
    public $expression;
    const CHILD_NAMES = ['printKeyword', 'expression'];
}
