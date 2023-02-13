<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Token;
class InterfaceBaseClause extends Node
{
    /** @var Token */
    public $extendsKeyword;
    /** @var DelimitedList\QualifiedNameList */
    public $interfaceNameList;
    const CHILD_NAMES = ['extendsKeyword', 'interfaceNameList'];
}
