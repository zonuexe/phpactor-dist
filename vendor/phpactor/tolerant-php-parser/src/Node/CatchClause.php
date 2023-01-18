<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Phpactor202301\Microsoft\PhpParser\MissingToken;
use Phpactor202301\Microsoft\PhpParser\Token;
class CatchClause extends Node
{
    /** @var Token */
    public $catch;
    /** @var Token */
    public $openParen;
    /** @var QualifiedNameList[]|MissingToken */
    public $qualifiedNameList;
    /** @var Token|null */
    public $variableName;
    /** @var Token */
    public $closeParen;
    /** @var StatementNode */
    public $compoundStatement;
    const CHILD_NAMES = ['catch', 'openParen', 'qualifiedNameList', 'variableName', 'closeParen', 'compoundStatement'];
}
