<?php

declare(strict_types=1);

namespace IdealPostcodes\Laravel\Facades;

use IdealPostcodes\Client;
use IdealPostcodes\Resources\Addresses;
use IdealPostcodes\Resources\Autocomplete;
use IdealPostcodes\Resources\Configs;
use IdealPostcodes\Resources\Emails;
use IdealPostcodes\Resources\Keys;
use IdealPostcodes\Resources\Licensees;
use IdealPostcodes\Resources\PhoneNumbers;
use IdealPostcodes\Resources\Places;
use IdealPostcodes\Resources\Postcodes;
use Illuminate\Support\Facades\Facade;

/**
 * Static access to the bound `IdealPostcodes\Client`.
 *
 * @method static Postcodes postcodes()
 * @method static Addresses addresses()
 * @method static Autocomplete autocomplete()
 * @method static Places places()
 * @method static Emails emails()
 * @method static PhoneNumbers phoneNumbers()
 * @method static Keys keys()
 * @method static Licensees licensees()
 * @method static Configs configs()
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
