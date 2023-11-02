<?php

declare(strict_types=1);

namespace MaarchCourrier\Tests\app\external\Pastell\Mock;

use ExternalSignatoryBook\pastell\Application\SendToPastell;

class SendToPastellSpy extends SendToPastell
{
    public array $annexes = [];
    public string $sousTypeGiven = '';
    public array $titlesGiven = [];

    /**
     * @param int $resId
     * @param string $title
     * @param string $sousType
     * @param string $filePath
     * @param array $annexes
     * @return array|string[]
     */
    public function sendFolderToPastell(int $resId, string $title, string $sousType, string $filePath, array $annexes = []): array
    {
        $this->annexes = $annexes;
        $this->sousTypeGiven = $sousType;
        $this->titlesGiven[] = $title;

        return parent::sendFolderToPastell($resId, $title, $sousType, $filePath, $annexes);
    }

}
