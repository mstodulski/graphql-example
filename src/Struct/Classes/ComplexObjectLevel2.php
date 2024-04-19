<?php declare(strict_types=1);

namespace App\Struct\Classes;

use GraphQL\Utils\Utils;

class ComplexObjectLevel2
{
    public ?array $arrayOfComplexObjectsLevel3 = null;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
