<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class ContactsObject extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $email;

    /**
     * @var array|null
     */
    #[CastWith(ArrayCaster::class, itemType: PhoneObject::class)]
    public ?array $phones;
}