<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter;

use Spatie\DataTransferObject\DataTransferObject;

class IndustriesIdObject extends DataTransferObject
{

    public int $id;

    public string $name;


    /** @var IndustryObject[]  */
    public array $industries;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return IndustryObject[]
     */
    public function getIndustries(): array
    {
        return $this->industries;
    }

}