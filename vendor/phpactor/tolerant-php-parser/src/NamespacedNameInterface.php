<?php

/*---------------------------------------------------------------------------------------------
 *  Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
namespace Phpactor202301\Microsoft\PhpParser;

interface NamespacedNameInterface
{
    public function getNamespacedName() : ResolvedName;
}
