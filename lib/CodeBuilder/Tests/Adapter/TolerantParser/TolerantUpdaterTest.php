<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Adapter\TolerantParser;

use Phpactor202301\Phpactor\CodeBuilder\Adapter\Twig\TwigRenderer;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\TolerantUpdater;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeBuilder\Tests\Adapter\UpdaterTestCase;
class TolerantUpdaterTest extends UpdaterTestCase
{
    protected function updater() : Updater
    {
        return new TolerantUpdater(new TwigRenderer(), null, null);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Adapter\\TolerantParser\\TolerantUpdaterTest', 'Phpactor\\CodeBuilder\\Tests\\Adapter\\TolerantParser\\TolerantUpdaterTest', \false);
