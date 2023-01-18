<?php

namespace Phpactor202301\Phpactor\Extension\WorseReflectionExtra\Application;

use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Offset;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Inference\Variable;
use Phpactor202301\Phpactor\Extension\Core\Application\Helper\ClassFileNormalizer;
use Phpactor202301\Phpactor\Extension\Core\Application\Helper\FilesystemHelper;
use Phpactor202301\Phpactor\WorseReflection\TypeUtil;
final class OffsetInfo
{
    private FilesystemHelper $filesystemHelper;
    public function __construct(private Reflector $reflector, private ClassFileNormalizer $classFileNormalizer)
    {
        $this->filesystemHelper = new FilesystemHelper();
    }
    public function infoForOffset(string $sourcePath, int $offset, $showFrame = \false) : array
    {
        $result = $this->reflector->reflectOffset(SourceCode::fromString($this->filesystemHelper->contentsFromFileOrStdin($sourcePath)), Offset::fromInt($offset));
        $symbolContext = $result->symbolContext();
        $return = ['symbol' => $symbolContext->symbol()->name(), 'symbol_type' => $symbolContext->symbol()->symbolType(), 'start' => $symbolContext->symbol()->position()->start(), 'end' => $symbolContext->symbol()->position()->end(), 'type' => (string) $symbolContext->type(), 'class_type' => (string) $symbolContext->containerType(), 'value' => \var_export(TypeUtil::valueOrNull($symbolContext->type()), \true), 'offset' => $offset, 'type_path' => null];
        if ($showFrame) {
            $frame = [];
            foreach (['locals', 'properties'] as $assignmentType) {
                /** @var $local Variable */
                foreach ($result->frame()->{$assignmentType}() as $local) {
                    $info = \sprintf('%s = (%s) %s', $local->name(), $local->symbolContext()->type(), \str_replace(\PHP_EOL, '', \var_export($local->symbolContext()->value(), \true)));
                    $frame[$assignmentType][$local->offset()->toInt()] = $info;
                }
            }
            $return['frame'] = $frame;
        }
        if (\false === $symbolContext->type()->isDefined()) {
            return $return;
        }
        $return['type_path'] = $symbolContext->type()->isClass() ? $this->classFileNormalizer->classToFile((string) $symbolContext->type(), \true) : null;
        $return['class_type_path'] = $symbolContext->containerType()->isDefined() && $symbolContext->containerType()->isClass() ? $this->classFileNormalizer->classToFile($return['class_type'], \true) : null;
        return $return;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\WorseReflectionExtra\\Application\\OffsetInfo', 'Phpactor\\Extension\\WorseReflectionExtra\\Application\\OffsetInfo', \false);
