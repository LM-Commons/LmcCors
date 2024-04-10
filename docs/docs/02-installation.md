# Installation
Install the module by typing (or add it to your `composer.json` file):

```bash
$ php composer.phar require lm-commons/lmc-cors
```

Then, enable it by adding "LmcCors" in your `application.config.php` or `modules.config.php` file.

By default, LmcCors is configured to deny every CORS requests. To change that, you need to copy
the [`config/lmc_cors.global.php.dist`](https://github.com/LM-Commons/LmcCors/blob/master/config/lmc_cors.global.php.dist) file to your `autoload` folder
(remove the `.dist` extension), and modify it to suit your needs.
