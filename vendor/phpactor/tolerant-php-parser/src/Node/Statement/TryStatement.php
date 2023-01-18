<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Statement;

use Phpactor202301\Microsoft\PhpParser\Node\CatchClause;
use Phpactor202301\Microsoft\PhpParser\Node\FinallyClause;
use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Token;
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
