<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer\Status;

interface StatusProvider
{
    public function title() : string;
    /**
     * Return key => value status report
     *
     * @return array<string,string>
     */
    public function provide() : array;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\Status\\StatusProvider', 'Phpactor\\Extension\\LanguageServer\\Status\\StatusProvider', \false);
