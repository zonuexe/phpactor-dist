<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Statement;

use Phpactor202301\Microsoft\PhpParser\MissingToken;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
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
