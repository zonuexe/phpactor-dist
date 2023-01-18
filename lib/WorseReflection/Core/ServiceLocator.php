<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core;

use Phpactor202301\Phpactor\WorseReflection\Bridge\Phpactor\DocblockParser\CachedParserFactory;
use Phpactor202301\Phpactor\WorseReflection\Bridge\Phpactor\DocblockParser\DocblockParserFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Cache\NullCache;
use Phpactor202301\Phpactor\WorseReflection\Core\Cache\StaticCache;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\GenericMapResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver\MemberAccess\MemberContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver\MemberAccess\NodeContextFromMemberAccess;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker\DiagnosticsWalker;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker\PassThroughWalker;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker\FunctionLikeWalker;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker\IncludeWalker;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker\VariableWalker;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeToTypeConverter;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FrameResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Virtual\ChainReflectionMemberProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\Virtual\ReflectionMemberProvider;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\CoreReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\CompositeReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\ClassReflector\MemonizedReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCode\ContextualSourceCodeReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\ChainSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\TemporarySourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlockFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCodeReflectorFactory;
use Phpactor202301\Psr\Log\LoggerInterface;
class ServiceLocator
{
    private SourceCodeLocator $sourceLocator;
    private LoggerInterface $logger;
    private Reflector $reflector;
    private DocBlockFactory $docblockFactory;
    private Cache $cache;
    private NodeToTypeConverter $nameResolver;
    /**
     * @param Walker[] $frameWalkers
     * @param ReflectionMemberProvider[] $methodProviders
     * @param DiagnosticProvider[] $diagnosticProviders
     * @param MemberContextResolver[] $memberContextResolvers
     */
    public function __construct(SourceCodeLocator $sourceLocator, LoggerInterface $logger, SourceCodeReflectorFactory $reflectorFactory, private array $frameWalkers, private array $methodProviders, private array $diagnosticProviders, private array $memberContextResolvers, Cache $cache, bool $enableContextualLocation = \false)
    {
        $sourceReflector = $reflectorFactory->create($this);
        if ($enableContextualLocation) {
            $temporarySourceLocator = new TemporarySourceLocator($sourceReflector);
            $sourceLocator = new ChainSourceLocator([$temporarySourceLocator, $sourceLocator], $logger);
            $sourceReflector = new ContextualSourceCodeReflector($sourceReflector, $temporarySourceLocator);
        }
        $coreReflector = new CoreReflector($sourceReflector, $sourceLocator);
        if (!$cache instanceof NullCache) {
            $coreReflector = new MemonizedReflector($coreReflector, $coreReflector, $coreReflector, $cache);
        }
        $this->reflector = new CompositeReflector($coreReflector, $sourceReflector, $coreReflector, $coreReflector);
        $this->sourceLocator = $sourceLocator;
        $this->docblockFactory = new DocblockParserFactory($this->reflector);
        if (!$cache instanceof NullCache) {
            $this->docblockFactory = new CachedParserFactory($this->docblockFactory, $cache);
        }
        $this->logger = $logger;
        $this->nameResolver = new NodeToTypeConverter($this->reflector, $this->logger);
        $this->cache = $cache;
    }
    public function reflector() : Reflector
    {
        return $this->reflector;
    }
    public function logger() : LoggerInterface
    {
        return $this->logger;
    }
    public function sourceLocator() : SourceCodeLocator
    {
        return $this->sourceLocator;
    }
    public function docblockFactory() : DocBlockFactory
    {
        return $this->docblockFactory;
    }
    public function symbolContextResolver() : NodeContextResolver
    {
        return new NodeContextResolver($this->reflector, $this->docblockFactory, $this->logger, new StaticCache(), (new DefaultResolverFactory($this->reflector, $this->nameResolver, new GenericMapResolver($this->reflector), new NodeContextFromMemberAccess(new GenericMapResolver($this->reflector), $this->memberContextResolvers)))->createResolvers());
    }
    public function frameBuilder() : FrameResolver
    {
        return FrameResolver::create($this->symbolContextResolver(), \array_merge([new FunctionLikeWalker(), new PassThroughWalker(), new VariableWalker($this->docblockFactory), new IncludeWalker($this->logger)], $this->frameWalkers));
    }
    public function methodProviders() : ReflectionMemberProvider
    {
        return new ChainReflectionMemberProvider(...$this->methodProviders);
    }
    public function cache() : Cache
    {
        return $this->cache;
    }
    public function newDiagnosticsWalker() : DiagnosticsWalker
    {
        return new DiagnosticsWalker($this->diagnosticProviders);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\ServiceLocator', 'Phpactor\\WorseReflection\\Core\\ServiceLocator', \false);
