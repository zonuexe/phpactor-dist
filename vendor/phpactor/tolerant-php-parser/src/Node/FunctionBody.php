<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node;

use PhpactorDist\Microsoft\PhpParser\Node\Statement\CompoundStatementNode;
use PhpactorDist\Microsoft\PhpParser\Token;
trait FunctionBody
{
    /** @var CompoundStatementNode|Token */
    public $compoundStatementOrSemicolon;
}
