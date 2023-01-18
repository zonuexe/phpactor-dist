<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model;

final class PhpstanConfig
{
    public function __construct(private string $phpstanBin, private ?string $level = null)
    {
    }
    public function level() : ?string
    {
        return $this->level;
    }
    public function phpstanBin() : string
    {
        return $this->phpstanBin;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpstan\\Model\\PhpstanConfig', 'Phpactor\\Extension\\LanguageServerPhpstan\\Model\\PhpstanConfig', \false);
