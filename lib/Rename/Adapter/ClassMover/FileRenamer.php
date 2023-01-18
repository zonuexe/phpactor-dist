<?php

namespace Phpactor202301\Phpactor\Rename\Adapter\ClassMover;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\ClassMover\ClassMover;
use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotConvertUriToClass;
use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotRename;
use Phpactor202301\Phpactor\Rename\Model\FileRenamer as PhpactorFileRenamer;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEdit;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEditsMap;
use Phpactor202301\Phpactor\Rename\Model\UriToNameConverter;
use Phpactor202301\Phpactor\Indexer\Model\QueryClient;
use Phpactor202301\Phpactor\TextDocument\Exception\TextDocumentNotFound;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use function Phpactor202301\Amp\call;
class FileRenamer implements PhpactorFileRenamer
{
    public function __construct(private UriToNameConverter $converter, private TextDocumentLocator $locator, private QueryClient $client, private ClassMover $mover)
    {
    }
    /**
     * @return Promise<LocatedTextEditsMap>
     */
    public function renameFile(TextDocumentUri $from, TextDocumentUri $to) : Promise
    {
        return call(function () use($from, $to) {
            try {
                $fromClass = $this->converter->convert($from);
                $toClass = $this->converter->convert($to);
            } catch (CouldNotConvertUriToClass $error) {
                throw new CouldNotRename($error->getMessage(), 0, $error);
            }
            $references = $this->client->class()->referencesTo($fromClass);
            // rename class definition
            $locatedEdits = $this->replaceDefinition($to, $fromClass, $toClass);
            $edits = TextEdits::none();
            $seen = [];
            foreach ($references as $reference) {
                if (isset($seen[$reference->location()->uri()->path()])) {
                    continue;
                }
                $seen[$reference->location()->uri()->path()] = \true;
                try {
                    $document = $this->locator->get($reference->location()->uri());
                } catch (TextDocumentNotFound) {
                    continue;
                }
                foreach ($this->mover->replaceReferences($this->mover->findReferences($document->__toString(), $fromClass), $toClass) as $edit) {
                    $locatedEdits[] = new LocatedTextEdit($reference->location()->uri(), $edit);
                }
            }
            return LocatedTextEditsMap::fromLocatedEdits($locatedEdits);
        });
    }
    /**
     * @return LocatedTextEdit[]
     */
    private function replaceDefinition(TextDocumentUri $file, string $fromClass, string $toClass) : array
    {
        $document = $this->locator->get($file);
        $locatedEdits = [];
        foreach ($this->mover->replaceReferences($this->mover->findReferences($document, $fromClass), $toClass) as $edit) {
            $locatedEdits[] = new LocatedTextEdit($file, $edit);
        }
        return $locatedEdits;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Adapter\\ClassMover\\FileRenamer', 'Phpactor\\Rename\\Adapter\\ClassMover\\FileRenamer', \false);
