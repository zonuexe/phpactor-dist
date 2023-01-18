<?php

namespace Phpactor202301\Phpactor\Extension\Php\Model;

class ComposerPhpVersionResolver implements PhpVersionResolver
{
    public function __construct(private string $composerJsonPath)
    {
    }
    public function resolve() : ?string
    {
        if (!\file_exists($this->composerJsonPath)) {
            return null;
        }
        if (!($contents = \file_get_contents($this->composerJsonPath))) {
            return null;
        }
        if (!($json = \json_decode($contents, \true))) {
            return null;
        }
        if (isset($json['config']['platform']['php'])) {
            return $json['config']['platform']['php'];
        }
        if (isset($json['require']['php'])) {
            return $this->resolveLowestVersion($json['require']['php']);
        }
        return null;
    }
    private function resolveLowestVersion(string $versionString) : ?string
    {
        $versions = \array_map(function (string $versionString) {
            return \preg_replace('/[^0-9.]/', '', \trim($versionString));
        }, (array) \preg_split('{\\|\\|?}', $versionString));
        \sort($versions);
        if (\false === ($version = \reset($versions))) {
            return $versionString;
        }
        return $version;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Php\\Model\\ComposerPhpVersionResolver', 'Phpactor\\Extension\\Php\\Model\\ComposerPhpVersionResolver', \false);