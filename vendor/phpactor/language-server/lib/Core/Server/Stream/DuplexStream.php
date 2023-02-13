<?php

namespace Phpactor\LanguageServer\Core\Server\Stream;

use PhpactorDist\Amp\ByteStream\InputStream;
use PhpactorDist\Amp\ByteStream\OutputStream;
interface DuplexStream extends InputStream, OutputStream
{
}
