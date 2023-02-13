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
namespace PhpactorDist\LibDNS\Decoder;

use PhpactorDist\LibDNS\Packets\PacketFactory;
use PhpactorDist\LibDNS\Messages\MessageFactory;
use PhpactorDist\LibDNS\Records\RecordCollectionFactory;
use PhpactorDist\LibDNS\Records\QuestionFactory;
use PhpactorDist\LibDNS\Records\ResourceBuilder;
use PhpactorDist\LibDNS\Records\ResourceFactory;
use PhpactorDist\LibDNS\Records\RDataBuilder;
use PhpactorDist\LibDNS\Records\RDataFactory;
use PhpactorDist\LibDNS\Records\Types\TypeBuilder;
use PhpactorDist\LibDNS\Records\Types\TypeFactory;
use PhpactorDist\LibDNS\Records\TypeDefinitions\TypeDefinitionManager;
use PhpactorDist\LibDNS\Records\TypeDefinitions\TypeDefinitionFactory;
use PhpactorDist\LibDNS\Records\TypeDefinitions\FieldDefinitionFactory;
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
