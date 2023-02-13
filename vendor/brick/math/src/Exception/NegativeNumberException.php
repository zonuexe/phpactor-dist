<?php

declare (strict_types=1);
namespace PhpactorDist\Brick\Math\Exception;

/**
 * Exception thrown when attempting to perform an unsupported operation, such as a square root, on a negative number.
 */
class NegativeNumberException extends MathException
{
}
