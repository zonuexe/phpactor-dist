<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Expression;

use Phpactor202301\Microsoft\PhpParser\FunctionLike;
use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Node\FunctionBody;
use Phpactor202301\Microsoft\PhpParser\Node\FunctionHeader;
use Phpactor202301\Microsoft\PhpParser\Node\FunctionReturnType;
use Phpactor202301\Microsoft\PhpParser\Node\FunctionUseClause;
use Phpactor202301\Microsoft\PhpParser\Token;
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
