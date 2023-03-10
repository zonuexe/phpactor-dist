<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Token;
class ClassBaseClause extends Node
{
    /** @var Token */
    public $extendsKeyword;
    /** @var QualifiedName */
    public $baseClass;
    const CHILD_NAMES = ['extendsKeyword', 'baseClass'];
}
