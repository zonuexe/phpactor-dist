<?php

namespace Phpactor202301;

use Phpactor202301\Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Phpactor202301\Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Phpactor202301\Symfony\Component\VarDumper\Dumper\CliDumper;
use Phpactor202301\Symfony\Component\VarDumper\Dumper\ServerDumper;
use Phpactor202301\Symfony\Component\VarDumper\Cloner\VarCloner;
use Phpactor202301\Symfony\Component\VarDumper\VarDumper;
$cloner = new VarCloner();
$dumper = new ServerDumper('tcp://127.0.0.1:9912', new CliDumper(), ['cli' => new CliContextProvider(), 'source' => new SourceContextProvider()]);
VarDumper::setHandler(function ($var) use($cloner, $dumper) : void {
    $dumper->dump($cloner->cloneVar($var));
});
