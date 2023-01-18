<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter;

use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class TextDocumentConverter
{
    public static function fromLspTextItem(TextDocumentItem $item) : TextDocument
    {
        $builder = TextDocumentBuilder::create($item->text);
        if ($item->uri) {
            $builder->uri($item->uri);
        }
        $builder->language($item->languageId);
        return $builder->build();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBridge\\Converter\\TextDocumentConverter', 'Phpactor\\Extension\\LanguageServerBridge\\Converter\\TextDocumentConverter', \false);
