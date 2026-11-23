<?php

declare(strict_types=1);

namespace IdealPostcodes\Laravel;

use IdealPostcodes\Client;
use IdealPostcodes\Contracts\ClientContract;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Binds an `IdealPostcodes\Client` built from `config/ideal-postcodes.php`,
 * so it can be constructor-injected as `Client` or `ClientContract`.
 * Package discovery registers the provider and the `IdealPostcodes` facade.
 */
final class IdealPostcodesServiceProvider extends ServiceProvider
{
    public const CONFIG = 'ideal-postcodes';

    /**
     * The `vendor:publish` tag that copies the config file into the application.
     */
    public const CONFIG_TAG = 'ideal-postcodes-config';

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ideal-postcodes.php', self::CONFIG);

        $this->app->singleton(Client::class, fn (Container $app): Client => self::clientFor($app));
        $this->app->alias(Client::class, ClientContract::class);
        $this->app->alias(Client::class, self::CONFIG);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/ideal-postcodes.php' => $this->app->configPath('ideal-postcodes.php'),
            ], self::CONFIG_TAG);
        }
    }

    private static function clientFor(Container $app): Client
    {
        $repository = $app->make(Repository::class);
        $config = $repository->get(self::CONFIG);
        $config = is_array($config) ? $config : [];

        $apiKey = $config['api_key'] ?? null;

        if (! is_string($apiKey) || $apiKey === '') {
            throw new InvalidArgumentException('Ideal Postcodes needs an API key. Set IDPC_API_KEY in .env or api_key in config/ideal-postcodes.php.');
        }

        $httpClient = $config['http_client'] ?? null;
        $httpClient = is_string($httpClient) && $httpClient !== ''
            ? $app->make($httpClient)
            : self::bound($app, ClientInterface::class);

        if ($httpClient !== null && ! $httpClient instanceof ClientInterface) {
            throw new InvalidArgumentException('ideal-postcodes.http_client must resolve to a Psr\Http\Client\ClientInterface.');
        }

        $requestFactory = self::bound($app, RequestFactoryInterface::class);
        $streamFactory = self::bound($app, StreamFactoryInterface::class);

        return ClientFactory::create(
            $apiKey,
            self::optionalString($config, 'management_key'),
            self::optionalString($config, 'base_uri'),
            self::headersFrom($config['headers'] ?? []),
            $httpClient,
            $requestFactory instanceof RequestFactoryInterface ? $requestFactory : null,
            $streamFactory instanceof StreamFactoryInterface ? $streamFactory : null,
        );
    }

    /**
     * The service bound under `$abstract`, or null when the application has none.
     */
    private static function bound(Container $app, string $abstract): ?object
    {
        if (! $app->bound($abstract)) {
            return null;
        }

        $service = $app->make($abstract);

        return is_object($service) ? $service : null;
    }

    /**
     * The `headers` option as the SDK takes it: a name to a scalar value.
     * Anything else in the array is ignored.
     *
     * @return array<string, scalar|null>
     */
    private static function headersFrom(mixed $headers): array
    {
        $result = [];

        if (! is_array($headers)) {
            return $result;
        }

        foreach ($headers as $name => $value) {
            if (is_string($name) && (is_scalar($value) || $value === null)) {
                $result[$name] = $value;
            }
        }

        return $result;
    }

    /**
     * @param  array<mixed>  $config
     */
    private static function optionalString(array $config, string $key): ?string
    {
        $value = $config[$key] ?? null;

        return is_string($value) && $value !== '' ? $value : null;
    }
}
