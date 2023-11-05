<?php

namespace App\ParserBundle\Domain\Service\ParserService;

use App\ParserBundle\Domain\DTO\ParserService\Adapter\IndustriesArrayResponse;
use App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject\VacancyObject;
use App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject\VacancyPreviewObjectList;
use App\ParserBundle\Domain\Exception\AdapterServiceException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Query;
use Psr\Log\LoggerInterface;

class AdapterService
{
    public const PAGE_SIZE = 100;
    const URI = 'https://api.hh.ru/';
    const KEY = 'LC2RU9JKVQ1H5DFJVVB0RU6F789PMKG8PUL9N1UVPD2V6DG7JAB4766LB87GBAC8';

    private const REQUEST_OPTIONS_TYPES = [
        'GET' => 'query',
        'POST' => 'json'
    ];


    /** @var Client */
    private Client $client;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        private LoggerInterface $logger
    )
    {
        $this->client = new Client([
            'base_uri' => self::URI
        ]);
    }

    /**
     * @return IndustriesArrayResponse
     *
     * @throws AdapterServiceException
     */
    public function getIndustriesId(): IndustriesArrayResponse
    {
        $response = $this->sendRequest(
            'GET',
            'industries',
            [],
            IndustriesArrayResponse::class
        );
        return $response;
    }


    /**
     * @param string|null $region
     * @return int
     * @throws AdapterServiceException
     */
    public function getVacanciesPagesCount(string $region=null, array $option = []): int
    {
        $response = $this->getVacanciesByRegion($region, 1, $option);

        return $response->pages;
    }

    /**
     * @param int $page
     * @return VacancyPreviewObjectList
     *
     * @throws AdapterServiceException
     */
    public function getVacancies(int $page): VacancyPreviewObjectList
    {
        return $this->sendRequest(
            'GET',
            'vacancies',
            [
                'per_page' => self::PAGE_SIZE,
                'page' => $page-1
            ],
            VacancyPreviewObjectList::class
        );
    }

    /**
     * @param string $region
     * @param int $page
     * @param array $options
     *
     * @return VacancyPreviewObjectList
     *
     * @throws AdapterServiceException
     */
    public function getVacanciesByRegion(string $region, int $page, array $options = []): VacancyPreviewObjectList
    {
        $defaultOption = [
            'area' => $region,
            'per_page' => self::PAGE_SIZE,
            'page' => $page-1
        ];
        return $this->sendRequest(
            'GET',
            'vacancies',
            array_merge($defaultOption, $options),
            VacancyPreviewObjectList::class
        );
    }

    public function getVacancyById(int $id): VacancyObject
    {
        return $this->sendRequest(
            'GET',
            'vacancies/'.$id,
            [],
            VacancyObject::class
        );
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @param string $responseObject
     * @return mixed
     *
     * @throws AdapterServiceException
     */
    private function sendRequest(
        string $method,
        string $uri,
        array  $options,
        string $responseObject
    )
    {
        $key = self::KEY;

        $this->logger->debug(sprintf('HH_REQUEST_URI: %s', $uri));
        $this->logger->debug(sprintf('HH_REQUEST_OPTIONS: %s', print_r($options, true)));

        try {
            $response = $this->client->request(
                $method,
                $uri,
                [
                    'headers' => ['Authorization' => 'Bearer '.$key],
                    self::REQUEST_OPTIONS_TYPES[$method] => Query::build($options)
                ]
            );
        }
        catch (GuzzleException $exception) {
            throw new AdapterServiceException("HH ADAPTER SERVICE: REQUEST EXCEPTION:  ".$exception->getMessage(), $exception->getCode());
        }

        $body = $response->getBody()->getContents();
        $this->logger->debug(sprintf('HH_RESPONSE: %s', $response->getBody()->getContents()));

        try {
            return new $responseObject(json_decode($body, true));
        } catch (\Exception $e) {
            throw new AdapterServiceException("HH ADAPTER SERVICE: INVALID ARGUMENT EXCEPTION: ".$e->getMessage(), $e->getCode(), $e);
        }
    }
}