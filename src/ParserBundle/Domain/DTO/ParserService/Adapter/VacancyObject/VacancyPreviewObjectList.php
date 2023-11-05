<?php

namespace App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class VacancyPreviewObjectList extends DataTransferObject
{
    /**
     * @var int
     */
    public int $found;

    /**
     * @var int
     */
    public int $pages;

    /**
     * @var int
     */
    public int $per_page;

    /**
     * @var int
     */
    public int $page;

    /**
     * @var VacancyPreviewObject[]|null
     */
    #[CastWith(ArrayCaster::class, itemType: VacancyPreviewObject::class)]
    public ?array $items;

}