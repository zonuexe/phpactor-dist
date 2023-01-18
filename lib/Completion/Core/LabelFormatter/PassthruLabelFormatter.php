<?php

namespace Phpactor202301\Phpactor\Completion\Core\LabelFormatter;

use Phpactor202301\Phpactor\Completion\Core\LabelFormatter;
class PassthruLabelFormatter implements LabelFormatter
{
    public function format(string $name, array $seen, int $offset = 1) : string
    {
        return $name;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\LabelFormatter\\PassthruLabelFormatter', 'Phpactor\\Completion\\Core\\LabelFormatter\\PassthruLabelFormatter', \false);
