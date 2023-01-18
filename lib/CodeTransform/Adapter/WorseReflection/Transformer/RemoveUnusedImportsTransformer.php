<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Transformer;

use Phpactor202301\Microsoft\PhpParser\Node\NamespaceUseClause;
use Phpactor202301\Microsoft\PhpParser\Node\NamespaceUseGroupClause;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\NamespaceUseDeclaration;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostic;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostics;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformer;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\UnusedImportDiagnostic;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Diagnostics as WorseDiagnostics;
class RemoveUnusedImportsTransformer implements Transformer
{
    /**
     * @var array<int, bool>
     */
    private array $fixed = [];
    public function __construct(private Reflector $reflector, private Parser $parser)
    {
    }
    public function transform(SourceCode $code) : TextEdits
    {
        $rootNode = $this->parser->parseSourceFile($code);
        $edits = [];
        foreach ($this->unusedImports($code) as $unusedImport) {
            $importNode = $rootNode->getDescendantNodeAtPosition($unusedImport->range()->start()->toInt());
            if (!$importNode instanceof QualifiedName) {
                continue;
            }
            $list = $importNode->getFirstAncestor(NamespaceUseClause::class);
            if (!$list instanceof NamespaceUseClause) {
                continue;
            }
            if ($list->groupClauses) {
                if ($edit = $this->forGroupClause($importNode, $list)) {
                    $edits[] = $edit;
                }
                continue;
            }
            // there is exactly one element
            $declaration = $importNode->getFirstAncestor(NamespaceUseDeclaration::class);
            $length = $declaration->getEndPosition() - $declaration->getStartPosition();
            if (\substr($code->__toString(), $declaration->getEndPosition(), 1) === "\n") {
                $length++;
            }
            $edits[] = TextEdit::create($declaration->getStartPosition(), $length, '');
        }
        return TextEdits::fromTextEdits($edits);
    }
    /**
     * @return Diagnostics<Diagnostic>
     */
    public function diagnostics(SourceCode $code) : Diagnostics
    {
        $diagnostics = [];
        foreach ($this->unusedImports($code) as $unusedClass) {
            $diagnostics[] = new Diagnostic($unusedClass->range(), $unusedClass->message(), Diagnostic::WARNING);
        }
        return new Diagnostics($diagnostics);
    }
    /**
     * @return WorseDiagnostics<UnusedImportDiagnostic>
     */
    private function unusedImports(SourceCode $code) : WorseDiagnostics
    {
        return $this->reflector->diagnostics($code->__toString())->byClass(UnusedImportDiagnostic::class);
    }
    private function forGroupClause(QualifiedName $importNode, NamespaceUseClause $list) : ?TextEdit
    {
        $fixed = \spl_object_id($list);
        if (isset($this->fixed[$fixed])) {
            return null;
        }
        $this->fixed[$fixed] = \true;
        $names = [];
        foreach ($list->groupClauses->children as $groupClause) {
            if (!$groupClause instanceof NamespaceUseGroupClause) {
                continue;
            }
            if ($groupClause->namespaceName->__toString() === $importNode->__toString()) {
                continue;
            }
            $names[] = $groupClause->__toString();
        }
        $groupClauses = $list->groupClauses;
        if (null === $groupClauses) {
            return null;
        }
        return TextEdit::create($groupClauses->getStartPosition(), $groupClauses->getEndPosition() - $groupClauses->getStartPosition(), \implode(', ', $names));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Transformer\\RemoveUnusedImportsTransformer', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Transformer\\RemoveUnusedImportsTransformer', \false);