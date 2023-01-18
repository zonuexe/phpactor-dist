<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model;

final class PsalmConfig
{
    public function __construct(private string $phpstanBin, private bool $shouldShowInfo)
    {
    }
    public function psalmBin() : string
    {
        return $this->phpstanBin;
    }
    public function shouldShowInfo() : bool
    {
        return $this->shouldShowInfo;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPsalm\\Model\\PsalmConfig', 'Phpactor\\Extension\\LanguageServerPsalm\\Model\\PsalmConfig', \false);
