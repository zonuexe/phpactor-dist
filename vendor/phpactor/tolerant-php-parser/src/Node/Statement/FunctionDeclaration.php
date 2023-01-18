<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Statement;

use Phpactor202301\Microsoft\PhpParser\FunctionLike;
use Phpactor202301\Microsoft\PhpParser\NamespacedNameInterface;
use Phpactor202301\Microsoft\PhpParser\NamespacedNameTrait;
use Phpactor202301\Microsoft\PhpParser\Node\FunctionBody;
use Phpactor202301\Microsoft\PhpParser\Node\FunctionHeader;
use Phpactor202301\Microsoft\PhpParser\Node\FunctionReturnType;
use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
class FunctionDeclaration extends StatementNode implements NamespacedNameInterface, FunctionLike
{
    use FunctionHeader, FunctionReturnType, FunctionBody;
    use NamespacedNameTrait;
    const CHILD_NAMES = [
        // FunctionHeader
        'attributes',
        'functionKeyword',
        'byRefToken',
        'name',
        'openParen',
        'parameters',
        'closeParen',
        // FunctionReturnType
        'colonToken',
        'questionToken',
        'returnTypeList',
        // FunctionBody
        'compoundStatementOrSemicolon',
    ];
    public function getNameParts() : array
    {
        return [$this->name];
    }
}
