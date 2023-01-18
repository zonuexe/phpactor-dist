<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Expression;

use Phpactor202301\Microsoft\PhpParser\Node\ArrayElement;
use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Token;
class YieldExpression extends Expression
{
    /** @var Token */
    public $yieldOrYieldFromKeyword;
    /** @var ArrayElement|null */
    public $arrayElement;
    const CHILD_NAMES = ['yieldOrYieldFromKeyword', 'arrayElement'];
}
