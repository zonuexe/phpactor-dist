<?php

namespace Phpactor202301\Phpactor\Extension\PHPUnit\CodeTransform;

use Phpactor202301\Phpactor\CodeTransform\Domain\ClassName;
use Phpactor202301\Phpactor\CodeTransform\Domain\GenerateNew;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
class TestGenerator implements GenerateNew
{
    public function generateNew(ClassName $targetName) : SourceCode
    {
        $namespace = $targetName->namespace();
        $name = $targetName->short();
        $sourceCode = <<<EOT
<?php

namespace {$namespace};

use PHPUnit\\Framework\\TestCase;

class {$name} extends TestCase
{
}
EOT;
        return SourceCode::fromString($sourceCode);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\PHPUnit\\CodeTransform\\TestGenerator', 'Phpactor\\Extension\\PHPUnit\\CodeTransform\\TestGenerator', \false);
