# Ideal Postcodes Laravel Package

Set your Ideal Postcodes API key in `.env`, then inject the [PHP SDK](https://packagist.org/packages/ideal-postcodes/sdk) client into a controller, or call the facade. Laravel 12 or 13, PHP 8.2 or later.

```bash
composer require ideal-postcodes/laravel
```

Package discovery registers the service provider and the `IdealPostcodes` facade.

```bash
# .env
IDPC_API_KEY=ak_test
IDPC_MANAGEMENT_KEY=uk_... # only for key, licensee and config operations
```

```php
use IdealPostcodes\Client;

final class CheckoutController
{
    public function __construct(private readonly Client $client) {}

    public function addresses(string $postcode): array
    {
        return $this->client->lookup($postcode)->addresses;
    }
}
```

```php
use IdealPostcodes\Laravel\Facades\IdealPostcodes;

$lookup = IdealPostcodes::lookup('BR8 7RE');
```

Inject `IdealPostcodes\Client`, or `IdealPostcodes\Contracts\ClientContract` to swap in a test double. Each API operation is one method on the client and the facade, such as `IdealPostcodes::addressCleanse($body)`.

Requests go through the Guzzle that Laravel ships, found by `php-http/discovery`, or through `Psr\Http\Client\ClientInterface` when your application binds one. Publish the config file to change the base URI, the HTTP client binding or the headers sent with every request:

```bash
php artisan vendor:publish --tag=ideal-postcodes-config
```

| Option | Purpose |
| --- | --- |
| `api_key` | Required. Your API key or a licensee key, from `IDPC_API_KEY` |
| `management_key` | Your Management Key for account operations, from `IDPC_MANAGEMENT_KEY` |
| `base_uri` | Defaults to `https://api.ideal-postcodes.co.uk/v1` |
| `http_client` | Container binding of a PSR-18 client to use instead of the default |
| `headers` | Headers sent with every request |

[Documentation](https://docs.ideal-postcodes.co.uk/docs/sdks/php/laravel) covers configuration, testing with a mock client and the SDK itself.

## License

SEE LICENSE IN LICENSE
