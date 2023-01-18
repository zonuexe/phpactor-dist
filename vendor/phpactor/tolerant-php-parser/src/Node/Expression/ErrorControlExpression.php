<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Expression;

use Phpactor202301\Microsoft\PhpParser\Token;
class ErrorControlExpression extends UnaryExpression
{
    /** @var Token */
    public $operator;
    /** @var UnaryExpression */
    public $operand;
    const CHILD_NAMES = ['operator', 'operand'];
}
