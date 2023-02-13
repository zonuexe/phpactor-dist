<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Statement;

use PhpactorDist\Microsoft\PhpParser\Node\DelimitedList;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Token;
class FunctionStaticDeclaration extends StatementNode
{
    /** @var Token */
    public $staticKeyword;
    /** @var DelimitedList\StaticVariableNameList */
    public $staticVariableNameList;
    /** @var Token */
    public $semicolon;
    const CHILD_NAMES = ['staticKeyword', 'staticVariableNameList', 'semicolon'];
}
