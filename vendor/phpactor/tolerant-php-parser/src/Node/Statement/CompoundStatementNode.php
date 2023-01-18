<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Statement;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Token;
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
