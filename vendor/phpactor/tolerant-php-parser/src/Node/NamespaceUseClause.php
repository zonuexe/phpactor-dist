<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\MissingToken;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList;
use Phpactor202301\Microsoft\PhpParser\Token;
class NamespaceUseClause extends Node
{
    /** @var QualifiedName|MissingToken */
    public $namespaceName;
    /** @var NamespaceAliasingClause */
    public $namespaceAliasingClause;
    /** @var Token|null */
    public $openBrace;
    /** @var DelimitedList\NamespaceUseGroupClauseList|null */
    public $groupClauses;
    /** @var Token|null */
    public $closeBrace;
    const CHILD_NAMES = ['namespaceName', 'namespaceAliasingClause', 'openBrace', 'groupClauses', 'closeBrace'];
}
