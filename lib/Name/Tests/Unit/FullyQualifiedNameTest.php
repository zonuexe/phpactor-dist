<?php

namespace Phpactor202301\Phpactor\Name\Tests\Unit;

use Phpactor202301\Phpactor\Name\FullyQualifiedName;
class FullyQualifiedNameTest extends AbstractQualifiedNameTestCase
{
    protected function createFromArray(array $parts)
    {
        return FullyQualifiedName::fromArray($parts);
    }
    protected function createFromString(string $string)
    {
        return FullyQualifiedName::fromString($string);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Name\\Tests\\Unit\\FullyQualifiedNameTest', 'Phpactor\\Name\\Tests\\Unit\\FullyQualifiedNameTest', \false);
