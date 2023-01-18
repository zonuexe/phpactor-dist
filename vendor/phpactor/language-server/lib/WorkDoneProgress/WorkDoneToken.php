<?php

namespace Phpactor202301\Phpactor\LanguageServer\WorkDoneProgress;

use Phpactor202301\Ramsey\Uuid\Uuid;
final class WorkDoneToken
{
    /**
     * @var string
     */
    private $token;
    public function __construct(string $token)
    {
        $this->token = $token;
    }
    public function __toString() : string
    {
        return $this->token;
    }
    public static function generate() : self
    {
        return new self((string) Uuid::uuid4());
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\WorkDoneProgress\\WorkDoneToken', 'Phpactor\\LanguageServer\\WorkDoneProgress\\WorkDoneToken', \false);
