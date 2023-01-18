<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Behat;

interface ContextClassResolver
{
    public function resolve(string $className) : string;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Behat\\ContextClassResolver', 'Phpactor\\Extension\\Behat\\Behat\\ContextClassResolver', \false);
