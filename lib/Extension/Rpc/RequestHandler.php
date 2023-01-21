<?php

namespace Phpactor\Extension\Rpc;

interface RequestHandler
{
    public function handle(\Phpactor\Extension\Rpc\Request $request) : \Phpactor\Extension\Rpc\Response;
}
