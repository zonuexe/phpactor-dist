<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Initializer;

use Phpactor202301\Phpactor\LanguageServerProtocol\ClientCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Initializer;
/**
 * Use pre-defined initialization parameters.
 * This is useful for testing.
 */
final class PredefinedInitializer implements Initializer
{
    /**
     * @var InitializeParams
     */
    private $params;
    public function __construct(?InitializeParams $params = null)
    {
        $this->params = $params ?: new InitializeParams(new ClientCapabilities());
    }
    /**
     * {@inheritDoc}
     */
    public function provideInitializeParams(Message $message) : InitializeParams
    {
        return $this->params;
    }
}
/**
 * Use pre-defined initialization parameters.
 * This is useful for testing.
 */
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Initializer\\PredefinedInitializer', 'Phpactor\\LanguageServer\\Core\\Server\\Initializer\\PredefinedInitializer', \false);
