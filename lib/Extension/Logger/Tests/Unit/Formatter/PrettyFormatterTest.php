<?php

namespace Phpactor202301\Phpactor\Extension\Logger\Tests\Unit\Formatter;

use DateTime;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Logger\Formatter\PrettyFormatter;
class PrettyFormatterTest extends TestCase
{
    /**
     * @dataProvider provideFormat
     */
    public function testFormat(array $record) : void
    {
        $record = \array_merge(['level_name' => 'info', 'context' => [], 'message' => 'hello', 'datetime' => new DateTime()]);
        $formatter = new PrettyFormatter();
        $string = $formatter->format($record);
        self::assertIsString($string);
    }
    public function provideFormat()
    {
        (yield [['level_name' => 'critical']]);
        (yield [['level_name' => 'unknown']]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Logger\\Tests\\Unit\\Formatter\\PrettyFormatterTest', 'Phpactor\\Extension\\Logger\\Tests\\Unit\\Formatter\\PrettyFormatterTest', \false);
