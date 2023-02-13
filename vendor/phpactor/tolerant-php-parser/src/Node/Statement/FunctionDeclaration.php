<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Statement;

use PhpactorDist\Microsoft\PhpParser\FunctionLike;
use PhpactorDist\Microsoft\PhpParser\NamespacedNameInterface;
use PhpactorDist\Microsoft\PhpParser\NamespacedNameTrait;
use PhpactorDist\Microsoft\PhpParser\Node\FunctionBody;
use PhpactorDist\Microsoft\PhpParser\Node\FunctionHeader;
use PhpactorDist\Microsoft\PhpParser\Node\FunctionReturnType;
use PhpactorDist\Microsoft\PhpParser\Node\StatementNode;
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
