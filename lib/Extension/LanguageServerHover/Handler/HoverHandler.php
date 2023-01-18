<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerHover\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\Hover;
use Phpactor202301\Phpactor\LanguageServerProtocol\MarkupContent;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentIdentifier;
use Phpactor202301\Phpactor\Completion\Core\Exception\CouldNotFormat;
use Phpactor202301\Phpactor\Extension\LanguageServerHover\Renderer\HoverInformation;
use Phpactor202301\Phpactor\Extension\LanguageServerHover\Renderer\MemberDocblock;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\ObjectRenderer\Model\ObjectRenderer;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionOffset;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class HoverHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private Workspace $workspace, private Reflector $reflector, private ObjectRenderer $renderer)
    {
    }
    public function methods() : array
    {
        return ['textDocument/hover' => 'hover'];
    }
    /**
     * @return Promise<Hover|null>
     */
    public function hover(TextDocumentIdentifier $textDocument, Position $position) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($textDocument, $position) {
            $document = $this->workspace->get($textDocument->uri);
            $offset = PositionConverter::positionToByteOffset($position, $document->text);
            $document = TextDocumentBuilder::create($document->text)->uri($document->uri)->language('php')->build();
            $char = \substr($document, $offset->toInt(), 1);
            // do not provide hover for whitespace
            if (\trim($char) == '') {
                return null;
            }
            $offsetReflection = $this->reflector->reflectOffset($document, $offset);
            $info = $this->infoFromReflecionOffset($offsetReflection);
            $string = new MarkupContent('markdown', $info);
            $nodeContext = $offsetReflection->symbolContext();
            return new Hover($string, new Range(PositionConverter::byteOffsetToPosition(ByteOffset::fromInt($nodeContext->symbol()->position()->start()), $document->__toString()), PositionConverter::byteOffsetToPosition(ByteOffset::fromInt($nodeContext->symbol()->position()->end()), $document->__toString())));
        });
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->hoverProvider = \true;
    }
    private function infoFromReflecionOffset(ReflectionOffset $offset) : string
    {
        $nodeContext = $offset->symbolContext();
        if ($info = $this->infoFromSymbolContext($nodeContext)) {
            return $info;
        }
        return $this->renderer->render($offset);
    }
    private function infoFromSymbolContext(NodeContext $nodeContext) : ?string
    {
        try {
            return $this->renderSymbolContext($nodeContext);
        } catch (CouldNotFormat) {
        }
        return null;
    }
    private function renderSymbolContext(NodeContext $nodeContext) : ?string
    {
        return match ($nodeContext->symbol()->symbolType()) {
            Symbol::METHOD, Symbol::PROPERTY, Symbol::CONSTANT => $this->renderMember($nodeContext),
            Symbol::CLASS_ => $this->renderClass($nodeContext->type()),
            Symbol::FUNCTION => $this->renderFunction($nodeContext),
            Symbol::DECLARED_CONSTANT => $this->renderDeclaredConstant($nodeContext),
            default => null,
        };
    }
    private function renderMember(NodeContext $nodeContext) : string
    {
        $name = $nodeContext->symbol()->name();
        $container = $nodeContext->containerType();
        $infos = [];
        foreach ($container->expandTypes()->classLike() as $namedType) {
            try {
                $class = $this->reflector->reflectClassLike((string) $namedType);
                $member = null;
                $sep = '#';
                // note that all class-likes (classes, traits and interfaces) have
                // methods but not all have constants or properties, so we play safe
                // with members() which is first-come-first-serve, rather than risk
                // a fatal error because of a non-existing method.
                $symbolType = $nodeContext->symbol()->symbolType();
                switch ($symbolType) {
                    case Symbol::METHOD:
                        $member = $class->methods()->get($name);
                        $sep = '#';
                        break;
                    case Symbol::CONSTANT:
                        $sep = '::';
                        $member = $class->members()->get($name);
                        break;
                    case Symbol::PROPERTY:
                        $sep = '$';
                        $member = $class->members()->get($name);
                        break;
                    default:
                        return \sprintf('Unknown symbol type "%s"', $symbolType);
                }
                $infos[] = $this->renderer->render(new HoverInformation($namedType->short() . ' ' . $sep . ' ' . (string) $member->name(), $this->renderer->render(new MemberDocblock($member)), $member));
            } catch (NotFound) {
                continue;
            }
        }
        return \implode("\n", $infos);
    }
    private function renderFunction(NodeContext $nodeContext) : string
    {
        $name = $nodeContext->symbol()->name();
        try {
            $function = $this->reflector->reflectFunction($name);
        } catch (NotFound $notFound) {
            return $notFound->getMessage();
        }
        return $this->renderer->render(new HoverInformation($name, $this->renderer->render($function->docblock()), $function));
    }
    private function renderClass(Type $type) : string
    {
        try {
            $class = $this->reflector->reflectClassLike((string) $type);
            return $this->renderer->render(new HoverInformation($type->short(), $class->docblock()->formatted(), $class));
        } catch (NotFound $e) {
            return $e->getMessage();
        }
    }
    private function renderDeclaredConstant(NodeContext $context) : ?string
    {
        try {
            $constant = $this->reflector->reflectConstant($context->symbol()->name());
            return $this->renderer->render(new HoverInformation($context->symbol()->name(), $constant->docblock()->formatted(), $constant));
        } catch (NotFound $e) {
            return $e->getMessage();
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerHover\\Handler\\HoverHandler', 'Phpactor\\Extension\\LanguageServerHover\\Handler\\HoverHandler', \false);