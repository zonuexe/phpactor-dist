<?php

declare (strict_types=1);
/**
 * Enumeration of possible resource QCLASS values
 *
 * PHP version 5.4
 *
 * @category LibDNS
 * @package Records
 * @author Chris Wright <https://github.com/DaveRandom>
 * @copyright Copyright (c) Chris Wright <https://github.com/DaveRandom>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @version 2.0.0
 */
namespace PhpactorDist\LibDNS\Records;

/**
 * Enumeration of possible resource QCLASS values
 *
 * @category LibDNS
 * @package Records
 * @author Chris Wright <https://github.com/DaveRandom>
 */
final class ResourceQClasses extends ResourceClasses
{
    const ANY = 255;
}
