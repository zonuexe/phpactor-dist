<?php

namespace PhpactorDist;

/**
 * This file was automatically generated by autoload_generator.php
 *
 * Do not edit this file directly
 */
\spl_autoload_register(function ($className) {
    static $classMap;
    if (!isset($classMap)) {
        $classMap = ['PhpactorDist\\libdns\\decoder\\decoder' => __DIR__ . '/../src/Decoder/Decoder.php', 'PhpactorDist\\libdns\\decoder\\decoderfactory' => __DIR__ . '/../src/Decoder/DecoderFactory.php', 'PhpactorDist\\libdns\\decoder\\decodingcontext' => __DIR__ . '/../src/Decoder/DecodingContext.php', 'PhpactorDist\\libdns\\decoder\\decodingcontextfactory' => __DIR__ . '/../src/Decoder/DecodingContextFactory.php', 'PhpactorDist\\libdns\\encoder\\encoder' => __DIR__ . '/../src/Encoder/Encoder.php', 'PhpactorDist\\libdns\\encoder\\encoderfactory' => __DIR__ . '/../src/Encoder/EncoderFactory.php', 'PhpactorDist\\libdns\\encoder\\encodingcontext' => __DIR__ . '/../src/Encoder/EncodingContext.php', 'PhpactorDist\\libdns\\encoder\\encodingcontextfactory' => __DIR__ . '/../src/Encoder/EncodingContextFactory.php', 'PhpactorDist\\libdns\\enumeration' => __DIR__ . '/../src/Enumeration.php', 'PhpactorDist\\libdns\\messages\\message' => __DIR__ . '/../src/Messages/Message.php', 'PhpactorDist\\libdns\\messages\\messagefactory' => __DIR__ . '/../src/Messages/MessageFactory.php', 'PhpactorDist\\libdns\\messages\\messageopcodes' => __DIR__ . '/../src/Messages/MessageOpCodes.php', 'PhpactorDist\\libdns\\messages\\messageresponsecodes' => __DIR__ . '/../src/Messages/MessageResponseCodes.php', 'PhpactorDist\\libdns\\messages\\messagetypes' => __DIR__ . '/../src/Messages/MessageTypes.php', 'PhpactorDist\\libdns\\packets\\labelregistry' => __DIR__ . '/../src/Packets/LabelRegistry.php', 'PhpactorDist\\libdns\\packets\\packet' => __DIR__ . '/../src/Packets/Packet.php', 'PhpactorDist\\libdns\\packets\\packetfactory' => __DIR__ . '/../src/Packets/PacketFactory.php', 'PhpactorDist\\libdns\\records\\question' => __DIR__ . '/../src/Records/Question.php', 'PhpactorDist\\libdns\\records\\questionfactory' => __DIR__ . '/../src/Records/QuestionFactory.php', 'PhpactorDist\\libdns\\records\\rdata' => __DIR__ . '/../src/Records/RData.php', 'PhpactorDist\\libdns\\records\\rdatabuilder' => __DIR__ . '/../src/Records/RDataBuilder.php', 'PhpactorDist\\libdns\\records\\rdatafactory' => __DIR__ . '/../src/Records/RDataFactory.php', 'PhpactorDist\\libdns\\records\\record' => __DIR__ . '/../src/Records/Record.php', 'PhpactorDist\\libdns\\records\\recordcollection' => __DIR__ . '/../src/Records/RecordCollection.php', 'PhpactorDist\\libdns\\records\\recordcollectionfactory' => __DIR__ . '/../src/Records/RecordCollectionFactory.php', 'PhpactorDist\\libdns\\records\\recordtypes' => __DIR__ . '/../src/Records/RecordTypes.php', 'PhpactorDist\\libdns\\records\\resource' => __DIR__ . '/../src/Records/Resource.php', 'PhpactorDist\\libdns\\records\\resourcebuilder' => __DIR__ . '/../src/Records/ResourceBuilder.php', 'PhpactorDist\\libdns\\records\\resourcebuilderfactory' => __DIR__ . '/../src/Records/ResourceBuilderFactory.php', 'PhpactorDist\\libdns\\records\\resourceclasses' => __DIR__ . '/../src/Records/ResourceClasses.php', 'PhpactorDist\\libdns\\records\\resourcefactory' => __DIR__ . '/../src/Records/ResourceFactory.php', 'PhpactorDist\\libdns\\records\\resourceqclasses' => __DIR__ . '/../src/Records/ResourceQClasses.php', 'PhpactorDist\\libdns\\records\\resourceqtypes' => __DIR__ . '/../src/Records/ResourceQTypes.php', 'PhpactorDist\\libdns\\records\\resourcetypes' => __DIR__ . '/../src/Records/ResourceTypes.php', 'PhpactorDist\\libdns\\records\\typedefinitions\\fielddefinition' => __DIR__ . '/../src/Records/TypeDefinitions/FieldDefinition.php', 'PhpactorDist\\libdns\\records\\typedefinitions\\fielddefinitionfactory' => __DIR__ . '/../src/Records/TypeDefinitions/FieldDefinitionFactory.php', 'PhpactorDist\\libdns\\records\\typedefinitions\\typedefinition' => __DIR__ . '/../src/Records/TypeDefinitions/TypeDefinition.php', 'PhpactorDist\\libdns\\records\\typedefinitions\\typedefinitionfactory' => __DIR__ . '/../src/Records/TypeDefinitions/TypeDefinitionFactory.php', 'PhpactorDist\\libdns\\records\\typedefinitions\\typedefinitionmanager' => __DIR__ . '/../src/Records/TypeDefinitions/TypeDefinitionManager.php', 'PhpactorDist\\libdns\\records\\typedefinitions\\typedefinitionmanagerfactory' => __DIR__ . '/../src/Records/TypeDefinitions/TypeDefinitionManagerFactory.php', 'PhpactorDist\\libdns\\records\\types\\anything' => __DIR__ . '/../src/Records/Types/Anything.php', 'PhpactorDist\\libdns\\records\\types\\bitmap' => __DIR__ . '/../src/Records/Types/BitMap.php', 'PhpactorDist\\libdns\\records\\types\\char' => __DIR__ . '/../src/Records/Types/Char.php', 'PhpactorDist\\libdns\\records\\types\\characterstring' => __DIR__ . '/../src/Records/Types/CharacterString.php', 'PhpactorDist\\libdns\\records\\types\\domainname' => __DIR__ . '/../src/Records/Types/DomainName.php', 'PhpactorDist\\libdns\\records\\types\\ipv4address' => __DIR__ . '/../src/Records/Types/IPv4Address.php', 'PhpactorDist\\libdns\\records\\types\\ipv6address' => __DIR__ . '/../src/Records/Types/IPv6Address.php', 'PhpactorDist\\libdns\\records\\types\\long' => __DIR__ . '/../src/Records/Types/Long.php', 'PhpactorDist\\libdns\\records\\types\\short' => __DIR__ . '/../src/Records/Types/Short.php', 'PhpactorDist\\libdns\\records\\types\\type' => __DIR__ . '/../src/Records/Types/Type.php', 'PhpactorDist\\libdns\\records\\types\\typebuilder' => __DIR__ . '/../src/Records/Types/TypeBuilder.php', 'PhpactorDist\\libdns\\records\\types\\typefactory' => __DIR__ . '/../src/Records/Types/TypeFactory.php', 'PhpactorDist\\libdns\\records\\types\\types' => __DIR__ . '/../src/Records/Types/Types.php'];
    }
    $className = \strtolower($className);
    if (isset($classMap[$className])) {
        /** @noinspection PhpIncludeInspection */
        require $classMap[$className];
    }
});
