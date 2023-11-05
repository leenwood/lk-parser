<?php

namespace App\ParserBundle\Domain\Service\ParserService;

use App\ParserBundle\Domain\DTO\ParserService\Adapter\IndustriesArrayResponse;
use App\ParserBundle\Domain\Exception\AdapterServiceException;

class IndustriesService
{
    public function __construct(
        private readonly AdapterService $adapterService
    )
    {
    }

    /**
     * @Return IndustriesArrayResponse
     * @throws AdapterServiceException
     */
    public function getIndustries(): IndustriesArrayResponse
    {
        return $this->adapterService->getIndustriesId();
    }
}