<?php

namespace Phpactor\Completion\Bridge\TolerantParser;

interface TolerantQualifiable
{
    public function qualifier() : \Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier;
}
