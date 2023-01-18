<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Expression;

use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList;
use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Token;
class ArrayCreationExpression extends Expression
{
    /** @var Token|null */
    public $arrayKeyword;
    /** @var Token */
    public $openParenOrBracket;
    /** @var DelimitedList\ArrayElementList */
    public $arrayElements;
    /** @var Token */
    public $closeParenOrBracket;
    const CHILD_NAMES = ['arrayKeyword', 'openParenOrBracket', 'arrayElements', 'closeParenOrBracket'];
}
