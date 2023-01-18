<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerRename;

use Phpactor202301\Phpactor\ClassMover\ClassMover;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Adapter\Indexer\WorkspaceUpdateReferenceFinder;
use Phpactor202301\Phpactor\Rename\Adapter\ClassMover\FileRenamer as PhpactorFileRenamer;
use Phpactor202301\Phpactor\Rename\Adapter\ClassToFile\ClassToFileNameToUriConverter;
use Phpactor202301\Phpactor\Rename\Adapter\WorseReflection\WorseNameToUriConverter;
use Phpactor202301\Phpactor\Rename\Adapter\ClassToFile\ClassToFileUriToNameConverter;
use Phpactor202301\Phpactor\Rename\Adapter\ReferenceFinder\ClassMover\ClassRenamer;
use Phpactor202301\Phpactor\Rename\Adapter\ReferenceFinder\MemberRenamer;
use Phpactor202301\Phpactor\Rename\Adapter\ReferenceFinder\VariableRenamer;
use Phpactor202301\Phpactor\Rename\Model\FileRenamer;
use Phpactor202301\Phpactor\Rename\Model\FileRenamer\LoggingFileRenamer;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Indexer\Adapter\ReferenceFinder\IndexedImplementationFinder;
use Phpactor202301\Phpactor\Indexer\Model\Indexer;
use Phpactor202301\Phpactor\Indexer\Model\QueryClient;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionAndReferenceFinder;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\WorseReferenceFinder\TolerantVariableReferenceFinder;
class LanguageServerRenameWorseExtension implements Extension
{
    public const TAG_RENAMER = 'language_server_rename.renamer';
    public const PARAM_FILE_RENAME_LISTENER = 'language_server_rename.file_rename_listener';
    public function load(ContainerBuilder $container) : void
    {
        $container->register(VariableRenamer::class, function (Container $container) {
            return new VariableRenamer(new TolerantVariableReferenceFinder($container->get('worse_reflection.tolerant_parser'), \true), $container->get(TextDocumentLocator::class), $container->get('worse_reflection.tolerant_parser'));
        }, [LanguageServerRenameExtension::TAG_RENAMER => []]);
        $container->register(MemberRenamer::class, function (Container $container) {
            return new MemberRenamer($container->get(DefinitionAndReferenceFinder::class), $container->get(TextDocumentLocator::class), $container->get(WorseReflectionExtension::SERVICE_PARSER), $container->get(IndexedImplementationFinder::class));
        }, [LanguageServerRenameExtension::TAG_RENAMER => []]);
        $container->register(ClassRenamer::class, function (Container $container) {
            return new ClassRenamer(new WorseNameToUriConverter($container->get(WorseReflectionExtension::SERVICE_REFLECTOR)), new ClassToFileNameToUriConverter($container->get(ClassToFileExtension::SERVICE_CONVERTER)), $container->get(DefinitionAndReferenceFinder::class), $container->get(TextDocumentLocator::class), $container->get('worse_reflection.tolerant_parser'), $container->get(ClassMover::class));
        }, [LanguageServerRenameExtension::TAG_RENAMER => []]);
        $container->register(DefinitionAndReferenceFinder::class, function (Container $container) {
            // wrap the definiton and reference finder to update the index with the current workspace
            return new WorkspaceUpdateReferenceFinder($container->get(LanguageServerExtension::SERVICE_SESSION_WORKSPACE), $container->get(Indexer::class), new DefinitionAndReferenceFinder($container->get(ReferenceFinderExtension::SERVICE_DEFINITION_LOCATOR), $container->get(ReferenceFinder::class)));
        });
        $container->register(FileRenamer::class, function (Container $container) {
            $renamer = new PhpactorFileRenamer(new ClassToFileUriToNameConverter($container->get(ClassToFileExtension::SERVICE_CONVERTER)), $container->get(TextDocumentLocator::class), $container->get(QueryClient::class), $container->get(ClassMover::class));
            return new LoggingFileRenamer($renamer, LoggingExtension::channelLogger($container, 'LSP-RENAME'));
        });
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerRename\\LanguageServerRenameWorseExtension', 'Phpactor\\Extension\\LanguageServerRename\\LanguageServerRenameWorseExtension', \false);
