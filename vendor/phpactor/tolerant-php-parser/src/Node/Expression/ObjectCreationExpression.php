<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace PhpactorDist\Microsoft\PhpParser\Node\Expression;

use PhpactorDist\Microsoft\PhpParser\Node\AttributeGroup;
use PhpactorDist\Microsoft\PhpParser\Node\ClassBaseClause;
use PhpactorDist\Microsoft\PhpParser\Node\ClassInterfaceClause;
use PhpactorDist\Microsoft\PhpParser\Node\ClassMembersNode;
use PhpactorDist\Microsoft\PhpParser\Node\DelimitedList;
use PhpactorDist\Microsoft\PhpParser\Node\Expression;
use PhpactorDist\Microsoft\PhpParser\Node\QualifiedName;
use PhpactorDist\Microsoft\PhpParser\Token;
class ObjectCreationExpression extends Expression
{
    /** @var Token */
    public $newKeword;
    /** @var AttributeGroup[]|null optional attributes of an anonymous class. */
    public $attributes;
    /** @var QualifiedName|Variable|Token */
    public $classTypeDesignator;
    /** @var Token|null */
    public $openParen;
    /** @var DelimitedList\ArgumentExpressionList|null  */
    public $argumentExpressionList;
    /** @var Token|null */
    public $closeParen;
    /** @var ClassBaseClause|null */
    public $classBaseClause;
    /** @var ClassInterfaceClause|null */
    public $classInterfaceClause;
    /** @var ClassMembersNode|null */
    public $classMembers;
    const CHILD_NAMES = ['newKeword', 'attributes', 'classTypeDesignator', 'openParen', 'argumentExpressionList', 'closeParen', 'classBaseClause', 'classInterfaceClause', 'classMembers'];
}
