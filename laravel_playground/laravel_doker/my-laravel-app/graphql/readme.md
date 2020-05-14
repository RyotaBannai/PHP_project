## GraphQL
### installing lighthouse
- When installing lighthouse, the error might occured.
- `php --ini` shows when `php.init` locates. And then edit `memory_limit=-1`
- shows default memory limit by hitting `php -r "echo ini_get('memory_limit').PHP_EOL;"`
- you might set composer environment variable. `export COMPOSER_MEMORY_LIMIT=-1` and then hit the `composer install nuwave/lighthouse`
### setups
- publish lighthouse config file `php artisan vendor:publish --provider="Nuwave\Lighthouse\LighthouseServiceProvider" --tag=config` 
- 
