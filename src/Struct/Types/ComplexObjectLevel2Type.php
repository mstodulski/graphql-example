<?php
namespace App\Struct\Types;

use App\Struct\Classes\ComplexObjectLevel2;
use App\Struct\Types;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class ComplexObjectLevel2Type extends ObjectType
{
    private array $fields = [];
    private array $interfaces = [];

    public function __construct()
    {
        parent::__construct([
            'fields' => static fn (): array => [
                'arrayOfComplexObjectsLevel3' => new ListOfType(Types::complexObjectLevel3()),
            ],
            'resolveField' => function(ComplexObjectLevel2 $complexObjectLevel2, array $args, $context, ResolveInfo $info): mixed
            {
                $fieldName = $info->fieldName;
                return $complexObjectLevel2->{$fieldName};
            },
        ]);
    }
}
