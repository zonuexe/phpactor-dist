<?php

namespace Phpactor202301\Phpactor;

use Phpactor202301\Phpactor\ClassMover\Extension\ClassMoverExtension as MainClassMoverExtension;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\OptionalExtension;
use Phpactor202301\Phpactor\Extension\Behat\BehatExtension;
use Phpactor202301\Phpactor\Extension\Debug\DebugExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerBlackfire\LanguageServerBlackfireExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpCsFixer\LanguageServerPhpCsFixerExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\LanguageServerPhpstanExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\LanguageServerBridgeExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LanguageServerCodeTransformExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerCompletion\LanguageServerCompletionExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerDiagnostics\LanguageServerDiagnosticsExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerHover\LanguageServerHoverExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\LanguageServerIndexerExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\LanguageServerPsalmExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\LanguageServerReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\LanguageServerRenameExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\LanguageServerRenameWorseExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerSymbolProvider\LanguageServerSymbolProviderExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerSelectionRange\LanguageServerSelectionRangeExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\LanguageServerWorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtraExtension;
use Phpactor202301\Phpactor\Extension\ObjectRenderer\ObjectRendererExtension;
use Phpactor202301\Phpactor\Extension\PHPUnit\PHPUnitExtension;
use Phpactor202301\Phpactor\Extension\Prophecy\ProphecyExtension;
use Phpactor202301\Phpactor\Extension\Symfony\SymfonyExtension;
use Phpactor202301\Phpactor\Extension\WorseReflectionAnalyse\WorseReflectionAnalyseExtension;
use Phpactor202301\Phpactor\Indexer\Extension\IndexerExtension;
use RuntimeException;
use Phpactor202301\Symfony\Component\Console\Output\ConsoleOutputInterface;
use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Core\CoreExtension;
use Phpactor202301\Phpactor\Extension\CodeTransformExtra\CodeTransformExtraExtension;
use Phpactor202301\Phpactor\Extension\CodeTransform\CodeTransformExtension;
use Phpactor202301\Phpactor\Extension\CompletionExtra\CompletionExtraExtension;
use Phpactor202301\Phpactor\Extension\Completion\CompletionExtension;
use Phpactor202301\Phpactor\Extension\CompletionRpc\CompletionRpcExtension;
use Phpactor202301\Phpactor\Extension\CompletionWorse\CompletionWorseExtension;
use Phpactor202301\Phpactor\Extension\Navigation\NavigationExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystemExtra\SourceCodeFilesystemExtraExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\Extension\WorseReflectionExtra\WorseReflectionExtraExtension;
use Phpactor202301\Phpactor\Extension\WorseReferenceFinder\WorseReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\ClassMover\ClassMoverExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\ContextMenu\ContextMenuExtension;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\Php\PhpExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Symfony\Component\Console\Input\InputInterface;
use Phpactor202301\Phpactor\Extension\ClassToFileExtra\ClassToFileExtraExtension;
use Phpactor202301\Composer\XdebugHandler\XdebugHandler;
use Phpactor202301\Phpactor\ConfigLoader\ConfigLoaderBuilder;
use Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\ReferenceFinderRpcExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use function ini_set;
use function sprintf;
class Phpactor
{
    public static function boot(InputInterface $input, OutputInterface $output, string $vendorDir) : Container
    {
        $config = [];
        $projectRoot = \getcwd();
        if ($input->hasParameterOption(['--working-dir', '-d'])) {
            $projectRoot = $input->getParameterOption(['--working-dir', '-d']);
        }
        $commandName = $input->getFirstArgument();
        $loader = ConfigLoaderBuilder::create()->enableJsonDeserializer('json')->enableYamlDeserializer('yaml')->addXdgCandidate('phpactor', 'phpactor.json', 'json')->addXdgCandidate('phpactor', 'phpactor.yml', 'yaml')->addCandidate($projectRoot . '/.phpactor.json', 'json')->addCandidate($projectRoot . '/.phpactor.yml', 'yaml')->loader();
        $config = $loader->load();
        $config[CoreExtension::PARAM_COMMAND] = $input->getFirstArgument();
        $config[FilePathResolverExtension::PARAM_APPLICATION_ROOT] = self::resolveApplicationRoot();
        $config = \array_merge([IndexerExtension::PARAM_STUB_PATHS => []], $config);
        $config[IndexerExtension::PARAM_STUB_PATHS][] = self::resolveApplicationRoot() . '/vendor/jetbrains/phpstorm-stubs';
        $config = self::configureLanguageServer($config);
        if ($input->hasParameterOption(['--working-dir', '-d'])) {
            $config[FilePathResolverExtension::PARAM_PROJECT_ROOT] = $projectRoot;
        }
        if (!isset($config[CoreExtension::PARAM_XDEBUG_DISABLE]) || $config[CoreExtension::PARAM_XDEBUG_DISABLE]) {
            $xdebug = new XdebugHandler('PHPACTOR');
            $xdebug->check();
            unset($xdebug);
        }
        $extensionNames = [CoreExtension::class, ClassToFileExtraExtension::class, ClassToFileExtension::class, ClassMoverExtension::class, MainClassMoverExtension::class, CodeTransformExtension::class, CodeTransformExtraExtension::class, CompletionExtraExtension::class, CompletionWorseExtension::class, CompletionExtension::class, CompletionRpcExtension::class, NavigationExtension::class, ContextMenuExtension::class, RpcExtension::class, SourceCodeFilesystemExtraExtension::class, SourceCodeFilesystemExtension::class, WorseReflectionExtension::class, WorseReflectionExtraExtension::class, WorseReflectionAnalyseExtension::class, FilePathResolverExtension::class, LoggingExtension::class, ComposerAutoloaderExtension::class, ConsoleExtension::class, WorseReferenceFinderExtension::class, ReferenceFinderRpcExtension::class, ReferenceFinderExtension::class, PhpExtension::class, LanguageServerExtension::class, LanguageServerCompletionExtension::class, LanguageServerReferenceFinderExtension::class, LanguageServerWorseReflectionExtension::class, LanguageServerIndexerExtension::class, LanguageServerHoverExtension::class, LanguageServerBridgeExtension::class, LanguageServerCodeTransformExtension::class, LanguageServerSymbolProviderExtension::class, LanguageServerSelectionRangeExtension::class, LanguageServerExtraExtension::class, LanguageServerDiagnosticsExtension::class, LanguageServerRenameExtension::class, LanguageServerRenameWorseExtension::class, IndexerExtension::class, ObjectRendererExtension::class, LanguageServerPhpstanExtension::class, LanguageServerPsalmExtension::class, LanguageServerBlackfireExtension::class, LanguageServerPhpCsFixerExtension::class, BehatExtension::class, SymfonyExtension::class, ProphecyExtension::class, PHPUnitExtension::class];
        if (\class_exists(DebugExtension::class)) {
            $extensionNames[] = DebugExtension::class;
        }
        $container = new PhpactorContainer();
        $container->register('config_loader.candidates', function () use($loader) {
            return $loader->candidates();
        });
        $masterSchema = new Resolver(\true);
        $extensions = [];
        foreach ($extensionNames as $extensionClass) {
            $schema = new Resolver();
            if (!\class_exists($extensionClass)) {
                if ($output instanceof ConsoleOutputInterface) {
                    $output->getErrorOutput()->writeln(sprintf('<error>Extension "%s" does not exist</>', $extensionClass) . \PHP_EOL);
                }
                continue;
            }
            $extension = new $extensionClass();
            if (!$extension instanceof Extension) {
                throw new RuntimeException(sprintf('Phpactor extension "%s" must implement interface "%s"', \get_class($extension), Extension::class));
            }
            // This is duplicated in ExtensionDocumentor we should not
            // continue to add behavior like this here and should extract
            // this and other special logic.
            if ($extension instanceof OptionalExtension) {
                (function (string $key) use($schema) : void {
                    $schema->setDefaults([$key => \false]);
                    $schema->setTypes([$key => 'boolean']);
                })(sprintf('%s.enabled', $extension->name()));
            }
            $extension->configure($schema);
            $extensions[] = $extension;
            $masterSchema = $masterSchema->merge($schema);
        }
        $masterSchema->setDefaults([
            PhpactorContainer::PARAM_EXTENSION_CLASSES => $extensionNames,
            // enable the LSP watchern
            IndexerExtension::PARAM_ENABLED_WATCHERS => ['lsp', 'inotify', 'find', 'php'],
        ]);
        $config = $masterSchema->resolve($config);
        // > method configure container
        foreach ($extensions as $extension) {
            if ($extension instanceof OptionalExtension) {
                if (\false === ($config[sprintf('%s.enabled', $extension->name())] ?? \false)) {
                    continue;
                }
            }
            $extension->load($container);
        }
        if (isset($config[CoreExtension::PARAM_MIN_MEMORY_LIMIT])) {
            self::updateMinMemory($config[CoreExtension::PARAM_MIN_MEMORY_LIMIT]);
        }
        foreach ($masterSchema->errors()->errors() as $error) {
            // do not polute STDERR for RPC, for some reason the VIM plugin reads also
            // STDERR and possibly other RPC clients too
            if ($commandName !== 'rpc') {
                if ($output instanceof ConsoleOutputInterface) {
                    $output->getErrorOutput()->writeln(sprintf('<error>%s...</>', \substr((string) $error, 0, 100)));
                }
            }
        }
        return $container->build($config);
    }
    /**
     * If the path is relative we need to use the current working path
     * because otherwise it will be the script path, which is wrong in the
     * context of a PHAR.
     *
     * @deprecated Use webmozart Path instead.
     */
    public static function normalizePath(string $path) : string
    {
        if (\substr($path, 0, 1) == \DIRECTORY_SEPARATOR) {
            return $path;
        }
        return \getcwd() . \DIRECTORY_SEPARATOR . $path;
    }
    public static function relativizePath(string $path) : string
    {
        if (\str_starts_with($path, (string) \getcwd())) {
            return \substr($path, \strlen(\getcwd()) + 1);
        }
        return $path;
    }
    public static function isFile(string $string) : bool
    {
        $containsInvalidNamespaceChars = (bool) \preg_match('{[\\.\\*/]}', $string);
        if ($containsInvalidNamespaceChars) {
            return \true;
        }
        return \file_exists($string);
    }
    /**
     * Optimize Phpactor for the language server (these settings will apply
     * only to LanguageServer sessions).
     *
     * @param array<string, mixed> $config
     * @return array<string, mixed>
     */
    private static function configureLanguageServer(array $config) : array
    {
        $config[LanguageServerExtension::PARAM_SESSION_PARAMETERS] = [
            LanguageServerExtension::PARAM_METHOD_ALIAS_MAP => ['indexer/reindex' => 'phpactor/indexer/reindex', 'session/dumpConfig' => 'phpactor/debug/config', 'service/running' => 'phpactor/service/running', 'system/status' => 'phpactor/stats'],
            WorseReflectionExtension::PARAM_ENABLE_CONTEXT_LOCATION => \false,
            ClassToFileExtension::PARAM_BRUTE_FORCE_CONVERSION => \false,
            // these completors are not appropriate for the language server SCF
            // is a brute force, blocking completor. the declared completors
            // use the functions declared in the Phpactor runtime and not the
            // project.
            'completion_worse.completor.scf_class.enabled' => \false,
            'completion_worse.completor.declared_class.enabled' => \false,
            'completion_worse.completor.declared_constant.enabled' => \false,
            'completion_worse.completor.declared_function.enabled' => \false,
        ];
        return $config;
    }
    private static function resolveApplicationRoot() : string
    {
        $paths = [__DIR__ . '/..', __DIR__ . '/../../../..'];
        foreach ($paths as $path) {
            if (\is_dir((string) \realpath($path . '/vendor'))) {
                return (string) \realpath($path);
            }
        }
        throw new RuntimeException(sprintf('Could not resolve application root, tried "%s"', \implode('", "', $paths)));
    }
    /**
     * Update the PHP memory limit according to the configured minimum
     * (borrowed from Composer)
     */
    private static function updateMinMemory(int $minimumMemoryLimit) : void
    {
        $memoryInBytes = function ($value) {
            $unit = \strtolower(\substr($value, -1, 1));
            $value = (int) $value;
            switch ($unit) {
                case 'g':
                    $value *= 1024;
                // no break (cumulative multiplier)
                case 'm':
                    $value *= 1024;
                // no break (cumulative multiplier)
                case 'k':
                    $value *= 1024;
            }
            return $value;
        };
        $memoryLimit = \trim((string) \ini_get('memory_limit'));
        if ($memoryLimit != -1 && $memoryInBytes($memoryLimit) < $minimumMemoryLimit) {
            @ini_set('memory_limit', (string) $minimumMemoryLimit);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Phpactor', 'Phpactor\\Phpactor', \false);
