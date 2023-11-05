<?php

namespace App\ParserBundle\Application\Queue;

use App\ParserBundle\Domain\Entity\VacanciesParseQuery;

class ParserQueryMessage
{
    /**
     * @param string $searchText
     * @param string|null $regionId
     * @param bool $allRegion
     * @param VacanciesParseQuery $query
     * @param bool $split
     */
    public function __construct(
        private string              $searchText,
        private ?string             $regionId,
        private bool                $allRegion,
        private VacanciesParseQuery $query,
        private bool                $split = false
    )
    {
    }

    /**
     * @return string
     */
    public function getSearchText(): string
    {
        return $this->searchText;
    }

    /**
     * @return string|null
     */
    public function getRegionId(): ?string
    {
        return $this->regionId;
    }

    /**
     * @return bool
     */
    public function isAllRegion(): bool
    {
        return $this->allRegion;
    }

    /**
     * @return VacanciesParseQuery
     */
    public function getQuery(): VacanciesParseQuery
    {
        return $this->query;
    }

    /**
     * @return bool
     */
    public function isSplit(): bool
    {
        return $this->split;
    }

}