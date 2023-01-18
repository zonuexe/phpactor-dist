<?php

namespace Phpactor202301\Phpactor\Extension\Behat\ReferenceFinder;

use Phpactor202301\Phpactor\Extension\Behat\Behat\Step;
use Phpactor202301\Phpactor\Extension\Behat\Behat\StepGenerator;
use Phpactor202301\Phpactor\Extension\Behat\Behat\StepParser;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocator;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateDefinition;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\UnsupportedDocument;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocations;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\TextDocument\Util\LineAtOffset;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
class StepDefinitionLocator implements DefinitionLocator
{
    public function __construct(private StepGenerator $generator, private StepParser $parser)
    {
    }
    public function locateDefinition(TextDocument $document, ByteOffset $byteOffset) : TypeLocations
    {
        if (!$document->language()->in(['cucumber', 'behat', 'gherkin'])) {
            throw new UnsupportedDocument(\sprintf('Language must be one of cucumber, behat or gherkin, got "%s"', $document->language()));
        }
        $line = (new LineAtOffset())($document->__toString(), $byteOffset->toInt());
        $stepLines = $this->parser->parseSteps($line);
        if (empty($stepLines)) {
            throw new CouldNotLocateDefinition(\sprintf('Could not parse step line: "%s"', $line));
        }
        $line = \reset($stepLines);
        $steps = $this->findSteps($line);
        return new TypeLocations(\array_map(function (Step $step) {
            return new TypeLocation(TypeFactory::class($step->context()->class()), new Location(TextDocumentUri::fromString($step->path()), ByteOffset::fromInt($step->byteOffset())));
        }, $steps));
    }
    /**
     * @return array<Step>
     */
    private function findSteps(string $line) : array
    {
        $steps = [];
        foreach ($this->generator as $step) {
            if ($step->matches($line)) {
                $steps[] = $step;
            }
        }
        return $steps;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\ReferenceFinder\\StepDefinitionLocator', 'Phpactor\\Extension\\Behat\\ReferenceFinder\\StepDefinitionLocator', \false);
