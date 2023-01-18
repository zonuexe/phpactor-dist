<?php

/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser\Node;

use Phpactor202301\Microsoft\PhpParser\NamespacedNameInterface;
use Phpactor202301\Microsoft\PhpParser\NamespacedNameTrait;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Token;
class ConstElement extends Node implements NamespacedNameInterface
{
    use NamespacedNameTrait;
    /** @var Token */
    public $name;
    /** @var Token */
    public $equalsToken;
    /** @var Expression */
    public $assignment;
    const CHILD_NAMES = ['name', 'equalsToken', 'assignment'];
    public function getNameParts() : array
    {
        return [$this->name];
    }
    public function getName()
    {
        return $this->name->getText($this->getFileContents());
    }
}
