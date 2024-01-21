<?php

namespace App\ApiBundle\RequestObject;

class BaseParseRequestObject
{

    public string $searchText;

    public ?string $regionId;

    public bool $allRegion;

    public ?array $industries;

    public ?array $searchFields;

    public ?bool $onlyWithSalary;
}