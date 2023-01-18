<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node\Statement;

use Phpactor202301\Microsoft\PhpParser\Diagnostic;
use Phpactor202301\Microsoft\PhpParser\DiagnosticKind;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Microsoft\PhpParser\TokenKind;
class BreakOrContinueStatement extends StatementNode
{
    /** @var Token */
    public $breakOrContinueKeyword;
    /** @var Expression|null */
    public $breakoutLevel;
    /** @var Token */
    public $semicolon;
    const CHILD_NAMES = ['breakOrContinueKeyword', 'breakoutLevel', 'semicolon'];
    /**
     * @return Diagnostic|null - Callers should use DiagnosticsProvider::getDiagnostics instead
     * @internal
     * @override
     */
    public function getDiagnosticForNode()
    {
        if ($this->breakoutLevel === null) {
            return null;
        }
        $breakoutLevel = $this->breakoutLevel;
        while ($breakoutLevel instanceof Node\Expression\ParenthesizedExpression) {
            $breakoutLevel = $breakoutLevel->expression;
        }
        if ($breakoutLevel instanceof Node\NumericLiteral && $breakoutLevel->children->kind === TokenKind::IntegerLiteralToken) {
            $literalString = $breakoutLevel->getText();
            $firstTwoChars = \substr($literalString, 0, 2);
            if ($firstTwoChars === '0b' || $firstTwoChars === '0B') {
                if (\bindec(\substr($literalString, 2)) > 0) {
                    return null;
                }
            } else {
                if (\intval($literalString, 0) > 0) {
                    return null;
                }
            }
        }
        $start = $breakoutLevel->getStartPosition();
        $end = $breakoutLevel->getEndPosition();
        return new Diagnostic(DiagnosticKind::Error, "Positive integer literal expected.", $start, $end - $start);
    }
}
