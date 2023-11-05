<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class IndustriesArrayResponse extends DataTransferObject
{
    /** @var IndustriesIdObject[]|null  */
    public ?array $objects;


    /**
     * @param ...$args
     * @throws UnknownProperties
     */
    public function __construct(
        ...$args
    )
    {
        parent::__construct($args);
        foreach ($args[0] as $arg) {
            $this->objects[] = new IndustriesIdObject(['id' => $arg['id'], 'name' => $arg['name'], 'industries' => $arg['industries']]);
        }
    }


    /**
     * @return IndustriesIdObject[]|null
     */
    public function getObjects(): ?array
    {
        return $this->objects;
    }



}