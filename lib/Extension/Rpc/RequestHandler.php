<?php

namespace Phpactor202301\Phpactor\Extension\Rpc;

interface RequestHandler
{
    public function handle(Request $request) : Response;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\RequestHandler', 'Phpactor\\Extension\\Rpc\\RequestHandler', \false);
