<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Expression;

use PhpactorDist\Microsoft\PhpParser\FunctionLike;
use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Node\FunctionBody;
use PhpactorDist\Microsoft\PhpParser\Node\FunctionHeader;
use PhpactorDist\Microsoft\PhpParser\Node\FunctionReturnType;
use PhpactorDist\Microsoft\PhpParser\Node\FunctionUseClause;
use PhpactorDist\Microsoft\PhpParser\Token;
class AnonymousFunctionCreationExpression extends Expression implements FunctionLike
{
    /** @var Token|null */
    public $staticModifier;
    use FunctionHeader, FunctionUseClause, FunctionReturnType, FunctionBody;
    const CHILD_NAMES = [
        'attributes',
        'staticModifier',
        // FunctionHeader
        'functionKeyword',
        'byRefToken',
        'name',
        'openParen',
        'parameters',
        'closeParen',
        // FunctionUseClause
        'anonymousFunctionUseClause',
        // FunctionReturnType
        'colonToken',
        'questionToken',
        'returnTypeList',
        // FunctionBody
        'compoundStatementOrSemicolon',
    ];
}
