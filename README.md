# Overview

Tiny router for tiny projects without MVC.
Converts http://example.com/test to ./controllers/test.php

# Installation

You can install in using composer:

`composer require mikechip/router`

Or just include classes from _/src_

# Usage

```
<?php
    require_once('vendor/autoload.php');

    /*
     * Directory where your controllers are located
     */
    $controller_dir = __DIR__ . '/test_controllers';

    /*
     * Optional. URI that client requested.
     * $_SERVER['REQUEST_URI'] is used by default.
     * Use only if it is highly needed (for example, in ReactPHP)
     */
    $request_uri = $_SERVER['REQUEST_URI'];

    /*
     * Create new Router object and get result
     */
    $router = new Mike4ip\Router\Router( $controller_dir, $request_uri );
    $result = $router->getResult();

    try {
        /*
         * Run controller.
         * For example: if you requested /test,
         * it runs $controller_dir/test.php
         */
        require(
            $result->getController()
        );
    } catch(Mike4ip\Router\NotFoundException $e) {
        /*
         * If controller you need is not found
         */
        http_response_code(404);
        print('Page not found');
    }
```

Or use simple shortcut:

```
<?php
    require_once('vendor/autoload.php');
    $controller_dir = __DIR__ . '/test_controllers';
    \Mike4ip\Router\Router::autorun();
```

# Feedback

You are welcome at Issues: https://github.com/mikechip/php7-router/issues
