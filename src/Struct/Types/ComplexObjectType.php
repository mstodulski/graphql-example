<?php
namespace App\Struct\Types;

use App\Struct\Classes\ComplexObject;
use App\Struct\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class ComplexObjectType extends ObjectType
{
    private array $fields = [];
    private array $interfaces = [];

    public function __construct()
    {
        parent::__construct([
            'fields' => static fn (): array => [
                'name' => Type::string(),
                'complexObjectLevel2' => Types::complexObjectLevel2(),
            ],
            'resolveField' => function(ComplexObject $complexObject, array $args, $context, ResolveInfo $info): mixed
            {
                $fieldName = $info->fieldName;
                return $complexObject->{$fieldName};
            },
        ]);
    }
}
