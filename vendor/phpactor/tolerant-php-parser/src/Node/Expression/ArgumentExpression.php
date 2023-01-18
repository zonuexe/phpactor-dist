<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Expression;

use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Token;
class ArgumentExpression extends Expression
{
    /** @var Token|null for php named arguments. If this is set, dotDotDotToken will not be set. */
    public $name;
    /** @var Token|null */
    public $colonToken;
    /** @var Token|null */
    public $dotDotDotToken;
    /** @var Expression|null null for first-class callable syntax */
    public $expression;
    const CHILD_NAMES = ['name', 'colonToken', 'dotDotDotToken', 'expression'];
}