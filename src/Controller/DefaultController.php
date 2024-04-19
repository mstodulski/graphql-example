<?php

namespace App\Controller;

use App\Struct\MutationType;
use App\Struct\QueryType;
use App\Struct\Types;
use GraphQL\Error\DebugFlag;
use GraphQL\Server\StandardServer;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    private MutationType $mutationType;
    private QueryType $queryType;

    public function __construct(MutationType $mutationType, QueryType $queryType)
    {
        $this->mutationType = $mutationType;
        $this->queryType = $queryType;
    }

    #[Route('/', name: 'index', methods: [Request::METHOD_POST])]
    public function indexAction() : JsonResponse
    {
        $schemaConfig = SchemaConfig::create([
            'query' => $this->queryType,
            'mutation' => $this->mutationType,
            'typeLoader' => static fn(string $name): Type => Types::byTypeName($name),
        ]);

        $schema = new Schema($schemaConfig);
        $debug = DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE;

        $server = new StandardServer([
            'schema' => $schema,
            'context' => null,
            'debugFlag' => $debug
        ]);

        $serverResponse = $server->executeRequest();

        $output = $serverResponse->toArray();

        if (isset($output['errors'])) {
            $errorMessages = [];
            foreach ($output['errors'] as $error) {
                if (isset($error['extensions']['debugMessage'])) {
                    $errorMessages[] = $error['extensions']['debugMessage'];
                } elseif (isset($error['message'])) {
                    $errorMessages[] = $error['message'];
                }
            }

            $output = ['errors' => ['messages' => $errorMessages]];
            return new JsonResponse($output, 500);
        } else {
            return new JsonResponse($output);
        }

    }
}
