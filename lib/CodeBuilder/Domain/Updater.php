<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Prototype;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
interface Updater
{
    public function textEditsFor(Prototype $prototype, Code $code) : TextEdits;
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Updater', 'Phpactor\\CodeBuilder\\Domain\\Updater', \false);
