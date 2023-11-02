<?php

declare(strict_types=1);

namespace MaarchCourrier\Tests\app\external\Pastell\Mock;

use ExternalSignatoryBook\pastell\Domain\VisaCircuitDataInterface;

class VisaCircuitMock implements VisaCircuitDataInterface
{
    public string $signatoryUserId = '';

    /**
     * @param int $resId
     * @return string[]
     */
    public function getNextSignatory(int $resId): array
    {
        return [
            'userId' => $this->signatoryUserId
        ];
    }
}
