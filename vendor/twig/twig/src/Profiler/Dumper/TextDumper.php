<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpactor202301\Twig\Profiler\Dumper;

use Phpactor202301\Twig\Profiler\Profile;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class TextDumper extends BaseDumper
{
    protected function formatTemplate(Profile $profile, $prefix)
    {
        return \sprintf('%s└ %s', $prefix, $profile->getTemplate());
    }
    protected function formatNonTemplate(Profile $profile, $prefix)
    {
        return \sprintf('%s└ %s::%s(%s)', $prefix, $profile->getTemplate(), $profile->getType(), $profile->getName());
    }
    protected function formatTime(Profile $profile, $percent)
    {
        return \sprintf('%.2fms/%.0f%%', $profile->getDuration() * 1000, $percent);
    }
}
\class_alias('Phpactor202301\\Twig\\Profiler\\Dumper\\TextDumper', 'Phpactor202301\\Twig_Profiler_Dumper_Text');
