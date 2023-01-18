<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Expression;

use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Token;
class ScopedPropertyAccessExpression extends Expression
{
    /** @var Expression|QualifiedName|Token */
    public $scopeResolutionQualifier;
    /** @var Token */
    public $doubleColon;
    /** @var Token|Variable */
    public $memberName;
    const CHILD_NAMES = ['scopeResolutionQualifier', 'doubleColon', 'memberName'];
}
