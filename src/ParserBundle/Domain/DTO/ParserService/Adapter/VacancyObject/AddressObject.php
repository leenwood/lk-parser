<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\DataTransferObject;

class AddressObject extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $city;

    /**
     * @var string|null
     */
    public ?string $street;

    /**
     * @var string|null
     */
    public ?string $building;

    /**
     * @var string|null
     */
    public ?string $raw;

    /**
     * @var string|null
     */
    public ?string $lat;

    /**
     * @var string|null
     */
    public ?string $lng;
}