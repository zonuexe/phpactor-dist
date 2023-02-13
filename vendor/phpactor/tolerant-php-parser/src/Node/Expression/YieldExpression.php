<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Expression;

use PhpactorDist\Microsoft\PhpParser\Node\ArrayElement;
use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Token;
class YieldExpression extends Expression
{
    /** @var Token */
    public $yieldOrYieldFromKeyword;
    /** @var ArrayElement|null */
    public $arrayElement;
    const CHILD_NAMES = ['yieldOrYieldFromKeyword', 'arrayElement'];
}
