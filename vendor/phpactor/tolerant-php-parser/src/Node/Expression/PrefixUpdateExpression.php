<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Expression;

use PhpactorDist\Microsoft\PhpParser\Token;
class PrefixUpdateExpression extends UnaryExpression
{
    /** @var Token */
    public $incrementOrDecrementOperator;
    const CHILD_NAMES = ['incrementOrDecrementOperator', 'operand'];
}
