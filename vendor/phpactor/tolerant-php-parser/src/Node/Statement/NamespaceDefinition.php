<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Statement;

use PhpactorDist\Microsoft\PhpParser\MissingToken;
use PhpactorDist\Microsoft\PhpParser\Node\QualifiedName;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
use PhpactorDist\Microsoft\PhpParser\Token;
use PhpactorDist\Microsoft\PhpParser\Node\SourceFileNode;
/**
 * @property SourceFileNode $parent
 */
class NamespaceDefinition extends StatementNode
{
    /** @var Token */
    public $namespaceKeyword;
    /** @var QualifiedName|null|MissingToken */
    public $name;
    /** @var CompoundStatementNode|Token */
    public $compoundStatementOrSemicolon;
    const CHILD_NAMES = ['namespaceKeyword', 'name', 'compoundStatementOrSemicolon'];
}
