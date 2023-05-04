<?php

namespace Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use PhpactorDist\PHPUnit\Framework\Assert;
use Phpactor\TextDocument\ByteOffsetRange;
use Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\Docblock\ClassGenericDiagnosticHelper;
use Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor\WorseReflection\Core\DiagnosticExample;
use Phpactor\WorseReflection\Core\DiagnosticProvider;
use Phpactor\WorseReflection\Core\Diagnostics;
use Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
/**
 * Report when a class extends a generic class but does not provide an @extends tag.
 */
class DocblockMissingExtendsTagProvider implements DiagnosticProvider
{
    private ClassGenericDiagnosticHelper $helper;
    public function __construct(?ClassGenericDiagnosticHelper $helper = null)
    {
        $this->helper = $helper ?: new ClassGenericDiagnosticHelper();
    }
    public function exit(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        if (!$node instanceof ClassDeclaration) {
            return;
        }
        /** @phpstan-ignore-next-line */
        if (!$node->name) {
            return;
        }
        $range = ByteOffsetRange::fromInts($node->name->getStartPosition(), $node->name->getEndPosition());
        try {
            $class = $resolver->reflector()->reflectClassLike($node->getNamespacedName()->__toString());
        } catch (NotFound) {
            return;
        }
        if ($class instanceof ReflectionClass) {
            yield from $this->helper->diagnosticsForExtends($resolver->reflector(), $range, $class, $class->parent());
        }
    }
    public function enter(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        return [];
    }
    public function examples() : iterable
    {
        (yield new DiagnosticExample(title: 'extends class requiring generic annotation', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @template T
 */
class NeedGeneric
{
}
/**
 * @template T
 */
\class_alias('PhpactorDist\\NeedGeneric', 'NeedGeneric', \false);
class Foobar extends NeedGeneric
{
}
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Missing generic tag `@extends NeedGeneric<mixed>`', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'does not provide enough arguments', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @template T
 * @template P
 */
class NeedGeneric
{
}
/**
 * @template T
 * @template P
 */
\class_alias('PhpactorDist\\NeedGeneric', 'NeedGeneric', \false);
/**
 * @extends NeedGeneric<int>
 */
class Foobar extends NeedGeneric
{
}
/**
 * @extends NeedGeneric<int>
 */
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Generic tag `@extends NeedGeneric<int>` should be compatible with `@extends NeedGeneric<mixed,mixed>`', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'does not provide any arguments', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @template T of int
 */
class NeedGeneric
{
}
/**
 * @template T of int
 */
\class_alias('PhpactorDist\\NeedGeneric', 'NeedGeneric', \false);
/**
 * @extends NeedGeneric
 */
class Foobar extends NeedGeneric
{
}
/**
 * @extends NeedGeneric
 */
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Generic tag `@extends NeedGeneric` should be compatible with `@extends NeedGeneric<int>`', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'provides empty arguments', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @template T of int
 */
class NeedGeneric
{
}
/**
 * @template T of int
 */
\class_alias('PhpactorDist\\NeedGeneric', 'NeedGeneric', \false);
/**
 * @extends NeedGeneric<>
 */
class Foobar extends NeedGeneric
{
}
/**
 * @extends NeedGeneric<>
 */
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Missing generic tag `@extends NeedGeneric<int>`', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'wrong class', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @template T of int
 */
class NeedGeneric
{
}
/**
 * @template T of int
 */
\class_alias('PhpactorDist\\NeedGeneric', 'NeedGeneric', \false);
/**
 * @extends NeedGeneic<int>
 */
class Foobar extends NeedGeneric
{
}
/**
 * @extends NeedGeneic<int>
 */
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Missing generic tag `@extends NeedGeneric<int>`', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'does not provide multiple arguments', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @template T
 * @template P
 * @template Q
 */
class NeedGeneric
{
}
/**
 * @template T
 * @template P
 * @template Q
 */
\class_alias('PhpactorDist\\NeedGeneric', 'NeedGeneric', \false);
/**
 * @extends NeedGeneric<int>
 */
class Foobar extends NeedGeneric
{
}
/**
 * @extends NeedGeneric<int>
 */
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Generic tag `@extends NeedGeneric<int>` should be compatible with `@extends NeedGeneric<mixed,mixed,mixed>`', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'extends class not requiring generic annotation', source: <<<'PHP'
<?php

namespace PhpactorDist;

class NeedGeneric
{
}
\class_alias('PhpactorDist\\NeedGeneric', 'NeedGeneric', \false);
class Foobar extends NeedGeneric
{
}
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
        (yield new DiagnosticExample(title: 'provides extends class and provides annotation', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @template T
 */
class NeedGeneric
{
}
/**
 * @template T
 */
\class_alias('PhpactorDist\\NeedGeneric', 'NeedGeneric', \false);
/**
 * @extends NeedGeneric<int>
 */
class Foobar extends NeedGeneric
{
}
/**
 * @extends NeedGeneric<int>
 */
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
    }
    public function name() : string
    {
        return 'docblock_missing_extends_tag';
    }
}
