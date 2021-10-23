<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
// use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Message\ResponseInterface as Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    $app->group('/api', function () use ($app){
        // Version group
        $app->group('/v1', function() use ($app) {

            $app->post('/getAccountID','getAccountID');
            $app->get('/getUserInformation','getUserInformation');
            $app->post('/signUpUser','signUpUser');
            $app->get('/getLoanOffer','getLoanOffer');
            $app->post('/loginUser','loginUser');
            $app->get('/getCurrentLoanOffer','getCurrentLoanOffer');
            $app->post('/withdrawLoan','withdrawLoan');
            $app->get('/getCurrentDebt','getCurrentDebt');
            $app->get('/getAccountData','getAccountData');
            $app->get('/payBackLoan', 'payBackLoan');


            
        });
    });
};
