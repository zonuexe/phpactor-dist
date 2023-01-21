<?php

declare (strict_types=1);
/**
 * Creates ResourceBuilder objects
 *
 * PHP version 5.4
 *
 * @category LibDNS
 * @package Records
 * @author Chris Wright <https://github.com/DaveRandom>
 * @copyright Copyright (c) Chris Wright <https://github.com/DaveRandom>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @version 2.0.0
 */
namespace Phpactor202301\LibDNS\Records;

use Phpactor202301\LibDNS\Records\Types\TypeBuilder;
use Phpactor202301\LibDNS\Records\Types\TypeFactory;
use Phpactor202301\LibDNS\Records\TypeDefinitions\TypeDefinitionManager;
use Phpactor202301\LibDNS\Records\TypeDefinitions\TypeDefinitionFactory;
use Phpactor202301\LibDNS\Records\TypeDefinitions\FieldDefinitionFactory;
/**
 * Creates ResourceBuilder objects
 *
 * @category LibDNS
 * @package Records
 * @author Chris Wright <https://github.com/DaveRandom>
 */
class ResourceBuilderFactory
{
    /**
     * Create a new ResourceBuilder object
     *
     * @param \LibDNS\Records\TypeDefinitions\TypeDefinitionManager $typeDefinitionManager
     * @return \LibDNS\Records\ResourceBuilder
     */
    public function create(TypeDefinitionManager $typeDefinitionManager = null) : ResourceBuilder
    {
        return new ResourceBuilder(new ResourceFactory(), new RDataBuilder(new RDataFactory(), new TypeBuilder(new TypeFactory())), $typeDefinitionManager ?: new TypeDefinitionManager(new TypeDefinitionFactory(), new FieldDefinitionFactory()));
    }
}
