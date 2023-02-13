<?php

namespace PhpactorDist;

use PhpactorDist\Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use PhpactorDist\Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use PhpactorDist\Symfony\Component\VarDumper\Dumper\CliDumper;
use PhpactorDist\Symfony\Component\VarDumper\Dumper\ServerDumper;
use PhpactorDist\Symfony\Component\VarDumper\Cloner\VarCloner;
use PhpactorDist\Symfony\Component\VarDumper\VarDumper;
$cloner = new VarCloner();
$dumper = new ServerDumper('tcp://127.0.0.1:9912', new CliDumper(), ['cli' => new CliContextProvider(), 'source' => new SourceContextProvider()]);
VarDumper::setHandler(function ($var) use($cloner, $dumper) : void {
    $dumper->dump($cloner->cloneVar($var));
});
