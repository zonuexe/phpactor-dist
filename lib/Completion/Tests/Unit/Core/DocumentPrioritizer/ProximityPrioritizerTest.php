<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Core\DocumentPrioritizer;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\DocumentPrioritizer\ProximityPrioritizer;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class ProximityPrioritizerTest extends TestCase
{
    /**
     * @dataProvider providePriority
     */
    public function testPriority(?string $one, ?string $two, int $priority) : void
    {
        $one = $one ? TextDocumentUri::fromString($one) : null;
        $two = $two ? TextDocumentUri::fromString($two) : null;
        self::assertEquals($priority, (new ProximityPrioritizer())->priority($one, $two));
    }
    /**
     * @return Generator<mixed>
     */
    public function providePriority() : Generator
    {
        (yield [null, null, Suggestion::PRIORITY_LOW]);
        (yield ['/home/daniel/phpactor/vendor/symfony/foobar/lib/ClassOne.php', '/home/daniel/phpactor/lib/ClassOne.php', 218]);
        (yield 'further 1' => ['/home/daniel/phpactor/vendor/symfony/foobar/lib/ClassOne.php', '/home/daniel/phpactor/lib/Further/Away/ClassOne.php', 198]);
        (yield 'closer 1' => ['/home/daniel/phpactor/lib/ClassTwo.php', '/home/daniel/phpactor/lib/Further/Away/ClassOne.php', 223]);
        (yield 'closer 2' => ['/home/daniel/phpactor/lib/ClassTwo.php', '/home/daniel/phpactor/lib/Away/ClassTwo.php', 212]);
        (yield ['/home/daniel/phpactor/vendor/symfony/foobar/lib/ClassOne.php', '/home/daniel/phpactor/vendor/symfony/foobar/lib/ClassOne.php', Suggestion::PRIORITY_MEDIUM]);
        (yield 'closer 3' => ['/project/pipeline/Survey/GitSurvey.php', '/project/pipeline/Task/ComposerBumpVersionIfPresentTask.php', 191]);
        (yield 'further 3' => ['/project/vendor/dantleech/maestro/src/Composer/Extension/ComposerExtension.php', '/project/pipeline/Survey/GitSurvey.php', 216]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Core\\DocumentPrioritizer\\ProximityPrioritizerTest', 'Phpactor\\Completion\\Tests\\Unit\\Core\\DocumentPrioritizer\\ProximityPrioritizerTest', \false);
