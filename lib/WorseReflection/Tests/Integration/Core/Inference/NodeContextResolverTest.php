<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Core\Inference;

use Phpactor202301\Phpactor\WorseReflection\Bridge\Phpactor\DocblockParser\DocblockParserFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Cache\StaticCache;
use Phpactor202301\Phpactor\WorseReflection\Core\DefaultResolverFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\GenericMapResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeToTypeConverter;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\PropertyAssignments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver\MemberAccess\NodeContextFromMemberAccess;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\LocalAssignments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Variable;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use RuntimeException;
class NodeContextResolverTest extends IntegrationTestCase
{
    public function tearDown() : void
    {
        //var_dump($this->logger());
    }
    /**
     * @dataProvider provideGeneral
     */
    public function testGeneral(string $source, array $locals, array $expectedInformation) : void
    {
        $variables = [];
        $properties = [];
        $offset = 0;
        foreach ($locals as $name => $varSymbolInfo) {
            $offset++;
            if ($varSymbolInfo instanceof Type) {
                $varSymbolInfo = NodeContext::for(Symbol::fromTypeNameAndPosition('variable', $name, Position::fromStartAndEnd($offset, $offset)))->withType($varSymbolInfo);
            }
            $variable = Variable::fromSymbolContext($varSymbolInfo);
            if (Symbol::PROPERTY === $varSymbolInfo->symbol()->symbolType()) {
                $properties[$varSymbolInfo->symbol()->position()->start()] = $variable;
                continue;
            }
            $variables[$varSymbolInfo->symbol()->position()->start()] = $variable;
        }
        $symbolInfo = $this->resolveNodeAtOffset(LocalAssignments::fromArray($variables), PropertyAssignments::fromArray($properties), $source);
        $this->assertExpectedInformation($expectedInformation, $symbolInfo);
    }
    /**
     * @dataProvider provideValues
     */
    public function testValues(string $source, array $variables, array $expected) : void
    {
        $information = $this->resolveNodeAtOffset(LocalAssignments::fromArray($variables), PropertyAssignments::create(), $source);
        $this->assertExpectedInformation($expected, $information);
    }
    /**
     * These tests test the case where a class in the resolution tree was not found, however
     * their usefulness is limited because we use the StringSourceLocator for these tests which
     * "always" finds the source.
     *
     * @dataProvider provideNotResolvableClass
     */
    public function testNotResolvableClass(string $source) : void
    {
        $value = $this->resolveNodeAtOffset(LocalAssignments::fromArray([0 => Variable::fromSymbolContext(NodeContext::for(Symbol::fromTypeNameAndPosition(Symbol::CLASS_, 'bar', Position::fromStartAndEnd(0, 0)))->withType(TypeFactory::fromString('Foobar')))]), PropertyAssignments::create(), $source);
        $this->assertEquals(TypeFactory::unknown(), $value->type());
    }
    public function provideGeneral()
    {
        (yield 'It should return none value for whitespace' => ['  <>  ', [], ['type' => '<missing>']]);
        (yield 'It should return the name of a class' => [<<<'EOT'
<?php

namespace Phpactor202301;

$foo = new Cl() != assName();

EOT
, [], ['type' => 'ClassName', 'symbol_type' => Symbol::CLASS_]]);
        (yield 'It should return the fully qualified name of a class' => [<<<'EOT'
<?php

namespace Phpactor202301\Foobar\Barfoo;

$foo = new Cl() != assName();

EOT
, [], ['type' => 'Phpactor202301\\Foobar\\Barfoo\\ClassName']]);
        (yield 'It should return the fully qualified name of a with an imported name.' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

use BarBar\ClassName();

$foo = new Clas<>sName();

EOT
, [], ['type' => 'Phpactor202301\\BarBar\\ClassName', 'symbol_type' => Symbol::CLASS_, 'symbol_name' => 'ClassName']]);
        (yield 'It should return the fully qualified name of a use definition' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

use BarBar\Clas<>sName();

$foo = new ClassName();

EOT
, [], ['type' => 'Phpactor202301\\BarBar\\ClassName']]);
        (yield 'It returns the FQN of a method parameter with a default' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

class Foobar
{
    public function foobar(Barfoo $<>barfoo = 'test')
    {
    }
}

EOT
, [], ['type' => 'Phpactor202301\\Foobar\\Barfoo\\Barfoo', 'symbol_type' => Symbol::VARIABLE, 'symbol_name' => 'barfoo']]);
        (yield 'It returns the type and value of a scalar method parameter' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

class Foobar
{
    public function foobar(string $b<>arfoo = 'test')
    {
    }
}

EOT
, [], ['type' => 'string']]);
        (yield 'It returns the value of a method parameter with a constant' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

class Foobar
{
    public function foobar(string $ba<>rfoo = 'test')
    {
    }
}

EOT
, [], ['type' => 'string']]);
        (yield 'It returns the FQN of a method parameter in an interface' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

use Acme\Factory;

interface Foobar
{
    public function hello(World $wor<>ld);
}

EOT
, [], ['type' => 'Phpactor202301\\Foobar\\Barfoo\\World']]);
        (yield 'It returns the FQN of a method parameter in a trait' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

use Acme\Factory;

trait Foobar
{
    public function hello(<>World $world)
    {
    }
}

EOT
, [], ['type' => 'Phpactor202301\\Foobar\\Barfoo\\World', 'symbol_type' => Symbol::CLASS_, 'symbol_name' => 'World']]);
        (yield 'It returns the value of a method parameter' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

class Foobar
{
    public function foobar(string $<>barfoo = 'test')
    {
    }
}

EOT
, [], ['type' => 'string']]);
        (yield 'Ignores parameter on anonymous class' => [<<<'EOT'
<?php

class Foobar {

    public function foobar()
    {
        $class = new class { public function __invoke($foo<>bar) {} };
    }
}

EOT
, [], ['type' => '<missing>', 'symbol_type' => '<unknown>', 'symbol_name' => 'Parameter']]);
        (yield 'It returns the FQN of a static call' => [<<<'EOT'
<?php

namespace Phpactor202301\Foobar\Barfoo;

use Phpactor202301\Acme\Factory;
$foo = Fac != tory::create();

EOT
, [], ['type' => 'Phpactor202301\\Acme\\Factory', 'symbol_type' => Symbol::CLASS_]]);
        (yield 'It returns the FQN of a method parameter' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

use Acme\Factory;

class Foobar
{
    public function hello(W<>orld $world)
    {
    }
}

EOT
, [], ['type' => 'Phpactor202301\\Foobar\\Barfoo\\World']]);
        (yield 'It resolves a anonymous function use' => [<<<'EOT'
<?php

function ($blah) use ($f<>oo) {

}

EOT
, ['foo' => TypeFactory::fromString('string')], ['type' => 'string', 'symbol_type' => Symbol::VARIABLE, 'symbol_name' => 'foo']]);
        (yield 'It resolves an undeclared variable' => [<<<'EOT'
<?php

namespace Phpactor202301;

$b != \lah;

EOT
, [], ['type' => '<missing>', 'symbol_type' => Symbol::VARIABLE, 'symbol_name' => 'blah']]);
        (yield 'It returns the FQN of variable assigned in frame' => [<<<'EOT'
<?php

namespace Phpactor202301\Foobar\Barfoo;

use Phpactor202301\Acme\Factory;
class Foobar
{
    public function hello(World $world)
    {
        echo $w != orld;
    }
}

EOT
, ['world' => TypeFactory::fromString('World')], ['type' => 'World', 'symbol_type' => Symbol::VARIABLE, 'symbol_name' => 'world']]);
        (yield 'It returns type for a call access expression' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

class Type3
{
    public function foobar(): Foobar
    {
    }
    }

class Type2
{
    public function type3(): Type3
    {
    }
}

class Type1
{
    public function type2(): Type2
    {
    }
}

class Foobar
{
    /**
     * @var Type1
     */
    private $foobar;

    public function hello(Barfoo $world)
    {
        $this->foobar->type2()->type3(<>);
    }
}
EOT
, ['this' => TypeFactory::fromString('Phpactor202301\\Foobar\\Barfoo\\Foobar')], ['type' => 'Phpactor202301\\Foobar\\Barfoo\\Type3', 'symbol_type' => Symbol::METHOD, 'symbol_name' => 'type3', 'container_type' => 'Phpactor202301\\Foobar\\Barfoo\\Type2']]);
        (yield 'It returns type for a method which returns an interface type' => [<<<'EOT'
<?php

interface Barfoo
{
    public function foo(): string;
}

class Foobar
{
    public function hello(): Barfoo
    {
    }

    public function goodbye()
    {
        $this->hello()->foo(<>);
    }
}
EOT
, ['this' => TypeFactory::fromString('Foobar')], ['type' => 'string', 'symbol_type' => Symbol::METHOD, 'symbol_name' => 'foo', 'container_type' => 'Barfoo']]);
        (yield 'It returns class type for parent class for parent method' => [<<<'EOT'
<?php

class Type3 {}

class Barfoo
{
    public function type3(): Type3
    {
    }
}

class Foobar extends Barfoo
{
    /**
     * @var Type1
     */
    private $foobar;

    public function hello(Barfoo $world)
    {
        $this->type3(<>);
    }
}
EOT
, ['this' => TypeFactory::fromString('Foobar')], ['type' => 'Type3', 'symbol_type' => Symbol::METHOD, 'symbol_name' => 'type3', 'container_type' => 'Foobar']]);
        (yield 'It returns type for a property access when class has method of same name' => [<<<'EOT'
<?php

class Type1
{
    public function asString(): string
    {
    }
}

class Foobar
{
    /**
     * @var Type1
     */
    private $foobar;

    private function foobar(): Hello
    {
    }

    public function hello()
    {
        $this->foobar->asString(<>);
    }
}
EOT
, ['this' => TypeFactory::fromString('Foobar')], ['type' => 'string']]);
        (yield 'It returns type for a new instantiation' => [<<<'EOT'
<?php

new <>Bar();
EOT
, [], ['type' => 'Bar']]);
        (yield 'It returns type for a new instantiation from a variable' => [<<<'EOT'
<?php

new $<>foobar;
EOT
, ['foobar' => TypeFactory::fromString('Foobar')], ['type' => 'Foobar']]);
        (yield 'It returns type for string literal' => [<<<'EOT'
<?php

namespace Phpactor202301;

'bar<>';
EOT
, [], ['type' => '"bar"', 'symbol_type' => Symbol::STRING]]);
        (yield 'It returns type for float' => [<<<'EOT'
<?php

namespace Phpactor202301;

1.0 != 2;
EOT
, [], ['type' => '1.2', 'symbol_type' => Symbol::NUMBER]]);
        (yield 'It returns type for integer' => [<<<'EOT'
<?php

12<>;
EOT
, [], ['type' => '12', 'symbol_type' => Symbol::NUMBER]]);
        (yield 'It returns type for octal integer' => [<<<'EOT'
<?php

012<>;
EOT
, [], ['type' => '012', 'symbol_type' => Symbol::NUMBER]]);
        (yield 'It returns type for hexadecimal integer' => [<<<'EOT'
<?php

0x1A<>;
EOT
, [], ['type' => '0x1A', 'symbol_type' => Symbol::NUMBER]]);
        (yield 'It returns type for binary integer' => [<<<'EOT'
<?php

0b11<>;
EOT
, [], ['type' => '0b11', 'symbol_type' => Symbol::NUMBER]]);
        (yield 'It returns type for bool true' => [<<<'EOT'
<?php

namespace Phpactor202301;

\tr != \ue;
EOT
, [], ['type' => 'true', 'symbol_type' => Symbol::BOOLEAN]]);
        (yield 'It returns type for bool false' => [<<<'EOT'
<?php

<>false;
EOT
, [], ['type' => 'false', 'symbol_type' => Symbol::BOOLEAN]]);
        (yield 'It returns type null' => [<<<'EOT'
<?php

namespace Phpactor202301;

\n != \ull;
EOT
, [], ['type' => 'null']]);
        (yield 'It returns type null case insensitive' => [<<<'EOT'
<?php

namespace Phpactor202301;

\N != \ULL;
EOT
, [], ['type' => 'null']]);
        (yield 'It returns type and value for an array' => [<<<'EOT'
<?php

[ 'one' => 'two', 'three' => 3 <>];
EOT
, [], ['type' => 'array{one:"two",three:3}']]);
        (yield 'Empty array' => [<<<'EOT'
<?php

[  <>];
EOT
, [], ['type' => 'array{}']]);
        (yield 'It type for a class constant' => [<<<'EOT'
<?php

namespace Phpactor202301;

$foo = Foobar::HELL != \O;
class Foobar
{
    const HELLO = 'string';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, [], ['type' => '"string"']]);
        (yield 'Static method access' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public static function foobar() : Hello
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
Foobar::fooba != r();
class Hello
{
}
\class_alias('Phpactor202301\\Hello', 'Hello', \false);
EOT
, [], ['type' => 'Hello']]);
        (yield 'Static constant access' => [<<<'EOT'
<?php

namespace Phpactor202301;

Foobar::HELLO_ != \CONSTANT;
class Foobar
{
    const HELLO_CONSTANT = 'hello';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, [], ['type' => '"hello"']]);
        (yield 'Static property access' => [<<<'EOT'
<?php

namespace Phpactor202301;

Foobar::$my != \Property;
class Foobar
{
    /** @var string */
    public static $myProperty = 'hello';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, [], ['type' => 'string', 'symbol_type' => Symbol::PROPERTY, 'symbol_name' => 'myProperty', 'container_type' => 'Foobar']]);
        (yield 'Static property access 2' => [<<<'EOT'
<?php

class Foobar
{
    /** @var string */
    public static $myProperty = 'hello';

    function m() {
        self::$my<>Property = 5;
    }
}
EOT
, [], ['type' => 'string', 'symbol_type' => Symbol::PROPERTY, 'symbol_name' => 'myProperty', 'container_type' => 'Foobar']]);
        (yield 'Static property access instance)' => [<<<'EOT'
<?php

class Foobar
{
/** @var string */
public static $myProperty = 'hello';
}

$foobar = new Foobar();
$foobar::$my<>Property = 5;
EOT
, ['foobar' => TypeFactory::fromString('Foobar')], ['type' => 'string', 'symbol_type' => Symbol::PROPERTY, 'symbol_name' => 'myProperty', 'container_type' => 'Foobar']]);
        (yield 'Member access with variable' => [<<<'EOT'
<?php

$foobar = new Foobar();
$foobar->$barfoo(<>);

class Foobar
{
}
EOT
, [], ['type' => '<missing>']]);
        (yield 'Member access with valued variable' => [<<<'EOT'
<?php

class Foobar
{
    public function hello(): string {}
}

$foobar->$barfoo(<>);
EOT
, ['foobar' => TypeFactory::fromString('Foobar'), 'barfoo' => NodeContext::for(Symbol::fromTypeNameAndPosition(Symbol::STRING, 'barfoo', Position::fromStartAndEnd(0, 0)))->withType(TypeFactory::stringLiteral('hello'))], ['type' => 'string']]);
        (yield 'It returns type of property' => [<<<'EOT'
<?php

class Foobar
{
    /**
     * @var stdClass
     */
    private $std<>Class;
}
EOT
, [], ['type' => 'stdClass', 'symbol_name' => 'stdClass']]);
        (yield 'It returns type for parenthesised new object' => [<<<'EOT'
<?php

(new stdClass())<>;
EOT
, [], ['type' => 'stdClass', 'symbol_name' => 'stdClass']]);
        (yield 'It resolves a clone expression' => [<<<'EOT'
<?php

(clone new stdClass())<>;
EOT
, [], ['type' => 'stdClass', 'symbol_name' => 'stdClass']]);
        (yield 'It returns the FQN of variable assigned in frame 2' => [<<<'EOT'
<?php

namespace Foobar\Barfoo;

use Acme\Factory;
use Acme\FactoryInterface;

class Foobar
{
    /**
     * @var FactoryInterface
     */
    private $bar;

    public function hello(World $world)
    {
        assert($this->bar instanceof Factory);

        $this->ba<>r
    }
}

EOT
, ['this' => TypeFactory::class('Phpactor202301\\Foobar\\Barfoo\\Foobar'), 'bar' => NodeContext::for(Symbol::fromTypeNameAndPosition(Symbol::PROPERTY, 'bar', Position::fromStartAndEnd(0, 0)))->withContainerType(TypeFactory::class('Phpactor202301\\Foobar\\Barfoo\\Foobar'))->withType(TypeFactory::class('Phpactor202301\\Acme\\Factory'))], ['types' => [TypeFactory::class('Phpactor202301\\Acme\\Factory')], 'symbol_type' => Symbol::PROPERTY, 'symbol_name' => 'bar']]);
    }
    public function provideValues()
    {
        (yield 'It returns type for self' => [<<<'EOT'
<?php

class Foobar
{
    public function foobar(Barfoo $barfoo = 'test')
    {
        sel<>f::
    }
}
EOT
, [], ['type' => 'Foobar']]);
        (yield 'It returns type for static' => [<<<'EOT'
<?php

class Foobar
{
    public function foobar(Barfoo $barfoo = 'test')
    {
        stat<>ic::
    }
}
EOT
, [], ['type' => 'Foobar']]);
        (yield 'It returns type for parent' => [<<<'EOT'
<?php

class ParentClass {}

class Foobar extends ParentClass
{
    public function foobar(Barfoo $barfoo = 'test')
    {
        pare<>nt::
    }
}
EOT
, [], ['type' => 'ParentClass']]);
        (yield 'It assumes true for ternary expressions' => [<<<'EOT'
<?php

$barfoo ? <>'foobar' : 'barfoo';
EOT
, [], ['type' => '"foobar"']]);
        (yield 'It uses condition value if ternery "if" is empty' => [<<<'EOT'
<?php

'string' ?:<> new \stdClass();
EOT
, [], ['type' => '"string"']]);
        (yield 'It shows the symbol name for a method declartion' => [<<<'EOT'
<?php

class Foobar
{
    public function me<>thod()
    {
    }
}
EOT
, [], ['symbol_type' => Symbol::METHOD, 'symbol_name' => 'method', 'container_type' => 'Foobar']]);
        (yield 'Class name' => [<<<'EOT'
<?php

class Fo<>obar
{
}
EOT
, [], ['type' => 'Foobar', 'symbol_type' => Symbol::CLASS_, 'symbol_name' => 'Foobar']]);
        (yield 'Property name' => [<<<'EOT'
<?php

class Foobar
{
    private $a<>aa = 'asd';
}
EOT
, [], ['type' => '<missing>', 'symbol_type' => Symbol::PROPERTY, 'symbol_name' => 'aaa', 'container_type' => 'Foobar']]);
        (yield 'Constant name' => [<<<'EOT'
<?php

class Foobar
{
    const AA<>A = 'aaa';
}
EOT
, [], ['type' => '<missing>', 'symbol_type' => Symbol::CONSTANT, 'symbol_name' => 'AAA', 'container_type' => 'Foobar']]);
        // 8.1 only
        if (\defined('T_ENUM')) {
            (yield 'Enum case name' => [<<<'EOT'
<?php

enum Foobar
{
    case AA<>A = 'aaa';
}
EOT
, [], ['type' => '<missing>', 'symbol_type' => Symbol::CASE, 'symbol_name' => 'AAA', 'container_type' => 'Foobar']]);
        }
        (yield 'Function name' => [<<<'EOT'
<?php

function f<>oobar()
{
}
EOT
, [], ['symbol_type' => Symbol::FUNCTION, 'symbol_name' => 'foobar']]);
        (yield 'Function call' => [<<<'EOT'
<?php

function hello(): string;

hel<>lo();
EOT
, [], ['type' => 'string', 'symbol_type' => Symbol::FUNCTION, 'symbol_name' => 'hello']]);
        (yield 'Trait name' => [<<<'EOT'
<?php

trait Bar<>bar
{
}
EOT
, [], ['symbol_type' => 'class', 'symbol_name' => 'Barbar', 'type' => 'Barbar']]);
    }
    public function provideNotResolvableClass()
    {
        (yield 'Calling property method for non-existing class' => [<<<'EOT'
<?php

class Foobar
{
    /**
     * @var NonExisting
     */
    private $hello;

    public function hello()
    {
        $this->hello->foobar(<>);
    }
}
EOT
]);
        (yield 'Class extends non-existing class' => [<<<'EOT'
<?php

class Foobar extends NonExisting
{
    public function hello()
    {
        $hello = $this->foobar(<>);
    }
}
EOT
]);
        (yield 'Method returns non-existing class' => [<<<'EOT'
<?php

class Foobar
{
    private function hai(): Hai
    {
    }

    public function hello()
    {
        $this->hai()->foo(<>);
    }
}
EOT
]);
        (yield 'Method returns class which extends non-existing class' => [<<<'EOT'
<?php

class Foobar
{
    private function hai(): Hai
    {
    }

    public function hello()
    {
        $this->hai()->foo(<>);
    }
}

class Hai extends NonExisting
{
}
EOT
]);
        (yield 'Static method returns non-existing class' => [<<<'EOT'
<?php

ArrGoo::hai()->foo(<>);

class Foobar
{
    public static function hai(): Foo
    {
    }
}
EOT
]);
    }
    public function testAttachesScope() : void
    {
        $source = <<<'EOT'
<?php

namespace Phpactor202301\Hello;

use Phpactor202301\Goodbye;
use Phpactor202301\Adios;
new Foob() != o;
EOT;
        $context = $this->resolveNodeAtOffset(LocalAssignments::create(), PropertyAssignments::create(), $source);
        $this->assertCount(2, $context->scope()->nameImports());
    }
    private function resolveNodeAtOffset(LocalAssignments $locals, PropertyAssignments $properties, string $source) : NodeContext
    {
        $frame = new Frame('test', $locals, $properties);
        [$source, $offset] = ExtractOffset::fromSource($source);
        $node = $this->parseSource($source)->getDescendantNodeAtPosition($offset);
        $reflector = $this->createReflector($source);
        $nameResolver = new NodeToTypeConverter($reflector, $this->logger());
        $resolver = new NodeContextResolver($reflector, new DocblockParserFactory($reflector), $this->logger(), new StaticCache(), (new DefaultResolverFactory($reflector, $nameResolver, new GenericMapResolver($reflector), new NodeContextFromMemberAccess(new GenericMapResolver($reflector), [])))->createResolvers());
        return $resolver->resolveNode($frame, $node);
    }
    private function assertExpectedInformation(array $expectedInformation, NodeContext $information) : void
    {
        foreach ($expectedInformation as $name => $value) {
            switch ($name) {
                case 'type':
                    $this->assertEquals($value, (string) $information->type(), $name);
                    continue 2;
                case 'types':
                    $this->assertEquals(Type::fromTypes(...$value)->__toString(), $information->type()->__toString(), $name);
                    continue 2;
                case 'symbol_type':
                    $this->assertEquals($value, $information->symbol()->symbolType(), $name);
                    continue 2;
                case 'symbol_name':
                    $this->assertEquals($value, $information->symbol()->name(), $name);
                    continue 2;
                case 'container_type':
                    $this->assertEquals($value, (string) $information->containerType(), $name);
                    continue 2;
                case 'log':
                    $this->assertStringContainsString($value, \implode(' ', $this->logger->messages()), $name);
                    continue 2;
                default:
                    throw new RuntimeException(\sprintf('Do not know how to test symbol information attribute "%s"', $name));
            }
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Core\\Inference\\NodeContextResolverTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Core\\Inference\\NodeContextResolverTest', \false);