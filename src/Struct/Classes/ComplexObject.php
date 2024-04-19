<?php declare(strict_types=1);

namespace App\Struct\Classes;

use GraphQL\Utils\Utils;

class ComplexObject
{
    public string $name = '';
    public ?ComplexObjectLevel2 $complexObjectLevel2 = null;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
