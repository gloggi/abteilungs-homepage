<?php

use Directus\Application\Http\Request;
use Directus\Application\Http\Response;
use Directus\Services\ItemsService;

return [
    // See documentation at https://docs.directus.io/extensions/custom-endpoints.html#creating-custom-endpoints

    // The endpoints in this file are available under http://localhost:8080/_/custom/form

    // The endpoint path:
    // '' means it is located at: `/custom/<endpoint-id>`
    // '/` means it is located at: `/custom/<endpoint-id>/`
    // 'test' and `/test` means it is located at: `/custom/<endpoint-id>/test
    // if the handler is a Closure or Anonymous function, it's binded to the app container. Which means $this = to the app container.
    '' => [
        'method' => 'GET',
        'handler' => function (Request $request, Response $response) {

            // Get all answers from DB
            $itemsService = new ItemsService($this);

            $params = $request->getQueryParams();
            $ageLevels = $itemsService->findAll('age_levels', $params);

            return $response->withJson([
                'data' => [
                    $ageLevels
                ]
            ]);
        }
    ]
];
