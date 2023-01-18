<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
interface Linter
{
    /**
     * @return Promise<array<Diagnostic>>
     */
    public function lint(string $url, ?string $text) : Promise;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPsalm\\Model\\Linter', 'Phpactor\\Extension\\LanguageServerPsalm\\Model\\Linter', \false);
