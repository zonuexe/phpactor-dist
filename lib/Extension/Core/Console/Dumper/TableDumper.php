<?php

namespace Phpactor202301\Phpactor\Extension\Core\Console\Dumper;

use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
use Phpactor202301\Symfony\Component\Console\Helper\Table;
final class TableDumper implements Dumper
{
    const PADDING = '  ';
    public function dump(OutputInterface $output, array $data) : void
    {
        $table = new Table($output);
        foreach ($data as $key => $value) {
            if (\is_array($value)) {
                $value = $this->formatArray($value);
            }
            $table->addRow(['<info>' . $key . '</>', $value]);
        }
        $table->render();
    }
    private function formatArray(array $data, $padding = 0)
    {
        $output = [];
        foreach ($data as $key => $value) {
            if (\is_array($value)) {
                $output[] = \str_repeat(self::PADDING, $padding) . $key . ':';
                $output[] = $this->formatArray($value, ++$padding);
                $padding--;
                continue;
            }
            $output[] = \sprintf('%s%s: %s', \str_repeat(self::PADDING, $padding), $key, $value);
        }
        return \implode("\n", $output);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Console\\Dumper\\TableDumper', 'Phpactor\\Extension\\Core\\Console\\Dumper\\TableDumper', \false);
