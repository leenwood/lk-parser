<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class VacancyObject extends DataTransferObject
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
    public ?string $description;

    /**
     * @var string|null
     */
    public ?string $published_at;

    /**
     * @var string|null
     */
    public ?string $created_at;

    /**
     * @var bool|null
     */
    public ?bool $accept_kids;

    /**
     * @var AreaObject|null
     */
    public ?AreaObject $area;

    /**
     * @var SalaryObject|null
     */
    public ?SalaryObject $salary;

    /**
     * @var EmploymentObject|null
     */
    public ?EmploymentObject $employment;

    /**
     * @var EducationObject|null
     */
    public ?EducationObject $education_level;

    /**
     * @var string|null
     */
    #[MapFrom('employer.logo_urls.original')]
    public ?string $logo;

    /**
     * @var EmployerObject|null
     */
    public ?EmployerObject $employer;

    /**
     * @var ScheduleObject|null
     */
    public ?ScheduleObject $schedule;

    /**
     * @var ExperienceObject|null
     */
    public ?ExperienceObject $experience;

    /**
     * @var KeySkillsObject[]|null
     */
    #[CastWith(ArrayCaster::class, itemType: KeySkillsObject::class)]
    public ?array $key_skills;

    /**
     * @var array|null
     */
    #[CastWith(ArrayCaster::class, itemType: SpecializationObject::class)]
    public ?array $specializations;

    /**
     * @var ContactsObject|null
     */
    public ?ContactsObject $contacts;

    /**
     * @var AddressObject|null
     */
    public ?AddressObject $address;
}