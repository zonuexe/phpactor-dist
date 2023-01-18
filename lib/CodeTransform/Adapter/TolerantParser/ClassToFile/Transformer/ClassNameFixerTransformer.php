<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\TolerantParser\ClassToFile\Transformer;

use Phpactor202301\Microsoft\PhpParser\ClassLike;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\EnumDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InlineHtml;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\NamespaceDefinition;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassName;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FilePath;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FileToClass;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostic;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostics;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformer;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use RuntimeException;
class ClassNameFixerTransformer implements Transformer
{
    private Parser $parser;
    public function __construct(private FileToClass $fileToClass, Parser $parser = null)
    {
        $this->parser = $parser ?: new Parser();
    }
    public function transform(SourceCode $code) : TextEdits
    {
        if ($code->uri()->scheme() !== 'file') {
            throw new TransformException(\sprintf('Source is not a file:// it is "%s"', $code->uri()->scheme()));
        }
        $classFqn = $this->determineClassFqn($code);
        $correctClassName = $classFqn->name();
        $correctNamespace = $classFqn->namespace();
        $rootNode = $this->parser->parseSourceFile((string) $code);
        $edits = [];
        if ($textEdit = $this->fixNamespace($rootNode, $correctNamespace)) {
            $edits[] = $textEdit;
        }
        if ($textEdit = $this->fixClassName($rootNode, $correctClassName)) {
            $edits[] = $textEdit;
        }
        return TextEdits::fromTextEdits($edits);
    }
    public function diagnostics(SourceCode $code) : Diagnostics
    {
        if ($code->uri()->scheme() !== 'file') {
            return Diagnostics::none();
        }
        $rootNode = $this->parser->parseSourceFile((string) $code);
        try {
            $classFqn = $this->determineClassFqn($code);
        } catch (RuntimeException) {
            return Diagnostics::none();
        }
        $correctClassName = $classFqn->name();
        $correctNamespace = $classFqn->namespace();
        $diagnostics = [];
        if (null !== $this->fixNamespace($rootNode, $correctNamespace)) {
            $namespaceDefinition = $rootNode->getFirstDescendantNode(NamespaceDefinition::class);
            $diagnostics[] = new Diagnostic(ByteOffsetRange::fromInts($namespaceDefinition ? $namespaceDefinition->getStartPosition() : 0, $namespaceDefinition ? $namespaceDefinition->getEndPosition() : 0), \sprintf('Namespace should probably be "%s"', $correctNamespace), Diagnostic::WARNING);
        }
        if (null !== ($edits = $this->fixClassName($rootNode, $correctClassName))) {
            $classLike = $rootNode->getFirstDescendantNode(ClassLike::class);
            $diagnostics[] = new Diagnostic(ByteOffsetRange::fromInts($classLike ? $classLike->getStartPosition() : 0, $classLike ? $classLike->getEndPosition() : 0), \sprintf('Class name should probably be "%s"', $correctClassName), Diagnostic::WARNING);
        }
        return new Diagnostics($diagnostics);
    }
    private function fixClassName(SourceFileNode $rootNode, string $correctClassName) : ?TextEdit
    {
        $classLike = $rootNode->getFirstDescendantNode(ClassLike::class);
        if (null === $classLike) {
            return null;
        }
        \assert($classLike instanceof EnumDeclaration || $classLike instanceof ClassDeclaration || $classLike instanceof InterfaceDeclaration || $classLike instanceof TraitDeclaration);
        $name = $classLike->name->getText($rootNode->getFileContents());
        if (!\is_string($name) || $name === $correctClassName) {
            return null;
        }
        return TextEdit::create($classLike->name->start, \strlen($name), $correctClassName);
    }
    private function fixNamespace(SourceFileNode $rootNode, string $correctNamespace) : ?TextEdit
    {
        $namespaceDefinition = $rootNode->getFirstDescendantNode(NamespaceDefinition::class);
        \assert($namespaceDefinition instanceof NamespaceDefinition || \is_null($namespaceDefinition));
        $statement = \sprintf('namespace %s;', $correctNamespace);
        if ($correctNamespace && null === $namespaceDefinition) {
            $scriptStart = $rootNode->getFirstDescendantNode(InlineHtml::class);
            $scriptStart = $scriptStart ? $scriptStart->getEndPosition() : 0;
            $statement = \PHP_EOL . $statement . \PHP_EOL;
            if (0 === $scriptStart) {
                $statement = '<?php' . \PHP_EOL . $statement;
            }
            return TextEdit::create($scriptStart, 0, $statement);
        }
        if (null === $namespaceDefinition) {
            return null;
        }
        if ($namespaceDefinition->name instanceof QualifiedName) {
            if ($namespaceDefinition->name->__toString() === $correctNamespace) {
                return null;
            }
        }
        return TextEdit::create($namespaceDefinition->getStartPosition(), $namespaceDefinition->getEndPosition() - $namespaceDefinition->getStartPosition(), $statement);
    }
    private function determineClassFqn(SourceCode $code) : ClassName
    {
        if (!$code->path()) {
            throw new RuntimeException('Source code has no path associated with it');
        }
        $candidates = $this->fileToClass->fileToClassCandidates(FilePath::fromString((string) $code->path()));
        $classFqn = $candidates->best();
        return $classFqn;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\TolerantParser\\ClassToFile\\Transformer\\ClassNameFixerTransformer', 'Phpactor\\CodeTransform\\Adapter\\TolerantParser\\ClassToFile\\Transformer\\ClassNameFixerTransformer', \false);
