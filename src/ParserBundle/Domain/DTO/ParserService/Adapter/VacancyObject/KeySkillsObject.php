<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\DataTransferObject;

class KeySkillsObject extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $name;
}