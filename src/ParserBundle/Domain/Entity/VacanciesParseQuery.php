<?php

declare(strict_types=1);

namespace App\ParserBundle\Domain\Entity;

use App\ParserBundle\Infrastructure\Repository\VacanciesParseQueryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VacanciesParseQueryRepository::class)]
class VacanciesParseQuery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $searchText = null;

    #[ORM\Column(length: 255)]
    private ?string $regionId = null;

    #[ORM\Column]
    private ?int $requestTime = null;


    #[ORM\Column(nullable: true)]
    private ?bool $onlyWithSalary = null;

    #[ORM\Column()]
    private ?bool $ready = null;

    #[ORM\Column()]
    private ?bool $failed = null;

    #[ORM\Column()]
    private ?bool $allRegion = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $searchFields = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $industries = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSearchText(): ?string
    {
        return $this->searchText;
    }

    public function setSearchText(?string $searchText): void
    {
        $this->searchText = $searchText;
    }

    public function getRegionId(): ?string
    {
        return $this->regionId;
    }

    public function setRegionId(?string $regionId): void
    {
        $this->regionId = $regionId;
    }

    public function getRequestTime(): ?int
    {
        return $this->requestTime;
    }

    public function setRequestTime(?int $requestTime): void
    {
        $this->requestTime = $requestTime;
    }

    public function getOnlyWithSalary(): ?bool
    {
        return $this->onlyWithSalary;
    }

    public function setOnlyWithSalary(?bool $onlyWithSalary): void
    {
        $this->onlyWithSalary = $onlyWithSalary;
    }

    public function getReady(): ?bool
    {
        return $this->ready;
    }

    public function setReady(?bool $ready): void
    {
        $this->ready = $ready;
    }

    public function getFailed(): ?bool
    {
        return $this->failed;
    }

    public function setFailed(?bool $failed): void
    {
        $this->failed = $failed;
    }

    public function getAllRegion(): ?bool
    {
        return $this->allRegion;
    }

    public function setAllRegion(?bool $allRegion): void
    {
        $this->allRegion = $allRegion;
    }

    public function getSearchFields(): ?array
    {
        return $this->searchFields;
    }

    public function setSearchFields(?array $searchFields): void
    {
        $this->searchFields = $searchFields;
    }

    public function getIndustries(): ?array
    {
        return $this->industries;
    }

    public function setIndustries(?array $industries): void
    {
        $this->industries = $industries;
    }


}