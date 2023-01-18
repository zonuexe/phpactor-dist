<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Statement;

use Phpactor202301\Microsoft\PhpParser\MissingToken;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList;
use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Token;
class DeclareStatement extends StatementNode
{
    /** @var Token */
    public $declareKeyword;
    /** @var Token */
    public $openParen;
    // TODO Maybe create a delimited list with a missing token instead? Probably more consistent.
    /** @var DelimitedList\DeclareDirectiveList|MissingToken */
    public $declareDirectiveList;
    /** @var Token */
    public $closeParen;
    /** @var Token|null */
    public $colon;
    /** @var StatementNode|StatementNode[] */
    public $statements;
    /** @var Token|null */
    public $enddeclareKeyword;
    /** @var Token|null */
    public $semicolon;
    const CHILD_NAMES = ['declareKeyword', 'openParen', 'declareDirectiveList', 'closeParen', 'colon', 'statements', 'enddeclareKeyword', 'semicolon'];
}
