<?php

namespace Phpactor202301\Phpactor\LanguageServer\Test;

use Phpactor202301\Phpactor\LanguageServerProtocol\ClientCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentIdentifier;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextEdit;
use Phpactor202301\Phpactor\LanguageServerProtocol\VersionedTextDocumentIdentifier;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\NotificationMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\RequestMessage;
final class ProtocolFactory
{
    public static function textDocumentItem(string $uri, string $content) : TextDocumentItem
    {
        return new TextDocumentItem($uri, 'php', 1, $content);
    }
    public static function versionedTextDocumentIdentifier(?string $uri = 'foobar', ?int $version = null) : VersionedTextDocumentIdentifier
    {
        return new VersionedTextDocumentIdentifier($uri, $version);
    }
    public static function textDocumentIdentifier(string $uri) : TextDocumentIdentifier
    {
        return new TextDocumentIdentifier($uri);
    }
    public static function initializeParams(?string $rootUri = null) : InitializeParams
    {
        $params = new InitializeParams(new ClientCapabilities());
        $params->rootUri = $rootUri;
        return $params;
    }
    public static function requestMessage(string $method, array $params) : RequestMessage
    {
        return new RequestMessage(\uniqid(), $method, $params);
    }
    public static function notificationMessage(string $method, array $params) : NotificationMessage
    {
        return new NotificationMessage($method, $params);
    }
    public static function range(int $line1, int $char1, int $line2, int $char2) : Range
    {
        return new Range(self::position($line1, $char1), self::position($line2, $char2));
    }
    public static function position(int $line, int $char) : Position
    {
        return new Position($line, $char);
    }
    public static function diagnostic(Range $range, string $message) : Diagnostic
    {
        return new Diagnostic($range, $message);
    }
    public static function textEdit(int $line1, int $char1, int $line2, int $char2, string $text) : TextEdit
    {
        return new TextEdit(self::range($line1, $char1, $line2, $char2), $text);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Test\\ProtocolFactory', 'Phpactor\\LanguageServer\\Test\\ProtocolFactory', \false);
