<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\DataTransferObject;

class AreaObject extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $id;

    /**
     * @var string|null
     */
    public ?string $name;
}