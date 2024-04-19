<?php declare(strict_types=1);

namespace App\Struct\Classes;

use GraphQL\Utils\Utils;

class ComplexObjectLevel3
{
    public string $nameLevel3 = '';

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
