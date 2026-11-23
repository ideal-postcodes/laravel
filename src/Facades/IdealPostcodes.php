<?php

declare(strict_types=1);

namespace IdealPostcodes\Laravel\Facades;

use IdealPostcodes\Client;
use Illuminate\Support\Facades\Facade;

/**
 * Static access to the bound `IdealPostcodes\Client`: every client method,
 * such as `IdealPostcodes::postcodes('BR8 7RE')`.
 *
 * @mixin Client
 *
 * @see Client
 */
final class IdealPostcodes extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Client::class;
    }
}
