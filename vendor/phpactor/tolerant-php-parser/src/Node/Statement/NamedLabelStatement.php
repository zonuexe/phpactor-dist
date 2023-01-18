<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Statement;

use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Token;
class NamedLabelStatement extends StatementNode
{
    /** @var Token */
    public $name;
    /** @var Token */
    public $colon;
    const CHILD_NAMES = ['name', 'colon'];
}
