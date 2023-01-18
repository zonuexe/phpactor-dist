<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\MissingToken;
use Phpactor202301\Microsoft\PhpParser\Token;
trait FunctionReturnType
{
    /** @var Token */
    public $colonToken;
    // TODO: This may be the wrong choice if ?type can ever be mixed with other types in union types
    /** @var Token|null */
    public $questionToken;
    /** @var DelimitedList\QualifiedNameList|null|MissingToken */
    public $returnTypeList;
}
