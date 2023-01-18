<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Model\NameImport\NameImporter;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
class ImportNameCommand implements Command
{
    public const NAME = 'name_import';
    public function __construct(private NameImporter $nameImporter, private Workspace $workspace, private ClientApi $client)
    {
    }
    public function __invoke(string $uri, int $offset, string $type, string $fqn, ?string $alias = null) : Promise
    {
        $document = $this->workspace->get($uri);
        $result = $this->nameImporter->__invoke($document, $offset, $type, $fqn, \true, $alias);
        if ($result->isSuccess()) {
            if (!$result->hasTextEdits()) {
                return new Success(null);
            }
            $textEdits = $result->getTextEdits();
            return $this->client->workspace()->applyEdit(new WorkspaceEdit([$uri => $textEdits]), 'Import class');
        }
        $error = $result->getError();
        $this->client->window()->showMessage()->warning($error->getMessage());
        return new Success(null);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\ImportNameCommand', 'Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\ImportNameCommand', \false);
