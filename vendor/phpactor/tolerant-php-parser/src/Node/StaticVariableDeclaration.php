<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Token;
class StaticVariableDeclaration extends Node
{
    /** @var Token */
    public $variableName;
    /** @var Token|null */
    public $equalsToken;
    /** @var Expression|null */
    public $assignment;
    const CHILD_NAMES = ['variableName', 'equalsToken', 'assignment'];
}
