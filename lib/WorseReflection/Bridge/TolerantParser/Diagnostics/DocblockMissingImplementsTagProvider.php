<?php

namespace Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use PhpactorDist\PHPUnit\Framework\Assert;
use Phpactor\TextDocument\ByteOffsetRange;
use Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\Docblock\ClassGenericDiagnosticHelper;
use Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionInterface;
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
class DocblockMissingImplementsTagProvider implements DiagnosticProvider
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
            /** @phpstan-ignore-next-line TP Lies */
            foreach ($node->classInterfaceClause?->interfaceNameList?->getChildNodes() ?? [] as $implementedInterface) {
                try {
                    $implementedInterface = $resolver->reflector()->reflectClassLike($implementedInterface->getText());
                } catch (NotFound) {
                    continue;
                }
                if (!$implementedInterface instanceof ReflectionInterface) {
                    continue;
                }
                yield from $this->helper->diagnosticsForImplements($resolver->reflector(), $range, $class, $implementedInterface);
            }
        }
    }
    public function enter(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        return [];
    }
    public function examples() : iterable
    {
        (yield new DiagnosticExample(title: 'implements class requiring generic annotation', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @template T
 */
interface NeedGeneric
{
}
/**
 * @template T
 */
\class_alias('PhpactorDist\\NeedGeneric', 'NeedGeneric', \false);
class Foobar implements NeedGeneric
{
}
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Missing generic tag `@implements NeedGeneric<mixed>`', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'does not provide enough arguments', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @template T
 * @template P
 */
interface NeedGeneric
{
}
/**
 * @template T
 * @template P
 */
\class_alias('PhpactorDist\\NeedGeneric', 'NeedGeneric', \false);
/**
 * @implements NeedGeneric<int>
 */
class Foobar implements NeedGeneric
{
}
/**
 * @implements NeedGeneric<int>
 */
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Generic tag `@implements NeedGeneric<int>` should be compatible with `@implements NeedGeneric<mixed,mixed>`', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'provides one but not another', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @template T
 */
interface NeedGeneric1
{
}
/**
 * @template T
 */
\class_alias('PhpactorDist\\NeedGeneric1', 'NeedGeneric1', \false);
/**
 * @template T
 */
interface NeedGeneric2
{
}
/**
 * @template T
 */
\class_alias('PhpactorDist\\NeedGeneric2', 'NeedGeneric2', \false);
/**
 * @implements NeedGeneric1<int>
 */
class Foobar implements NeedGeneric1, NeedGeneric2
{
}
/**
 * @implements NeedGeneric1<int>
 */
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \false, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(1, $diagnostics);
            Assert::assertEquals('Missing generic tag `@implements NeedGeneric2<mixed>`', $diagnostics->at(0)->message());
        }));
        (yield new DiagnosticExample(title: 'iterator', source: <<<'PHP'
<?php

namespace PhpactorDist;

/**
 * @implements IteratorAggregate<string>
 */
class Foobar implements \IteratorAggregate
{
}
/**
 * @implements IteratorAggregate<string>
 */
\class_alias('PhpactorDist\\Foobar', 'Foobar', \false);
PHP
, valid: \true, assertion: function (Diagnostics $diagnostics) : void {
            Assert::assertCount(0, $diagnostics);
        }));
    }
    public function name() : string
    {
        return 'docblock_missing_implements_tag';
    }
}
