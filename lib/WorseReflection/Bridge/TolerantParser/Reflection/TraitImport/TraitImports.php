<?php

namespace Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\TraitImport;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\QualifiedName;
use PhpactorDist\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use PhpactorDist\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use PhpactorDist\Microsoft\PhpParser\Node\TraitSelectOrAliasClause;
use PhpactorDist\Microsoft\PhpParser\Node\TraitUseClause;
use PhpactorDist\Microsoft\PhpParser\TokenKind;
use Phpactor\WorseReflection\Bridge\TolerantParser\Patch\TolerantQualifiedNameResolver;
use Phpactor\WorseReflection\Core\Util\QualifiedNameListUtil;
use Phpactor\WorseReflection\Core\Visibility;
use RuntimeException;
use Traversable;
/**
 * @implements IteratorAggregate<string,TraitImport>
 */
final class TraitImports implements Countable, IteratorAggregate
{
    /**
     * @var array<string,TraitImport>
     */
    private array $imports = [];
    /**
     * @param Node[] $declarations
     */
    private function __construct(array $declarations)
    {
        foreach ($declarations as $memberDeclaration) {
            if (\false === $memberDeclaration instanceof TraitUseClause) {
                continue;
            }
            if ($memberDeclaration->traitNameList == null) {
                continue;
            }
            $traitNames = \array_filter(\array_map(function ($name) {
                if (!$name instanceof QualifiedName) {
                    return null;
                }
                return (string) TolerantQualifiedNameResolver::getResolvedName($name);
            }, \iterator_to_array($memberDeclaration->traitNameList->getElements())));
            if (empty($traitNames)) {
                continue;
            }
            if (null === $memberDeclaration->traitSelectAndAliasClauses) {
                foreach ($traitNames as $traitName) {
                    $this->imports[$traitName] = new \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\TraitImport\TraitImport($traitName);
                }
                continue;
            }
            foreach ($traitNames as $traitName) {
                $aliases = [];
                foreach ($memberDeclaration->traitSelectAndAliasClauses as $selectAndAliasClauses) {
                    foreach ($selectAndAliasClauses as $clause) {
                        if (\false === $clause instanceof TraitSelectOrAliasClause) {
                            continue;
                        }
                        // Only support "as" keyword, do not support "insteadof"
                        // (the last one will win in the reflection class logic
                        // currently).
                        if ($clause->asOrInsteadOfKeyword->kind !== TokenKind::AsKeyword) {
                            continue;
                        }
                        if (!$clause->name instanceof QualifiedName) {
                            continue;
                        }
                        $targetName = QualifiedNameListUtil::firstQualifiedName($clause->targetNameList);
                        if (null === $targetName) {
                            continue;
                        }
                        $memberName = (string) $clause->name;
                        $targetName = (string) $targetName;
                        $aliases[$memberName] = new \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\TraitImport\TraitAlias($memberName, $this->visiblity($clause), $targetName);
                    }
                }
                $this->imports[$traitName] = new \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\TraitImport\TraitImport($traitName, $aliases);
            }
        }
    }
    public static function forClassDeclaration(ClassDeclaration $classDeclaration) : self
    {
        return new self($classDeclaration->classMembers->classMemberDeclarations);
    }
    public static function forTraitDeclaration(TraitDeclaration $traitDeclaration) : self
    {
        return new self($traitDeclaration->traitMembers->traitMemberDeclarations);
    }
    public function has(string $name) : bool
    {
        return isset($this->imports[$name]);
    }
    public function get(string $name) : \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\TraitImport\TraitImport
    {
        if (!\array_key_exists($name, $this->imports)) {
            throw new RuntimeException(\sprintf('Trait import "%s" does not exist', $name));
        }
        return $this->imports[$name];
    }
    public function count() : int
    {
        return \count($this->imports);
    }
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->imports);
    }
    private function visiblity(TraitSelectOrAliasClause $clause)
    {
        foreach ($clause->modifiers as $modifier) {
            if ($modifier->kind === TokenKind::PrivateKeyword) {
                return Visibility::private();
            }
            if ($modifier->kind === TokenKind::ProtectedKeyword) {
                return Visibility::protected();
            }
            if ($modifier->kind === TokenKind::PublicKeyword) {
                return Visibility::public();
            }
        }
        return null;
    }
}
