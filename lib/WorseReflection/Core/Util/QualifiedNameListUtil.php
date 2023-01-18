<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Util;

use Phpactor202301\Microsoft\PhpParser\MissingToken;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Token;
use RuntimeException;
class QualifiedNameListUtil
{
    /**
     * @param mixed $qualifiedNameOrList
     */
    public static function firstQualifiedName($qualifiedNameOrList) : ?QualifiedName
    {
        if ($qualifiedNameOrList instanceof QualifiedNameList) {
            return self::firstQualifiedNameOrNull($qualifiedNameOrList);
        }
        if ($qualifiedNameOrList instanceof QualifiedName) {
            return $qualifiedNameOrList;
        }
        return null;
    }
    /**
     * @param mixed $qualifiedNameOrList
     * @return Token|QualifiedName|null
     */
    public static function firstQualifiedNameOrToken($qualifiedNameOrList)
    {
        if ($qualifiedNameOrList instanceof QualifiedNameList) {
            return self::firstQualifiedNameOrNullOrToken($qualifiedNameOrList);
        }
        if ($qualifiedNameOrList instanceof QualifiedName) {
            return $qualifiedNameOrList;
        }
        if ($qualifiedNameOrList instanceof Token) {
            return $qualifiedNameOrList;
        }
        if (null === $qualifiedNameOrList) {
            return null;
        }
        throw new RuntimeException(\sprintf('Do not know how to resolve qualified name from class "%s"', \get_class($qualifiedNameOrList)));
    }
    public static function firstQualifiedNameOrNull(?QualifiedNameList $types) : ?QualifiedName
    {
        if (!$types) {
            return null;
        }
        foreach ($types->children as $child) {
            if (!$child instanceof QualifiedName) {
                continue;
            }
            return $child;
        }
        return null;
    }
    /**
     * @return MissingToken|Token|QualifiedName|null
     */
    public static function firstQualifiedNameOrNullOrToken(QualifiedNameList|null|MissingToken $types)
    {
        if (!$types instanceof QualifiedNameList) {
            return null;
        }
        foreach ($types->children as $child) {
            if (!$child instanceof QualifiedName && !$child instanceof Token) {
                continue;
            }
            return $child;
        }
        return null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Util\\QualifiedNameListUtil', 'Phpactor\\WorseReflection\\Core\\Util\\QualifiedNameListUtil', \false);
