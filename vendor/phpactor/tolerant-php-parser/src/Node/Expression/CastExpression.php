<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Expression;

use Phpactor202301\Microsoft\PhpParser\Token;
class CastExpression extends UnaryExpression
{
    /** @var Token */
    public $openParen;
    /** @var Token */
    public $castType;
    /** @var Token */
    public $closeParen;
    /** @var Variable */
    public $operand;
    const CHILD_NAMES = ['openParen', 'castType', 'closeParen', 'operand'];
}
