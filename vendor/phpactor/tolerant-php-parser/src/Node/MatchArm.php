<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\MatchArmConditionList;
use Phpactor202301\Microsoft\PhpParser\Token;
class MatchArm extends Node
{
    /** @var MatchArmConditionList */
    public $conditionList;
    /** @var Token */
    public $arrowToken;
    /** @var Expression */
    public $body;
    const CHILD_NAMES = ['conditionList', 'arrowToken', 'body'];
}
