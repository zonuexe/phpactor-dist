<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Adapter\Worse;

use Generator;
use Phpactor202301\Phpactor\Indexer\Adapter\Worse\WorseRecordReferenceEnhancer;
use Phpactor202301\Phpactor\Indexer\Model\RecordReference;
use Phpactor202301\Phpactor\Indexer\Model\Record\FileRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\MemberRecord;
use Phpactor202301\Phpactor\Indexer\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Psr\Log\NullLogger;
class WorseRecordReferenceEnhancerTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideEnhance
     */
    public function testEnhance(string $source, string $expectedType) : void
    {
        [$source, $offset] = ExtractOffset::fromSource($source);
        $this->workspace()->reset();
        $this->workspace()->put('test.php', $source);
        $reflector = ReflectorBuilder::create()->enableContextualSourceLocation()->build();
        $enhancer = new WorseRecordReferenceEnhancer($reflector, new NullLogger());
        $fileRecord = FileRecord::fromPath($this->workspace()->path('test.php'));
        $reference = new RecordReference(MemberRecord::RECORD_TYPE, 'foobar', (int) $offset);
        $reference = $enhancer->enhance($fileRecord, $reference);
        self::assertEquals($expectedType, $reference->contaninerType());
    }
    /**
     * @return Generator<mixed>
     */
    public function provideEnhance() : Generator
    {
        (yield [<<<'EOT'
<?php

namespace Phpactor202301\Foo;

class Foobar
{
    public function bar() : string
    {
    }
}
$foobar = new Foobar();
$foobar->b != ar();
EOT
, 'Phpactor202301\\Foo\\Foobar']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Adapter\\Worse\\WorseRecordReferenceEnhancerTest', 'Phpactor\\Indexer\\Tests\\Adapter\\Worse\\WorseRecordReferenceEnhancerTest', \false);
