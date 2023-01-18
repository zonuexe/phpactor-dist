<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Stream;

use Phpactor202301\Amp\ByteStream\InputStream;
use Phpactor202301\Amp\ByteStream\OutputStream;
interface DuplexStream extends InputStream, OutputStream
{
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Stream\\DuplexStream', 'Phpactor\\LanguageServer\\Core\\Server\\Stream\\DuplexStream', \false);
