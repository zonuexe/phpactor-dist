<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\Native\GenerateNew;

use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\AdapterTestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\ClassName;
use Phpactor202301\Phpactor\CodeTransform\Adapter\Native\GenerateNew\ClassGenerator;
class ClassGeneratorTest extends AdapterTestCase
{
    /**
     * It should generate a class
     */
    public function testGenerateClass() : void
    {
        $className = ClassName::fromString('Phpactor202301\\Acme\\Blog\\Post');
        $generator = new ClassGenerator($this->renderer());
        $code = $generator->generateNew($className);
        $this->assertEquals(<<<'EOT'
<?php

namespace Phpactor202301\Acme\Blog;

class Post
{
}
EOT
, (string) $code);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\Native\\GenerateNew\\ClassGeneratorTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\Native\\GenerateNew\\ClassGeneratorTest', \false);
