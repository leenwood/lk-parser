<?php

namespace App\ParserBundle\Application\Command\ParserVacanciesQueueCommand;

use Spatie\DataTransferObject\DataTransferObject;

class ParserVacanciesQueueCommand extends DataTransferObject
{

    public string $searchText;

    public ?string $regionId;

    public bool $allRegion;

    public ?array $industries;

    public ?array $searchFields;

    public ?bool $onlyWithSalary;

}