<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\DataTransferObject;

class EmployerObject extends DataTransferObject
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