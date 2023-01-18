<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerSymbolProvider\Model;

use Phpactor202301\Phpactor\LanguageServerProtocol\DocumentSymbol;
interface DocumentSymbolProvider
{
    /**
     * @return array<DocumentSymbol>
     */
    public function provideFor(string $source) : array;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerSymbolProvider\\Model\\DocumentSymbolProvider', 'Phpactor\\Extension\\LanguageServerSymbolProvider\\Model\\DocumentSymbolProvider', \false);
