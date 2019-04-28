<?php

namespace Tests\Functional;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Symfony\Component\Yaml\Yaml;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class BaseTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = true;

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
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
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

        // Use the application settings
        require_once realpath(__DIR__) . '/../../config/environment.php';
        $config = Yaml::parse(file_get_contents(realpath(__DIR__) . '/../../config/config.' . $provisionContext. '.yml'));

        $settings = [
            'settings' => [
                'displayErrorDetails' => $config['slim']['settings']['display_error_details'], // set to false in production
                'addContentLengthHeader' => $config['slim']['settings']['add_content_length'], // Allow the web server to send the content-length header
            ],
        ];
        
        // Instantiate the application
        $app = new App($settings);

        // Set up dependencies
        require_once __DIR__ . '/../../config/dependencies.php';

        // Register middleware
        if ($this->withMiddleware) {
            require_once __DIR__ . '/../../config/middleware.php';
        }

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(realpath(__DIR__) . '/../../routes'));
        $routes = array_keys(array_filter(iterator_to_array($iterator), function($file) {
            return $file->isFile();
        }));

        foreach ($routes as $route) {
            if (strpos($route, '.php') !== false) {
                require_once(realpath($route));
            }
        }
        /***/

        // Process the application
        $response = $app->process($request, $response);

        // Return the response
        return $response;
    }
}
