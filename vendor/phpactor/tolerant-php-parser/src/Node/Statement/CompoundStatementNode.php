<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Statement;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Token;
class CompoundStatementNode extends StatementNode
{
    /** @var Token */
    public $openBrace;
    /** @var array|Node[] */
    public $statements;
    /** @var Token */
    public $closeBrace;
    const CHILD_NAMES = ['openBrace', 'statements', 'closeBrace'];
}
