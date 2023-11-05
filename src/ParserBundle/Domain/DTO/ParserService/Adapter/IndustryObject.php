<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter;

use Spatie\DataTransferObject\DataTransferObject;

class IndustryObject extends DataTransferObject
{

    public int $id;

    public string $name;

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




}