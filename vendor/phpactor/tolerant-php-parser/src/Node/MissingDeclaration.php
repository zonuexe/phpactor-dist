<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\MissingToken;
class MissingDeclaration extends Node
{
    /** @var AttributeGroup[] */
    public $attributes;
    /** @var MissingToken needed for emitting diagnostics */
    public $declaration;
    const CHILD_NAMES = ['attributes', 'declaration'];
}
