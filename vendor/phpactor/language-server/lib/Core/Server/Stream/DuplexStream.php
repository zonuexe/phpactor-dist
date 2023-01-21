<?php

namespace Phpactor\LanguageServer\Core\Server\Stream;

use Phpactor202301\Amp\ByteStream\InputStream;
use Phpactor202301\Amp\ByteStream\OutputStream;
interface DuplexStream extends InputStream, OutputStream
{
}
