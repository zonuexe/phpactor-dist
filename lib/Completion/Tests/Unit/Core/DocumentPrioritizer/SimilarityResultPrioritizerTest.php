<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Core\DocumentPrioritizer;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\DocumentPrioritizer\SimilarityResultPrioritizer;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class SimilarityResultPrioritizerTest extends TestCase
{
    /**
     * @dataProvider providePriority
     */
    public function testPriority(?string $one, ?string $two, int $priority) : void
    {
        $one = $one ? TextDocumentUri::fromString($one) : null;
        $two = $two ? TextDocumentUri::fromString($two) : null;
        self::assertEquals($priority, (new SimilarityResultPrioritizer())->priority($one, $two));
    }
    /**
     * @return Generator<mixed>
     */
    public function providePriority() : Generator
    {
        (yield ['/home/daniel/phpactor/vendor/symfony/foobar/lib/ClassOne.php', '/home/daniel/phpactor/lib/ClassOne.php', 169]);
        (yield 'further 1' => ['/home/daniel/phpactor/vendor/symfony/foobar/lib/ClassOne.php', '/home/daniel/phpactor/lib/Further/Away/ClassOne.php', 169]);
        (yield 'closer 1' => ['/home/daniel/phpactor/lib/ClassTwo.php', '/home/daniel/phpactor/lib/Further/Away/ClassOne.php', 175]);
        (yield 'closer 2' => ['/home/daniel/phpactor/lib/ClassTwo.php', '/home/daniel/phpactor/lib/Further/Away/ClassTwo.php', 159]);
        (yield ['/home/daniel/phpactor/vendor/symfony/foobar/lib/ClassOne.php', '/home/daniel/phpactor/vendor/symfony/foobar/lib/ClassOne.php', Suggestion::PRIORITY_MEDIUM]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Core\\DocumentPrioritizer\\SimilarityResultPrioritizerTest', 'Phpactor\\Completion\\Tests\\Unit\\Core\\DocumentPrioritizer\\SimilarityResultPrioritizerTest', \false);
