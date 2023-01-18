<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Model\NameImport;

use Phpactor202301\Phpactor\CodeTransform\Domain\NameWithByteOffset;
class NameCandidate
{
    public function __construct(private NameWithByteOffset $unresolvedName, private string $candidateFqn)
    {
    }
    public function candidateFqn() : string
    {
        return $this->candidateFqn;
    }
    public function unresolvedName() : NameWithByteOffset
    {
        return $this->unresolvedName;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Model\\NameImport\\NameCandidate', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Model\\NameImport\\NameCandidate', \false);
