<?php

namespace Phpactor202301\Phpactor\Extension\CodeTransformExtra\Application;

use Phpactor202301\Phpactor\CodeTransform\Domain\ClassName;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Phpactor;
class ClassNew extends AbstractClassGenerator
{
    public function generate(string $src, string $variant = 'default', bool $overwrite = \false) : SourceCode
    {
        $className = $this->normalizer->normalizeToClass($src);
        $code = $this->generators->get($variant)->generateNew(ClassName::fromString((string) $className));
        $filePath = Phpactor::isFile($src) ? Phpactor::normalizePath($src) : $this->normalizer->normalizeToFile($className);
        $code = $code->withPath($filePath);
        $this->writeFile($filePath, (string) $code, $overwrite);
        return $code;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CodeTransformExtra\\Application\\ClassNew', 'Phpactor\\Extension\\CodeTransformExtra\\Application\\ClassNew', \false);
