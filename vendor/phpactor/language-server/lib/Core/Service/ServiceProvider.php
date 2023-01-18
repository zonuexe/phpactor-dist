<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Service;

interface ServiceProvider
{
    /**
     * Return a list of methods which should be registered as services.
     *
     * Services are asynchronous co-routines will be started when the
     * language server is initialized.
     *
     * For example:
     *
     * ```
     *     public function services(): array
     *     {
     *         return [
     *             'pingService'
     *         ];
     *     }
     *
     *     public function pingService(): Promise
     *     {
     *         // exit immediately
     *         return new Success();
     *     }
     */
    public function services() : array;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Service\\ServiceProvider', 'Phpactor\\LanguageServer\\Core\\Service\\ServiceProvider', \false);