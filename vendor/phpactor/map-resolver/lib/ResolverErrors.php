<?php

namespace Phpactor\MapResolver;

final class ResolverErrors
{
    /**
     * @var array<InvalidMap>
     */
    private $errors;
    /**
     * @param array<InvalidMap> $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }
    /**
     * @return array<InvalidMap>
     */
    public function errors() : array
    {
        return $this->errors;
    }
    public function hasErrors() : bool
    {
        return \count($this->errors) > 0;
    }
}
