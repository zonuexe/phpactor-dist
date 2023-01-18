<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Tests\Unit\Util;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Util\PhpactorToLspCompletionType;
use ReflectionClass;
class PhpactorToLspCompletionTypeTest extends TestCase
{
    public function testConverts() : void
    {
        $reflection = new ReflectionClass(Suggestion::class);
        foreach ($reflection->getConstants() as $name => $constantValue) {
            if (!\str_starts_with($name, 'TYPE')) {
                continue;
            }
            $this->assertNotNull(PhpactorToLspCompletionType::fromPhpactorType($constantValue), $constantValue);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCompletion\\Tests\\Unit\\Util\\PhpactorToLspCompletionTypeTest', 'Phpactor\\Extension\\LanguageServerCompletion\\Tests\\Unit\\Util\\PhpactorToLspCompletionTypeTest', \false);
