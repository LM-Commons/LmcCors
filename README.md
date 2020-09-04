# LmcCors

> This is work in progress to port ZfcCors to Laminas.
> Only the latest master branch of zfr-cors will be ported.  Older tags will not be copied to this version.


<!--
[![Build Status](https://travis-ci.org/zf-fr/zfr-cors.png?branch=master)](https://travis-ci.org/zf-fr/zfr-cors)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/zf-fr/zfr-cors/badges/quality-score.png?s=47504d5f5a04f88fb40aebbd524d9d241c2ae588)](https://scrutinizer-ci.com/g/zf-fr/zfr-cors/)
[![Coverage Status](https://coveralls.io/repos/zf-fr/zfr-cors/badge.png?branch=master)](https://coveralls.io/r/zf-fr/zfr-cors?branch=master)
[![Latest Stable Version](https://poser.pugx.org/zfr/zfr-cors/v/stable.png)](https://packagist.org/packages/zfr/zfr-cors)
-->

LmcCors is a simple Laminas MVC module that helps you to deal with Cross-Origin Resource Sharing (CORS).

## What is LmcCors ?

LmcCors is a Laminas MVC module that allow to easily configure your Laminas MVC application so that it automatically
builds HTTP responses that follow the CORS documentation.

### Installation

Install the module by typing (or add it to your `composer.json` file):

```sh
$ php composer.phar require laminas-commons/lmc-cors
```

Then, enable it by adding "LmcCors" in your `application.config.php` or `modules.config.php` file.

By default, LmcCors is configured to deny every CORS requests. To change that, you need to copy
the [`config/lmc_cors.global.php.dist`](config/lmc_cors.global.php.dist) file to your `autoload` folder
(remove the `.dist` extension), and modify it to suit your needs.

## Documentation

### What is CORS ?

CORS is a mechanism that allows to perform cross-origin requests from your browser.

For instance, let's say that your website is hosted in the domain `http://example.com`.
By default, user agents won't be allowed to perform AJAX requests to another domain for security
reasons (for instance `http://funny-domain.com`).

With CORS, you can allow your server to reply to such requests.

You can find better documentation on how CORS works on the web:

 * [Mozilla documentation about CORS](https://developer.mozilla.org/en-US/docs/HTTP/Access_control_CORS)
 * [CORS server flowchart](http://www.html5rocks.com/static/images/cors_server_flowchart.png)

### Event registration

LmcCors registers the `LmcCors\Mvc\CorsRequestListener` with the `MvcEvent::EVENT_ROUTE` event, with a priority
of -1. This means that this listener is executed AFTER the route has been matched.

### Configuring the module

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

If you want to configure specific routes, you can add `ZfrCors\Options\CorsOptions::ROUTE_PARAM` to your route configuration:

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

### Preflight request

If LmcCors detects a preflight CORS request, a new HTTP response will be created, and LmcCors will send the appropriate
headers according to your configuration. The response will always be sent with a 200 status code (OK).

Please note that this will also prevent further MVC steps from being executed, since all subsequent MVC steps are
skipped till `Laminas\Mvc\MvcEvent::EVENT_FINISH`, which is responsible for actually sending the response.

### Actual request

When an actual request is made, LmcCors first checks it the origin is allowed. If it is not, then a new response with
a 403 status code (Forbidden) is created and sent.

Please note that this will also prevent further MVC steps from being executed, since all subsequent MVC steps are
skipped till `Laminas\Mvc\MvcEvent::EVENT_FINISH`, which is responsible for actually sending the response.

If the origin is allowed, LmcCors will just add the appropriate headers to the request produced by `Laminas\Mvc`.

### Security concerns

Don't use this module to secure your application! You must use a proper authorization module, like
[BjyAuthorize](https://github.com/bjyoungblood/BjyAuthorize), [LmcRbacMvc](https://github.com/Laminas-Commons/LmcRbacMvc) or
[SpiffyAuthorize](https://github.com/spiffyjr/spiffy-authorize).

LmcCors only allows to accept or refuse a cross-origin request.

### Custom schemes

Internally, LmcCors uses `Laminas\Uri\UriFactory` class. If you are using custom schemes (for instance if you are
testing your API with some Google Chrome extensions), you need to add support for those schemes by adding them to
the `UriFactory` config (please [refer to the doc](https://docs.laminas.dev/laminas-uri/usage/#creating-a-new-custom-class-uri)).

### Example
To register the `chrome-extension` custom scheme in your API, simply add:

```php
use Laminas\Uri\UriFactory;

UriFactory::registerScheme('chrome-extension', 'Laminas\Uri\Uri');
```

to the `onBootstrap()` method in `module/Application/Module.php`.

Registering the `chrome-extension` custom scheme like this allows you to use Google Chrome extensions for testing your API.
