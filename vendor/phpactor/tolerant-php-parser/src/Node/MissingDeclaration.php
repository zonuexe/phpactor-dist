<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\MissingToken;
class MissingDeclaration extends Node
{
    /** @var AttributeGroup[] */
    public $attributes;
    /** @var MissingToken needed for emitting diagnostics */
    public $declaration;
    const CHILD_NAMES = ['attributes', 'declaration'];
}
