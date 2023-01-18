<?php

namespace Phpactor202301\Phpactor\Extension\CodeTransformExtra\Application;

use Phpactor202301\Phpactor\CodeTransform\CodeTransform;
use Phpactor202301\Phpactor\Extension\Core\Application\Helper\FilesystemHelper;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Symfony\Component\Filesystem\Path;
class Transformer
{
    private FilesystemHelper $filesystemHelper;
    public function __construct(private CodeTransform $transform)
    {
        $this->filesystemHelper = new FilesystemHelper();
    }
    public function transform($source, array $transformations)
    {
        if (\file_exists($source)) {
            /** @var string $workDir */
            $workDir = \getcwd();
            $source = Path::makeAbsolute($source, $workDir);
            $source = SourceCode::fromStringAndPath(\file_get_contents($source), $source);
        }
        if (!$source instanceof SourceCode) {
            $source = $this->filesystemHelper->contentsFromFileOrStdin($source);
            $source = SourceCode::fromString($source);
        }
        $transformedCode = $this->transform->transform($source, $transformations);
        return $transformedCode;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CodeTransformExtra\\Application\\Transformer', 'Phpactor\\Extension\\CodeTransformExtra\\Application\\Transformer', \false);
