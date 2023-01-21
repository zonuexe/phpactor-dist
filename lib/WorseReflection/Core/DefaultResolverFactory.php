<?php

namespace Phpactor\WorseReflection\Core;

use Phpactor202301\Microsoft\PhpParser\Node\CatchClause;
use Phpactor202301\Microsoft\PhpParser\Node\ConstElement;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Phpactor202301\Microsoft\PhpParser\Node\EnumCaseDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\AnonymousFunctionCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ArgumentExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ArrayCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ArrowFunctionCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\BinaryExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CastExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CloneExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ParenthesizedExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\PostfixUpdateExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\SubscriptExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\TernaryExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\UnaryOpExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\YieldExpression;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\NumericLiteral;
use Phpactor202301\Microsoft\PhpParser\Node\Parameter;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\ReservedWord;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\CompoundStatementNode;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\EnumDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ExpressionStatement;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ForeachStatement;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\FunctionDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\IfStatementNode;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\StringLiteral;
use Phpactor202301\Microsoft\PhpParser\Node\UseVariableName;
use Phpactor\WorseReflection\Core\Inference\FunctionStubRegistry;
use Phpactor\WorseReflection\Core\Inference\FunctionStub\ArrayMapStub;
use Phpactor\WorseReflection\Core\Inference\FunctionStub\ArrayMergeStub;
use Phpactor\WorseReflection\Core\Inference\FunctionStub\ArrayPopStub;
use Phpactor\WorseReflection\Core\Inference\FunctionStub\ArrayShiftStub;
use Phpactor\WorseReflection\Core\Inference\FunctionStub\ArraySumStub;
use Phpactor\WorseReflection\Core\Inference\FunctionStub\AssertStub;
use Phpactor\WorseReflection\Core\Inference\FunctionStub\InArrayStub;
use Phpactor\WorseReflection\Core\Inference\FunctionStub\IsSomethingStub;
use Phpactor\WorseReflection\Core\Inference\FunctionStub\IteratorToArrayStub;
use Phpactor\WorseReflection\Core\Inference\FunctionStub\ResetStub;
use Phpactor\WorseReflection\Core\Inference\GenericMapResolver;
use Phpactor\WorseReflection\Core\Inference\NodeToTypeConverter;
use Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\AnonymousFunctionCreationExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ArgumentExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ArrayCreationExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ArrowFunctionCreationExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\AssignmentExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\CallExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\CastExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\CatchClauseResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ClassLikeResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\CloneExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\CompoundStatementResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ConstElementResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\EnumCaseDeclarationResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ExpressionStatementResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ForeachStatementResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\IfStatementResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\MemberAccessExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\MemberAccess\NodeContextFromMemberAccess;
use Phpactor\WorseReflection\Core\Inference\Resolver\MethodDeclarationResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\NumericLiteralResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ObjectCreationExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ParameterResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ParenthesizedExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\PostfixUpdateExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ReservedWordResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ReturnStatementResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\ScopedPropertyAccessResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\SourceFileNodeResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\StringLiteralResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\SubscriptExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\TernaryExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\UnaryOpExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\UseVariableNameResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\QualifiedNameResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\QualifiedNameListResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\VariableResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\BinaryExpressionResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\FunctionDeclarationResolver;
use Phpactor\WorseReflection\Core\Inference\Resolver\YieldExpressionResolver;
use Phpactor\WorseReflection\Reflector;
final class DefaultResolverFactory
{
    private FunctionStubRegistry $functionStubRegistry;
    public function __construct(private Reflector $reflector, private NodeToTypeConverter $nodeTypeConverter, private GenericMapResolver $genericResolver, private NodeContextFromMemberAccess $nodeContextFromMemberAccess)
    {
        $this->functionStubRegistry = $this->createStubRegistry();
    }
    /**
     * @return array<class-string,Resolver>
     */
    public function createResolvers() : array
    {
        return [QualifiedName::class => new QualifiedNameResolver($this->reflector, $this->functionStubRegistry, $this->nodeTypeConverter), QualifiedNameList::class => new QualifiedNameListResolver(), ConstElement::class => new ConstElementResolver(), EnumCaseDeclaration::class => new EnumCaseDeclarationResolver(), Parameter::class => new ParameterResolver(), UseVariableName::class => new UseVariableNameResolver(), Variable::class => new VariableResolver(), MemberAccessExpression::class => new MemberAccessExpressionResolver($this->nodeContextFromMemberAccess), ScopedPropertyAccessExpression::class => new ScopedPropertyAccessResolver($this->nodeTypeConverter, $this->nodeContextFromMemberAccess), CallExpression::class => new CallExpressionResolver(), ParenthesizedExpression::class => new ParenthesizedExpressionResolver(), BinaryExpression::class => new BinaryExpressionResolver(), UnaryOpExpression::class => new UnaryOpExpressionResolver(), ClassDeclaration::class => new ClassLikeResolver(), InterfaceDeclaration::class => new ClassLikeResolver(), TraitDeclaration::class => new ClassLikeResolver(), EnumDeclaration::class => new ClassLikeResolver(), FunctionDeclaration::class => new FunctionDeclarationResolver(), ObjectCreationExpression::class => new ObjectCreationExpressionResolver($this->genericResolver), SubscriptExpression::class => new SubscriptExpressionResolver(), StringLiteral::class => new StringLiteralResolver(), NumericLiteral::class => new NumericLiteralResolver(), ReservedWord::class => new ReservedWordResolver(), ArrayCreationExpression::class => new ArrayCreationExpressionResolver(), ArgumentExpression::class => new ArgumentExpressionResolver(), TernaryExpression::class => new TernaryExpressionResolver(), MethodDeclaration::class => new MethodDeclarationResolver(), CloneExpression::class => new CloneExpressionResolver(), AssignmentExpression::class => new AssignmentExpressionResolver(), CastExpression::class => new CastExpressionResolver(), ArrowFunctionCreationExpression::class => new ArrowFunctionCreationExpressionResolver(), AnonymousFunctionCreationExpression::class => new AnonymousFunctionCreationExpressionResolver(), CatchClause::class => new CatchClauseResolver(), ForeachStatement::class => new ForeachStatementResolver(), IfStatementNode::class => new IfStatementResolver(), CompoundStatementNode::class => new CompoundStatementResolver(), ExpressionStatement::class => new ExpressionStatementResolver(), SourceFileNode::class => new SourceFileNodeResolver(), ReturnStatement::class => new ReturnStatementResolver(), YieldExpression::class => new YieldExpressionResolver(), PostfixUpdateExpression::class => new PostfixUpdateExpressionResolver()];
    }
    private function createStubRegistry() : FunctionStubRegistry
    {
        return new FunctionStubRegistry(['array_sum' => new ArraySumStub(), 'in_array' => new InArrayStub(), 'iterator_to_array' => new IteratorToArrayStub(), 'is_null' => new IsSomethingStub(\Phpactor\WorseReflection\Core\TypeFactory::null()), 'is_float' => new IsSomethingStub(\Phpactor\WorseReflection\Core\TypeFactory::float()), 'is_int' => new IsSomethingStub(\Phpactor\WorseReflection\Core\TypeFactory::int()), 'is_string' => new IsSomethingStub(\Phpactor\WorseReflection\Core\TypeFactory::string()), 'is_callable' => new IsSomethingStub(\Phpactor\WorseReflection\Core\TypeFactory::callable()), 'array_map' => new ArrayMapStub(), 'reset' => new ResetStub(), 'array_shift' => new ArrayShiftStub(), 'array_pop' => new ArrayPopStub(), 'array_merge' => new ArrayMergeStub(), 'assert' => new AssertStub()]);
    }
}
