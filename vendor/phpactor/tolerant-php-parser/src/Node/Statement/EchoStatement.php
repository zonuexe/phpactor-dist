<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Statement;

use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\ExpressionList;
use Phpactor202301\Microsoft\PhpParser\Token;
/**
 * This represents either a literal echo statement (`echo expr`)
 * or a short echo tag (`<?= expr...`)
 */
class EchoStatement extends StatementNode
{
    /**
     * @var Token|null this is null if generated from `<?=`
     */
    public $echoKeyword;
    /** @var ExpressionList */
    public $expressions;
    /** @var Token */
    public $semicolon;
    const CHILD_NAMES = ['echoKeyword', 'expressions', 'semicolon'];
}
