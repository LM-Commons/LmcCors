# Guide

## Event registration

LmcCors registers the `LmcCors\Mvc\CorsRequestListener` with the `MvcEvent::EVENT_ROUTE` event, with a priority
of -1. This means that this listener is executed AFTER the route has been matched.

## Configuring the module

As by default, all the various options are set globally for all routes:

- `allowed_origins`: (array) List of allowed origins. To allow any origin, you can use the wildcard (`*`) character. If
  multiple origins are specified, LmcCors will automatically check the `"Origin"` header's value, and only return the
  allowed domain (if any) in the `"Allow-Access-Control-Origin"` response header. To allow any sub-domain, you can prefix
  the domain with the wildcard character (i.e. `*.example.com`). Please note that you don't need to
  add your host URI (so if your website is hosted as "example.com", "example.com" is automatically allowed.
- `allowed_methods`: (array) List of allowed HTTP methods. Those methods will be returned for the preflight request to
  indicate which methods are allowed to the user agent. You can even specify custom HTTP verbs.
- `allowed_headers`: (array) List of allowed headers that will be returned for the preflight request. This indicates
  to the user agent which headers are permitted to be sent when doing the actual request.
- `max_age`: (int) Maximum age (seconds) the preflight request should be cached by the user agent. This prevents the
  user agent from sending a preflight request for each request.
- `exposed_headers`: (array) List of response headers that are allowed to be read in the user agent. Please note that
  some browsers do not implement this feature correctly.
- `allowed_credentials`: (boolean) If true, it allows the browser to send cookies along with the request.

If you want to configure specific routes, you can add `LmcCors\Options\CorsOptions::ROUTE_PARAM` to your route configuration:

```php
<?php

return [
    'lmc_cors' => [
        'allowed_origins' => ['*'],
        'allowed_methods' => ['GET', 'POST', 'DELETE'],
    ],
    'router' => [
        'routes' => [
            'readOnlyRoute' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/foo/bar',
                    'defaults' => [
                        // This will replace allowed_methods configuration to only allow GET requests
                        // and only allow a specific origin instead of the wildcard origin
                        LmcCors\Options\CorsOptions::ROUTE_PARAM => [
                            'allowed_origins' => ['http://example.org'],
                            'allowed_methods' => ['GET'],
                        ],
                    ],
                ],
            ],
            'someAjaxCalls' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/ajax',
                    'defaults' => [
                        // This overrides the wildcard origin
                        LmcCors\Options\CorsOptions::ROUTE_PARAM => [
                            'allowed_origins' => ['http://example.org'],
                        ],
                    ],
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'blog' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/blogpost',
                            'defaults' => [
                                // This would only allow `http://example.org` to GET this route
                                \LmcCors\Options\CorsOptions::ROUTE_PARAM => [
                                    'allowed_methods' => ['GET'],
                                ],
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'delete' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => ':id',
                                    // This would only allow origin `http://example.org` to apply DELETE on this route
                                    'defaults' => [
                                        \LmcCors\Options\CorsOptions::ROUTE_PARAM => [
                                            'allowed_methods' => ['DELETE'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
```

## Preflight request

If LmcCors detects a preflight CORS request, a new HTTP response will be created, and LmcCors will send the appropriate
headers according to your configuration. The response will always be sent with a 200 status code (OK).

Please note that this will also prevent further MVC steps from being executed, since all subsequent MVC steps are
skipped till `Laminas\Mvc\MvcEvent::EVENT_FINISH`, which is responsible for actually sending the response.

## Actual request

When an actual request is made, LmcCors first checks it the origin is allowed. If it is not, then a new response with
a 403 status code (Forbidden) is created and sent.

Please note that this will also prevent further MVC steps from being executed, since all subsequent MVC steps are
skipped till `Laminas\Mvc\MvcEvent::EVENT_FINISH`, which is responsible for actually sending the response.

If the origin is allowed, LmcCors will just add the appropriate headers to the request produced by `Laminas\Mvc`.

## Security concerns

Don't use this module to secure your application! You must use a proper authorization module, like
[BjyAuthorize](https://github.com/bjyoungblood/BjyAuthorize), [LmcRbacMvc](https://github.com/LM-Commons/LmcRbacMvc) or
[SpiffyAuthorize](https://github.com/spiffyjr/spiffy-authorize).

LmcCors only allows to accept or refuse a cross-origin request.

## Custom schemes

Internally, LmcCors uses `Laminas\Uri\UriFactory` class. If you are using custom schemes (for instance if you are
testing your API with some Google Chrome extensions), you need to add support for those schemes by adding them to
the `UriFactory` config (please [refer to the doc](https://docs.laminas.dev/laminas-uri/usage/#creating-a-new-custom-class-uri)).

## Example
To register the `chrome-extension` custom scheme in your API, simply add:

```php
use Laminas\Uri\UriFactory;

UriFactory::registerScheme('chrome-extension', 'Laminas\Uri\Uri');
```

to the `onBootstrap()` method in `module/Application/Module.php`.

Registering the `chrome-extension` custom scheme like this allows you to use Google Chrome extensions for testing your API.
