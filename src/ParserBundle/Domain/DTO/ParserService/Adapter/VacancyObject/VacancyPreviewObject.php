<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class VacancyPreviewObject extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var int|null
     */
    public ?int $id;

    /**
     * @var string|null
     */
    public ?string $alternate_url;

    /**
     * @var string|null
     */
    public ?string $published_at;

    /**
     * @var string|null
     */
    public ?string $created_at;

    /**
     * @var AreaObject|null
     */
    public ?AreaObject $area;

    /**
     * @var string|null
     */
    #[MapFrom('employer.logo_urls.original')]
    public ?string $original;

    /**
     * @var SalaryObject|null
     */
    public ?SalaryObject $salary;

    /**
     * @var EmployerObject|null
     */
    public ?EmployerObject $employer;

    /**
     * @var ScheduleObject|null
     */
    public ?ScheduleObject $schedule;

    /**
     * @var ContactsObject|null
     */
    public ?ContactsObject $contacts;

}