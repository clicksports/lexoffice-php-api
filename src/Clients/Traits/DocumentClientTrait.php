<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients\Traits;

use Clicksports\LexOffice\Clients\File;
use Psr\Http\Message\ResponseInterface;
use stdClass;

trait DocumentClientTrait
{
    /**
     * @param string $id
     * @param bool $asContent
     * @return ResponseInterface
     */
    public function document(string $id, bool $asContent = false): ResponseInterface
    {
        $response = $this->api->newRequest('GET', $this->resource . '/' . $id . '/document')
            ->getResponse();

        if ($asContent === false) {
            return $response;
        }

        /** @var stdClass{documentField: string} $content */
        $content = $this->getAsJson($response);
        $fileClient = new File($this->api);

        return $fileClient->get($content->documentFileId);
    }
}