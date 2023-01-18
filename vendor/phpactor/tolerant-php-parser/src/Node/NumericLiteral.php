<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\Token;
class NumericLiteral extends Expression
{
    /** @var Token */
    public $children;
    const CHILD_NAMES = ['children'];
}