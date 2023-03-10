<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Expression;

use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Token;
class ScriptInclusionExpression extends Expression
{
    /** @var Token */
    public $requireOrIncludeKeyword;
    /** @var Expression */
    public $expression;
    const CHILD_NAMES = ['requireOrIncludeKeyword', 'expression'];
}
