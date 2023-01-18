<?php

namespace Phpactor202301\Phpactor\Rename\Adapter\WorseReflection;

use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotConvertClassToUri;
use Phpactor202301\Phpactor\Rename\Model\NameToUriConverter;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class WorseNameToUriConverter implements NameToUriConverter
{
    public function __construct(private Reflector $reflector)
    {
    }
    public function convert(string $className) : TextDocumentUri
    {
        try {
            $uri = $this->reflector->reflectClassLike($className)->sourceCode()->uri();
        } catch (NotFound $notFound) {
            throw new CouldNotConvertClassToUri($notFound->getMessage(), 0, $notFound);
        }
        if (null === $uri) {
            throw new CouldNotConvertClassToUri(\sprintf('Reflected source for "%s" did not have a URI associated with it', $className));
        }
        return $uri;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Adapter\\WorseReflection\\WorseNameToUriConverter', 'Phpactor\\Rename\\Adapter\\WorseReflection\\WorseNameToUriConverter', \false);
