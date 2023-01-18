<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Tests\Unit\Response\Input;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Rpc\Response\Input\ChoiceInput;
class ChoiceInputTest extends TestCase
{
    public function testCreateWithShortcut() : void
    {
        $choice = ChoiceInput::fromNameLabelChoices('foo', 'foobar', ['one', 'two'])->withKeys(['one' => 'o', 'two' => 't']);
        self::assertEquals(['label' => 'foobar', 'choices' => [0 => 'one', 1 => 'two'], 'default' => null, 'keyMap' => ['one' => 'o', 'two' => 't']], $choice->parameters());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Tests\\Unit\\Response\\Input\\ChoiceInputTest', 'Phpactor\\Extension\\Rpc\\Tests\\Unit\\Response\\Input\\ChoiceInputTest', \false);
