<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Statement;

use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Token;
class ReturnStatement extends StatementNode
{
    /** @var Token */
    public $returnKeyword;
    /** @var Expression|null */
    public $expression;
    /** @var Token */
    public $semicolon;
    const CHILD_NAMES = ['returnKeyword', 'expression', 'semicolon'];
}
