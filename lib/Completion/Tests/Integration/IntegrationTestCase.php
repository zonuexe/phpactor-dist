<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration;

use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\ClassFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\ConstantFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\EnumCaseFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\FunctionFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\InterfaceFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\MethodFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\ParameterFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\ParametersFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\PropertyFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\TraitFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\TypeFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\VariableFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\SnippetFormatter\FunctionLikeSnippetFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\SnippetFormatter\NameSearchResultClassSnippetFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\SnippetFormatter\NameSearchResultFunctionSnippetFormatter;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\SnippetFormatter\ParametersSnippetFormatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\Completion\Tests\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class IntegrationTestCase extends TestCase
{
    protected function formatter() : ObjectFormatter
    {
        return new ObjectFormatter([new TypeFormatter(), new FunctionFormatter(), new MethodFormatter(), new ParameterFormatter(), new ParametersFormatter(), new PropertyFormatter(), new VariableFormatter(), new InterfaceFormatter(), new ClassFormatter(), new TraitFormatter(), new ConstantFormatter(), new EnumCaseFormatter()]);
    }
    protected function snippetFormatter(Reflector $reflector) : ObjectFormatter
    {
        return new ObjectFormatter([new ParametersSnippetFormatter(), new FunctionLikeSnippetFormatter(), new NameSearchResultClassSnippetFormatter($reflector), new NameSearchResultFunctionSnippetFormatter($reflector)]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\IntegrationTestCase', 'Phpactor\\Completion\\Tests\\Integration\\IntegrationTestCase', \false);
