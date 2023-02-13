<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Statement;

use PhpactorDist\Microsoft\PhpParser\Node\CatchClause;
use PhpactorDist\Microsoft\PhpParser\Node\FinallyClause;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Token;
class TryStatement extends StatementNode
{
    /** @var Token */
    public $tryKeyword;
    /** @var StatementNode */
    public $compoundStatement;
    /** @var CatchClause[]|null */
    public $catchClauses;
    /** @var FinallyClause|null */
    public $finallyClause;
    const CHILD_NAMES = ['tryKeyword', 'compoundStatement', 'catchClauses', 'finallyClause'];
}
