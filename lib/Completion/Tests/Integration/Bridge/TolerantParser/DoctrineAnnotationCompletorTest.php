<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser;

use Generator;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection\DoctrineAnnotationCompletor;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Tests\Integration\CompletorTestCase;
use Phpactor202301\Phpactor\ReferenceFinder\NameSearcher;
use Phpactor202301\Phpactor\ReferenceFinder\Search\NameSearchResult;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\WorseReflection\Bridge\Phpactor\MemberProvider\DocblockMemberProvider;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Prophecy\Argument;
class DoctrineAnnotationCompletorTest extends CompletorTestCase
{
    /**
     * @dataProvider provideComplete
     */
    public function testComplete(string $source, array $expected) : void
    {
        $this->assertComplete($source, $expected);
    }
    public function provideComplete() : Generator
    {
        (yield 'not a docblock' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @Annotation
 */
class Annotation
{
}
/**
 * @Annotation
 */
\class_alias('Phpactor202301\\Annotation', 'Annotation', \false);
/*
 * @Ann<>
 */
class Foo
{
}
/*
 * @Ann<>
 */
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
EOT
, []]);
        (yield 'not a text annotation' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * Ann<>
 */
class Foo
{
}
/**
 * Ann<>
 */
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
EOT
, []]);
        (yield 'in a namespace' => [<<<'EOT'
<?php

namespace Phpactor202301\App\Annotation;

/**
 * @Annotation
 */
class Entity
{
}
namespace Phpactor202301\App;

/**
 * @Ent<>
 */
class Foo
{
}
EOT
, [['type' => Suggestion::TYPE_CLASS, 'name' => 'Entity', 'short_description' => 'Phpactor202301\\App\\Annotation\\Entity', 'snippet' => 'Entity($1)$0']]]);
        (yield 'annotation on a node in the middle of the AST' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @Annotation
 */
class Annotation
{
}
/**
 * @Annotation
 */
\class_alias('Phpactor202301\\Annotation', 'Annotation', \false);
class Foo
{
    /**
     * @var string
     */
    private $foo;
    /**
     * @Ann<>
     */
    public function foo() : string
    {
        return 'foo';
    }
    public function bar() : string
    {
        return 'bar';
    }
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
EOT
, [['type' => Suggestion::TYPE_CLASS, 'name' => 'Annotation', 'short_description' => 'Annotation', 'snippet' => 'Annotation($1)$0']]]);
        (yield 'not an annotation class' => [<<<'EOT'
<?php

namespace Phpactor202301;

class NotAnnotation
{
}
\class_alias('Phpactor202301\\NotAnnotation', 'NotAnnotation', \false);
/**
 * @NotAnn<>
 */
class Foo
{
}
/**
 * @NotAnn<>
 */
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
EOT
, []]);
        (yield 'handle errors if class not found' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @NotAnn<>
 */
class Foo
{
}
/**
 * @NotAnn<>
 */
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
EOT
, []]);
    }
    protected function createCompletor(string $source) : Completor
    {
        $source = TextDocumentBuilder::create($source)->uri('file:///tmp/test')->build();
        $searcher = $this->prophesize(NameSearcher::class);
        $searcher->search(Argument::any())->willYield([]);
        $searcher->search('Ann')->willYield([NameSearchResult::create('class', 'Annotation')]);
        $searcher->search('Ent')->willYield([NameSearchResult::create('class', 'Phpactor202301\\App\\Annotation\\Entity')]);
        $searcher->search('NotAnn')->willYield([NameSearchResult::create('class', 'NotAnnotation')]);
        $reflector = ReflectorBuilder::create()->addMemberProvider(new DocblockMemberProvider())->addSource($source)->build();
        return new DoctrineAnnotationCompletor($searcher->reveal(), $reflector);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\DoctrineAnnotationCompletorTest', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\DoctrineAnnotationCompletorTest', \false);
