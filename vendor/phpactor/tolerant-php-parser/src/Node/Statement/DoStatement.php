<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Statement;

use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Token;
class DoStatement extends StatementNode
{
    /** @var Token */
    public $do;
    /** @var StatementNode */
    public $statement;
    /** @var Token */
    public $whileToken;
    /** @var Token */
    public $openParen;
    /** @var Expression */
    public $expression;
    /** @var Token */
    public $closeParen;
    /** @var Token|null */
    public $semicolon;
    const CHILD_NAMES = ['do', 'statement', 'whileToken', 'openParen', 'expression', 'closeParen', 'semicolon'];
}
