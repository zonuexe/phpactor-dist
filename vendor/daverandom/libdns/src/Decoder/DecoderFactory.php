<?php

declare (strict_types=1);
/**
 * Creates Decoder objects
 *
 * PHP version 5.4
 *
 * @category LibDNS
 * @package Decoder
 * @author Chris Wright <https://github.com/DaveRandom>
 * @copyright Copyright (c) Chris Wright <https://github.com/DaveRandom>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @version 2.0.0
 */
namespace Phpactor202301\LibDNS\Decoder;

use Phpactor202301\LibDNS\Packets\PacketFactory;
use Phpactor202301\LibDNS\Messages\MessageFactory;
use Phpactor202301\LibDNS\Records\RecordCollectionFactory;
use Phpactor202301\LibDNS\Records\QuestionFactory;
use Phpactor202301\LibDNS\Records\ResourceBuilder;
use Phpactor202301\LibDNS\Records\ResourceFactory;
use Phpactor202301\LibDNS\Records\RDataBuilder;
use Phpactor202301\LibDNS\Records\RDataFactory;
use Phpactor202301\LibDNS\Records\Types\TypeBuilder;
use Phpactor202301\LibDNS\Records\Types\TypeFactory;
use Phpactor202301\LibDNS\Records\TypeDefinitions\TypeDefinitionManager;
use Phpactor202301\LibDNS\Records\TypeDefinitions\TypeDefinitionFactory;
use Phpactor202301\LibDNS\Records\TypeDefinitions\FieldDefinitionFactory;
/**
 * Creates Decoder objects
 *
 * @category LibDNS
 * @package Decoder
 * @author Chris Wright <https://github.com/DaveRandom>
 */
class DecoderFactory
{
    /**
     * Create a new Decoder object
     *
     * @param \LibDNS\Records\TypeDefinitions\TypeDefinitionManager $typeDefinitionManager
     * @param bool $allowTrailingData
     * @return Decoder
     */
    public function create(TypeDefinitionManager $typeDefinitionManager = null, bool $allowTrailingData = \true) : Decoder
    {
        $typeBuilder = new TypeBuilder(new TypeFactory());
        return new Decoder(new PacketFactory(), new MessageFactory(new RecordCollectionFactory()), new QuestionFactory(), new ResourceBuilder(new ResourceFactory(), new RDataBuilder(new RDataFactory(), $typeBuilder), $typeDefinitionManager ?: new TypeDefinitionManager(new TypeDefinitionFactory(), new FieldDefinitionFactory())), $typeBuilder, new DecodingContextFactory(), $allowTrailingData);
    }
}
