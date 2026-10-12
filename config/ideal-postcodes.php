<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | API key
    |--------------------------------------------------------------------------
    |
    | Your API key (ak_…) or a licensee key (sl_…). Every request sends it.
    |
    */

    'api_key' => env('IDPC_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Management Key
    |--------------------------------------------------------------------------
    |
    | Your Management Key (uk_…), needed only for key, licensee and
    | configuration operations. Leave it unset in any application that does
    | not manage keys.
    |
    */

    'management_key' => env('IDPC_MANAGEMENT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Base URI
    |--------------------------------------------------------------------------
    |
    | Where requests go. Leave it null for https://api.ideal-postcodes.co.uk/v1.
    |
    */

    'base_uri' => env('IDPC_BASE_URI'),

    /*
    |--------------------------------------------------------------------------
    | HTTP client
    |--------------------------------------------------------------------------
    |
    | The container binding of the PSR-18 client that sends requests. Leave it
    | null to use Psr\Http\Client\ClientInterface when your application binds
    | it, otherwise an installed client found by php-http/discovery, which is
    | the Guzzle that Laravel ships.
    |
    */

    'http_client' => null,

    /*
    |--------------------------------------------------------------------------
    | Headers
    |--------------------------------------------------------------------------
    |
    | Headers sent with every request, such as a User-Agent naming your
    | application.
    |
    */

    'headers' => [],

];
