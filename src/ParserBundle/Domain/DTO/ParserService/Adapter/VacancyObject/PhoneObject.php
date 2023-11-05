<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\DataTransferObject;

class PhoneObject extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $comment;

    /**
     * @var string|null
     */
    public ?string $city;

    /**
     * @var string|null
     */
    public ?string $number;

    /**
     * @var string|null
     */
    public ?string $country;
}