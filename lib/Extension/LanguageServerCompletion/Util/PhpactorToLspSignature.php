<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Util;

use Phpactor202301\Phpactor\LanguageServerProtocol\MarkupContent;
use Phpactor202301\Phpactor\LanguageServerProtocol\MarkupKind;
use Phpactor202301\Phpactor\LanguageServerProtocol\ParameterInformation;
use Phpactor202301\Phpactor\LanguageServerProtocol\SignatureHelp;
use Phpactor202301\Phpactor\LanguageServerProtocol\SignatureInformation;
use Phpactor202301\Phpactor\Completion\Core\SignatureHelp as PhpactorSignatureHelp;
class PhpactorToLspSignature
{
    public static function toLspSignatureHelp(PhpactorSignatureHelp $phpactorHelp) : SignatureHelp
    {
        $signatures = [];
        foreach ($phpactorHelp->signatures() as $phpactorSignature) {
            $parameters = [];
            foreach ($phpactorSignature->parameters() as $phpactorParameter) {
                $parameters[] = new ParameterInformation('$' . $phpactorParameter->label(), new MarkupContent(MarkupKind::MARKDOWN, $phpactorParameter->documentation()));
            }
            $signatures[] = new SignatureInformation($phpactorSignature->label(), new MarkupContent(MarkupKind::MARKDOWN, $phpactorSignature->documentation() ?? ''), $parameters);
        }
        return new SignatureHelp($signatures, $phpactorHelp->activeSignature(), $phpactorHelp->activeParameter());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCompletion\\Util\\PhpactorToLspSignature', 'Phpactor\\Extension\\LanguageServerCompletion\\Util\\PhpactorToLspSignature', \false);
