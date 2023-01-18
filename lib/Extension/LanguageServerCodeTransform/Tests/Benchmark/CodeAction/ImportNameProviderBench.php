<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Benchmark\CodeAction;

use Phpactor202301\Amp\CancellationTokenSource;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction\ImportNameProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
/**
 * @Iterations(10)
 * @OutputTimeUnit("milliseconds")
 */
class ImportNameProviderBench extends IntegrationTestCase
{
    private LanguageServerTester $tester;
    private ImportNameProvider $provider;
    public function setUp() : void
    {
        $this->workspace()->reset();
        $this->workspace()->loadManifest(<<<'EOT'
// File: Barfoo.php
<?php
class Barfoo
{
}
// File: subject.php
<?php
;
bin2hex;
gmdate;
json_decode;
json_last_error_msg;
random_bytes;
sha1;
sprintf;

class Barbar
{
    public function bar()
    {
        base64_encode();
        json_decode();
        gmdate();
        json_last_error_msg();
        random_bytes();
        sha1();
        sprintf();
        base64_encode();
        json_decode();
        gmdate();
        json_last_error_msg();
        random_bytes();
        sha1();
        sprintf();
    }
    public function doSomething(): Barfoo
    {
        return array_map(function (string $string) {
            return sprintf('%s string', $string);
        }, explode(",", "foo,bar,baz"));
    }

    public function doSomethingElse(): Barfoo
    {
        return array_map(function (string $string) {
            return sprintf('%s string', $string);
        }, explode(",", "foo,bar,baz"));
    }

    public function doSomethingWorse(): Barfoo
    {
        return array_map(function (string $string) {
            return sprintf('%s string', $string);
        }, explode(",", "foo,bar,baz"));
    }
}
EOT
);
        $this->provider = $this->container()->get(ImportNameProvider::class);
    }
    /**
     * @BeforeMethods({"setUp"})
     */
    public function benchDiagnostics() : void
    {
        $subject = $this->workspace()->getContents('subject.php');
        [$source, $offset] = ExtractOffset::fromSource($subject);
        $cancel = (new CancellationTokenSource())->getToken();
        $this->provider->provideDiagnostics(ProtocolFactory::textDocumentItem('file:///foobar', $subject), $cancel);
    }
    /**
     * @BeforeMethods({"setUp"})
     */
    public function benchCodeActions() : void
    {
        $subject = $this->workspace()->getContents('subject.php');
        [$source, $offset] = ExtractOffset::fromSource($subject);
        $cancel = (new CancellationTokenSource())->getToken();
        $this->provider->provideActionsFor(ProtocolFactory::textDocumentItem('file:///foobar', $subject), ProtocolFactory::range(0, 0, 0, 0), $cancel);
    }
}
/**
 * @Iterations(10)
 * @OutputTimeUnit("milliseconds")
 */
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Benchmark\\CodeAction\\ImportNameProviderBench', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Benchmark\\CodeAction\\ImportNameProviderBench', \false);
