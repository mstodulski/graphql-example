<?php
namespace App\Struct\Types;

use App\Struct\Classes\ComplexObjectLevel3;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class ComplexObjectLevel3Type extends ObjectType
{
    private array $fields = [];
    private array $interfaces = [];

    public function __construct()
    {
        parent::__construct([
            'name' => 'arrayOfComplexObjectsLevel3',
            'description' => '',
            'fields' => static fn (): array => [
                'nameLevel3' => Type::string(),
            ],
            'resolveField' => function(ComplexObjectLevel3 $complexObjectLevel3, array $args, $context, ResolveInfo $info): mixed
            {
                $fieldName = $info->fieldName;
                return $complexObjectLevel3->{$fieldName};
            },
        ]);
    }
}
