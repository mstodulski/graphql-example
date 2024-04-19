<?php
namespace App\Struct;

use GraphQL\Type\Definition\ObjectType;

class QueryType extends ObjectType {

    private array $fields = [];
    private array $interfaces = [];

    public function __construct() {
        parent::__construct($this->getConfig());
    }

    private function getConfig() : array
    {
        return [
            'name' => 'Query',
            'fields' => [

            ]
        ];
    }
}
