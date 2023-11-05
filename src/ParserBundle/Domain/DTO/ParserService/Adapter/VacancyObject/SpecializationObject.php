<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\DataTransferObject;

class SpecializationObject extends DataTransferObject
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $profarea_id;

    /**
     * @var string
     */
    public string $profarea_name;
}