<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class BaseTestCase extends TestCase
{
    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = true;

    /**
     * Slim Application
     *
     * @var Slim\App
     */
    public $slimApp;

    /**
     * Slim App configuration
     */
    public function slimAppConfigure()
    {
        // TEST environment variable for DI
        putenv("TEST=true");

        // Use the application settings
        $settings = require __DIR__ . '/../src/settings.php';

        // Instantiate the application
        $this->slimApp = new App($settings);

        // Set up dependencies
        $dependencies = require __DIR__ . '/../src/dependencies.php';
        $dependencies($this->slimApp);

        // Register middleware
        if ($this->withMiddleware) {
            $middleware = require __DIR__ . '/../src/middleware.php';
            $middleware($this->slimApp);
        }

        // Register routes
        $routes = require __DIR__ . '/../src/routes.php';
        $routes($this->slimApp);
    }

    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        $this->slimAppConfigure();

        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri,
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        // Process the application
        $response = $this->slimApp->process($request, $response);

        // Return the response
        return $response;
    }
}
