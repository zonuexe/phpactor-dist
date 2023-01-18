<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Token;
class InterfaceBaseClause extends Node
{
    /** @var Token */
    public $extendsKeyword;
    /** @var DelimitedList\QualifiedNameList */
    public $interfaceNameList;
    const CHILD_NAMES = ['extendsKeyword', 'interfaceNameList'];
}
