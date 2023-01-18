<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Behat;

class StepParser
{
    /**
     * @return string[]
     */
    public function parseSteps(string $string) : array
    {
        $keywords = ['Given', 'When', 'Then', 'And', 'But'];
        return $this->extractSteps($keywords, $string);
    }
    /**
     * @return string[]
     * @param string[] $keywords
     */
    private function extractSteps(array $keywords, string $string) : array
    {
        \preg_match_all('{(' . \implode('|', $keywords) . ')\\s*(.*)}', $string, $matches);
        if (isset($matches[2])) {
            return $matches[2];
        }
        return [];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Behat\\StepParser', 'Phpactor\\Extension\\Behat\\Behat\\StepParser', \false);
