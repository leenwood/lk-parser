<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\DataTransferObject;

class SalaryObject extends DataTransferObject
{
    /**
     * @var int|null
     */
    public ?int $from;

    /**
     * @var int|null
     */
    public ?int $to;

    /**
     * @var string|null
     */
    public ?string $currency;

    /**
     * @var bool|null
     */
    public ?bool $gross;
}