<?php

namespace Phpactor202301\Safe;

use Phpactor202301\Safe\Exceptions\RpminfoException;
/**
 * Add an additional retrieved tag in subsequent queries.
 *
 * @param int $tag One of RPMTAG_* constant, see the rpminfo constants page.
 * @throws RpminfoException
 *
 */
function rpmaddtag(int $tag) : void
{
    \error_clear_last();
    $result = \Phpactor202301\rpmaddtag($tag);
    if ($result === \false) {
        throw RpminfoException::createFromPhpError();
    }
}
