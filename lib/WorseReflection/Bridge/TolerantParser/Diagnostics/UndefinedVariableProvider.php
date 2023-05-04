<?php

namespace Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\Variable;
use PhpactorDist\Microsoft\PhpParser\Node\PropertyDeclaration;
use PhpactorDist\PHPUnit\Framework\Assert;
use Phpactor\WorseReflection\Core\DiagnosticExample;
use Phpactor\WorseReflection\Core\DiagnosticProvider;
use Phpactor\WorseReflection\Core\Diagnostics;
use Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor\WorseReflection\Core\Inference\Variable as PhpactorVariable;
use Phpactor\WorseReflection\Core\Util\NodeUtil;
/**
 * Report if a variable is undefined and suggest variables with similar names.
 */
class UndefinedVariableProvider implements DiagnosticProvider
{
    public function __construct(private int $suggestionLevensteinDistance = 4)
    {
    }
    public function examples() : iterable
    {
        (yield new DiagnosticExample(title: 'undefined variable', source: <<<'PHP'
<?php

namespace PhpactorDist;

$zebra = 'one';
$foa = 'two';
if ($foo) {
}
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Undefined variable "$foo", did you mean "$foa"', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'property', source: <<<'PHP'
<?php

namespace PhpactorDist;

class Foo
{
    public $foo;
}
\class_alias('PhpactorDist\\Foo', 'Foo', \false);
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'many undefined variables', source: <<<'PHP'
<?php

namespace PhpactorDist;

$foz = 'one';
$foa = 'two';
$fob = 'three';
if ($foo) {
}
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Undefined variable "$foo", did you mean one of "$foz", "$foa", "$fob"', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'from vardoc', source: <<<'PHP'
<?php

namespace PhpactorDist;

/** @var string $zebra */
$zebra = 'one';
if ($zebra) {
}
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'was assigned', source: <<<'PHP'
<?php

namespace PhpactorDist;

class Foo
{
    public function foo() : void
    {
        $this->bar;
    }
}
\class_alias('PhpactorDist\\Foo', 'Foo', \false);
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'is catch receiver', source: <<<'PHP'
<?php

namespace PhpactorDist;

try {
    foo();
} catch (\Error $e) {
    throw $e;
}
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'unnamed var!', source: <<<'PHP'
<?php

class foo {
    public string $
}
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'variable is parameter', source: <<<'PHP'
<?php

function ($foo) {
    return $foo;
}

class Foo {
    public function foo($foo) {
        return $foo;
    }
}
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'is this', source: <<<'PHP'
<?php

namespace PhpactorDist;

$zebra = 'one';
$foa = 'two';
if ($foa) {
}
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'is in enum', source: <<<'PHP'
<?php

namespace PhpactorDist;

enum Foo : string
{
    public function foo() : void
    {
        $this;
    }
}
PHP
, valid: \true, minPhpVersion: '8.1', assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'is in list assignment', source: <<<'PHP'
<?php

namespace PhpactorDist;

[$a, $b] = [1, 2];
echo $a;
echo $b;
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'undefined and no suggestions', source: <<<'PHP'
<?php

namespace PhpactorDist;

if ($foa) {
}
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Undefined variable "$foa"', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'after for loop', source: <<<'PHP'
<?php

namespace PhpactorDist;

$plainArray = [];
$list = [];
foreach ($plainArray as $index => $data) {
    $list[$index] = $data;
}
return $list;
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'static', source: <<<'PHP'
<?php

namespace PhpactorDist;

class Foo
{
    public static string $foo = 'bar';
    public function demo() : void
    {
        $example = static::$foo;
    }
}
\class_alias('PhpactorDist\\Foo', 'Foo', \false);
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
    }
    public function enter(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        if (!$node instanceof Variable) {
            return [];
        }
        if ($node->parent?->parent instanceof PropertyDeclaration) {
            return [];
        }
        if ($node->parent instanceof ScopedPropertyAccessExpression) {
            return [];
        }
        if (!($name = $node->getName())) {
            return [];
        }
        foreach ($frame->locals()->byName($name) as $variable) {
            if ($variable->wasDefinition()) {
                return [];
            }
        }
        (yield new \Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\UndefinedVariableDiagnostic(NodeUtil::byteOffsetRangeForNode($node), $name, \array_filter(\array_map(function (PhpactorVariable $var) {
            return $var->name();
        }, $frame->locals()->definitionsOnly()->mostRecent()->toArray()), function (string $candidate) use($name) {
            return \levenshtein($name, $candidate) < $this->suggestionLevensteinDistance;
        })));
    }
    public function exit(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        return [];
    }
    public function name() : string
    {
        return 'undefined_variable';
    }
}