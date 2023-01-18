<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\SourceLocator;

use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\Workspace\WorkspaceIndex;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\SourceNotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;
class WorkspaceSourceLocator implements SourceCodeLocator
{
    public function __construct(private WorkspaceIndex $index)
    {
    }
    public function locate(Name $name) : SourceCode
    {
        if (null === ($document = $this->index->documentForName($name))) {
            throw new SourceNotFound(\sprintf('Class "%s" not found', (string) $name));
        }
        return SourceCode::fromUnknown($document);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerWorseReflection\\SourceLocator\\WorkspaceSourceLocator', 'Phpactor\\Extension\\LanguageServerWorseReflection\\SourceLocator\\WorkspaceSourceLocator', \false);
