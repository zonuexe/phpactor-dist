<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Tests\Unit\Editor;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ReturnOption;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ReturnChoiceResponse;
class ReturnChoiceActionTest extends TestCase
{
    public function testCreate() : void
    {
        $option1 = ReturnOption::fromNameAndValue('one', 1000);
        $returnChoice = ReturnChoiceResponse::fromOptions([$option1]);
        $this->assertEquals(['choices' => [['name' => 'one', 'value' => 1000]]], $returnChoice->parameters());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Tests\\Unit\\Editor\\ReturnChoiceActionTest', 'Phpactor\\Extension\\Rpc\\Tests\\Unit\\Editor\\ReturnChoiceActionTest', \false);
