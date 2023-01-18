<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Expression;

use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Token;
class BinaryExpression extends Expression
{
    /** @var Expression|Token */
    public $leftOperand;
    /** @var Token */
    public $operator;
    /** @var Expression|Token */
    public $rightOperand;
    const CHILD_NAMES = ['leftOperand', 'operator', 'rightOperand'];
}
