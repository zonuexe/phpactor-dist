<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Statement;

use PhpactorDist\Microsoft\PhpParser\Node\CaseStatementNode;
use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Token;
class SwitchStatementNode extends StatementNode
{
    /** @var Token */
    public $switchKeyword;
    /** @var Token */
    public $openParen;
    /** @var Expression */
    public $expression;
    /** @var Token */
    public $closeParen;
    /** @var Token|null */
    public $colon;
    /** @var Token|null */
    public $openBrace;
    /** @var CaseStatementNode[] */
    public $caseStatements;
    /** @var Token|null */
    public $closeBrace;
    /** @var Token|null */
    public $endswitch;
    /** @var Token|null */
    public $semicolon;
    const CHILD_NAMES = ['switchKeyword', 'openParen', 'expression', 'closeParen', 'colon', 'openBrace', 'caseStatements', 'closeBrace', 'endswitch', 'semicolon'];
}
