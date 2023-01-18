<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\AttributeElementList;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Token;
class AttributeGroup extends Node
{
    /** @var Token */
    public $startToken;
    /** @var AttributeElementList */
    public $attributes;
    /** @var Token */
    public $endToken;
    const CHILD_NAMES = ['startToken', 'attributes', 'endToken'];
}
