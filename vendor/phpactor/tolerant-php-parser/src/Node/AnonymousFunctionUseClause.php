<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node;

use PhpactorDist\Microsoft\PhpParser\MissingToken;
use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\DelimitedList\UseVariableNameList;
use PhpactorDist\Microsoft\PhpParser\Token;
class AnonymousFunctionUseClause extends Node
{
    /** @var Token */
    public $useKeyword;
    /** @var Token */
    public $openParen;
    /** @var UseVariableNameList|MissingToken */
    public $useVariableNameList;
    /** @var Token */
    public $closeParen;
    const CHILD_NAMES = ['useKeyword', 'openParen', 'useVariableNameList', 'closeParen'];
}
