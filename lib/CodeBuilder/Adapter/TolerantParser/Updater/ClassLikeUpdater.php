<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\Updater;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\ClassConstDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\PropertyDeclaration;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\Edits;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\ClassLikePrototype;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Type;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Renderer;
use InvalidArgumentException;
abstract class ClassLikeUpdater
{
    protected ClassMethodUpdater $methodUpdater;
    public function __construct(protected Renderer $renderer)
    {
        $this->methodUpdater = new ClassMethodUpdater($renderer);
    }
    protected function resolvePropertyName(Node|Token $property) : ?string
    {
        if ($property instanceof Variable) {
            return $property->getName();
        }
        if ($property instanceof AssignmentExpression) {
            return $this->resolvePropertyName($property->leftOperand);
        }
        throw new InvalidArgumentException(\sprintf('Do not know how to resolve property element of type "%s"', \get_class($property)));
    }
    protected abstract function memberDeclarations(Node $node) : array;
    protected function updateProperties(Edits $edits, ClassLikePrototype $classPrototype, Node $classMembers) : void
    {
        if (\count($classPrototype->properties()) === 0) {
            return;
        }
        $memberDeclarations = $this->memberDeclarations($classMembers);
        $lastProperty = $this->getInsertPlace($classMembers, $memberDeclarations);
        $nextMember = null;
        $existingPropertyNames = [];
        foreach ($memberDeclarations as $memberNode) {
            if (null === $nextMember) {
                $nextMember = $memberNode;
            }
            if ($memberNode instanceof PropertyDeclaration) {
                foreach ($memberNode->propertyElements->getElements() as $property) {
                    $existingPropertyNames[] = $this->resolvePropertyName($property);
                }
                $lastProperty = $memberNode;
                $nextMember = \next($memberDeclarations) ?: $nextMember;
                \prev($memberDeclarations);
            }
        }
        foreach ($classPrototype->properties()->notIn($existingPropertyNames) as $property) {
            // if property type exists then the last property has a docblock - add a line break
            if ($lastProperty instanceof PropertyDeclaration && $property->type() != Type::none()) {
                $edits->after($lastProperty, \PHP_EOL);
            }
            $edits->after($lastProperty, \PHP_EOL . $edits->indent($this->renderer->render($property), 1));
            if ($classPrototype->properties()->isLast($property) && $nextMember instanceof MethodDeclaration) {
                $edits->after($lastProperty, \PHP_EOL);
            }
        }
    }
    /**
     * @param Node[] $memberDeclarations
     */
    protected function getInsertPlace(Node $classNode, array $memberDeclarations) : Token
    {
        $insert = $classNode->openBrace;
        foreach ($memberDeclarations as $member) {
            if ($member instanceof ClassConstDeclaration) {
                $insert = $member->semicolon;
            } else {
                break;
            }
        }
        return $insert;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\TolerantParser\\Updater\\ClassLikeUpdater', 'Phpactor\\CodeBuilder\\Adapter\\TolerantParser\\Updater\\ClassLikeUpdater', \false);
