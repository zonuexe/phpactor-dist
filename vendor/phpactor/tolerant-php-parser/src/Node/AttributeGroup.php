<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node;

use PhpactorDist\Microsoft\PhpParser\Node\DelimitedList\AttributeElementList;
use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Token;
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
