<?php

declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

// You can do your own things here, e.g. collecting symbols to expose dynamically
// or files to exclude.
// However beware that this file is executed by PHP-Scoper, hence if you are using
// the PHAR it will be loaded by the PHAR. So it is highly recommended to avoid
// to auto-load any code here: it can result in a conflict or even corrupt
// the PHP-Scoper analysis.

// Example of collecting files to include in the scoped build but to not scope
// leveraging the isolated finder.
$excludedFiles = array_map(
    static fn (SplFileInfo $fileInfo) => $fileInfo->getPathName(),
    [
        ...iterator_to_array(
            Finder::create()->files()
                ->notName('/.*\\.md|.*\\.dist|.*\\.neon|.*\\.sh|.*Test\\.php|Makefile|composer\\.json|composer\\.lock/')
                ->in([
                    __DIR__ . '/lib/WorseReflection/Core/SourceCodeLocator/InternalStubs',
                    __DIR__ . '/vendor/jetbrains/phpstorm-stubs',
                    __DIR__ . '/vendor/thecodingmachine/safe',
                ]), false),
    ]
);

$autoloaderReal = realpath(__DIR__ . '/vendor/composer/autoload_real.php');
assert($autoloaderReal !== false);

return [
    'prefix' => $ns = 'Phpactor' . gmdate('Ym'),

    // The base output directory for the prefixed files.
    // This will be overridden by the 'output-dir' command line option if present.
    'output-dir' => 'dist',

    // By default when running php-scoper add-prefix, it will prefix all relevant code found in the current working
    // directory. You can however define which files should be scoped by defining a collection of Finders in the
    // following configuration key.
    //
    // This configuration entry is completely ignored when using Box.
    //
    // For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#finders-and-paths
    'finders' => [
        Finder::create()->files()->in('autoload'),
        Finder::create()->files()->in('bin'),
        Finder::create()->files()->in('ftplugin'),
        Finder::create()->files()->in('lib')->exclude('Tests'),
        Finder::create()->files()->in('plugin'),
        Finder::create()->files()->in('templates'),
        Finder::create()
            ->files()
            ->ignoreVCS(true)
            ->notName('/.*\\.md|.*\\.dist|.*\\.neon|.*\\.sh|Makefile|composer\\.json|composer\\.lock/')
            ->exclude([
                'build',
                'build-dist',
                'dist',
                'doc',
                'tests',
            ])
            ->notpath('/\\/Tests\\//')
            ->in('vendor'),
        Finder::create()->append([
            'LICENSE',
            'CHANGELOG.md',
        ]),
    ],

    // List of excluded files, i.e. files for which the content will be left untouched.
    // Paths are relative to the configuration file unless if they are already absolute
    //
    // For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#patchers
    'exclude-files' => [
        // 'src/an-excluded-file.php',
        ...$excludedFiles,
    ],

    // When scoping PHP files, there will be scenarios where some of the code being scoped indirectly references the
    // original namespace. These will include, for example, strings or string manipulations. PHP-Scoper has limited
    // support for prefixing such strings. To circumvent that, you can define patchers to manipulate the file to your
    // heart contents.
    //
    // For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#patchers
    'patchers' => [
        static function (string $filePath, string $prefix, string $contents) use ($ns, $autoloaderReal) : string {
            if ($filePath === $autoloaderReal) {
                $contents = str_replace(
                    "'Composer\\\\Autoload\\\\ClassLoader'",
                    "'{$ns}\\\\Composer\\\\Autoload\\\\ClassLoader'",
                    $contents
                );
            }

            return $contents;
        },
    ],

    // List of symbols to consider internal i.e. to leave untouched.
    //
    // For more information see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#excluded-symbols
    'exclude-namespaces' => [
        // 'Acme\Foo'                     // The Acme\Foo namespace (and sub-namespaces)
        // '~^PHPUnit\\\\Framework$~',    // The whole namespace PHPUnit\Framework (but not sub-namespaces)
        // '~^$~',                        // The root namespace only
        // '',                            // Any namespace
        'Phpactor',
        'Safe',
    ],
    'exclude-classes' => [
        // 'ReflectionClassConstant',
    ],
    'exclude-functions' => [
        'assert',
        // 'mb_str_split',
    ],
    'exclude-constants' => [
        // 'STDIN',
    ],

    // List of symbols to expose.
    //
    // For more information see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#exposed-symbols
    'expose-global-constants' => true,
    'expose-global-classes' => true,
    'expose-global-functions' => false,
    'expose-namespaces' => [
        // 'Acme\Foo'                     // The Acme\Foo namespace (and sub-namespaces)
        // '~^PHPUnit\\\\Framework$~',    // The whole namespace PHPUnit\Framework (but not sub-namespaces)
        // '~^$~',                        // The root namespace only
        // '',                            // Any namespace
    ],
    'expose-classes' => [],
    'expose-functions' => [],
    'expose-constants' => [],
];
