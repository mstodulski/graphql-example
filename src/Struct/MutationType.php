<?php
namespace App\Struct;

use App\Struct\Classes\ComplexObject;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class MutationType extends ObjectType {

    private array $fields = [];
    private array $interfaces = [];

    public function __construct() {
        parent::__construct($this->getConfig());
    }

    private function getConfig() : array
    {
        return [
            'name' => 'Mutation',
            'fields' => [
                'addComplexObject' => $this->defineAddComplexObjectOptions(),
            ]
        ];
    }

    private function defineAddComplexObjectOptions() : array
    {
        return [
            'type' => Types::complexObject(),
            'args' => [
                'name' => [
                    'name' => 'name',
                    'type' =>  new NonNull(Type::string()),
                    'description' => '',
                ],
                'complexObjectLevel2' => [
                    'type' => $this->defineComplexObjectLevel2Options(),
                ],
            ],
            'resolve' => function(?string $root, array $args, $context, ResolveInfo $resolveInfo): ComplexObject {
                die('finish');
            }
        ];
    }

    private function defineComplexObjectLevel2Options(): InputObjectType
    {
        return new InputObjectType([
            'name' => 'complexObjectLevel2',
            'fields' => [
                'stageTypes' => [
                    'name' => 'arrayOfComplexObjectsLevel3',
                    'type' => Type::listOf(Types::complexObjectLevel3()),
                    'description' => '',
                    'defaultValue' => [],
                ],
            ]
        ]);
    }
}
