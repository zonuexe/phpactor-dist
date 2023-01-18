<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Token;
class ElseClauseNode extends Node
{
    /** @var Token */
    public $elseKeyword;
    /** @var Token */
    public $colon;
    /** @var StatementNode|StatementNode[] */
    public $statements;
    const CHILD_NAMES = ['elseKeyword', 'colon', 'statements'];
}
