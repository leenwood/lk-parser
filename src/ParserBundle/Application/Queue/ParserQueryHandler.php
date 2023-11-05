<?php

namespace App\ParserBundle\Application\Queue;

use App\ParserBundle\Domain\DTO\ParserService\Adapter\RegionIdObject;
use App\ParserBundle\Domain\Entity\VacanciesParseQuery;
use App\ParserBundle\Domain\Service\ParserService\ParserService;
use App\ParserBundle\Infrastructure\Repository\VacanciesParseQueryRepository;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class ParserQueryHandler
{
    /**
     * @param ParserService $parserService
     * @param VacanciesParseQueryRepository $queryRepository
     * @param LoggerInterface $logger
     * @param MessageBusInterface $messageBus
     */
    public function __construct(
        private ParserService                 $parserService,
        private VacanciesParseQueryRepository $queryRepository,
        private LoggerInterface               $logger,
        private MessageBusInterface           $messageBus
    )
    {
    }


    /**
     * @param ParserQueryMessage $query
     * @return void
     * @throws GuzzleException
     */
    public function __invoke(
        ParserQueryMessage $query
    )
    {
        $this->logger->info("CONSUMER PARSER | START PARSING | TEXT: " . $query->getSearchText() . " REGION_ID: " . $query->getRegionId());
        $parseQuery = $this->queryRepository->findOneBy(['id' => $query->getQuery()->getId()]);
        try {
            if ($query->isAllRegion()) {
                if ($query->isSplit()) {
                    $this->parserService->parseVacancies(
                        $query->getSearchText(),
                        $query->getRegionId(),
                        'public/ParserOutput/',
                        $parseQuery->getRequestTime(),
                        $this->prepareRequestOption($parseQuery)
                    );

                    if ($query->getRegionId() === RegionIdObject::$LAST_REGION) {
                        $parseQuery->setReady(true);
                        $this->queryRepository->save($parseQuery);
                        $this->logger->info("CONSUMER PARSER | CHECK ALL REGION IS END | TEXT: " . $query->getSearchText() . " REQUEST TIME " . $parseQuery->getRequestTime());
                    }
                } else {
                    $this->logger->info("CONSUMER PARSER | CHECK ALL REGION | TEXT: " . $query->getSearchText() . " REQUEST TIME " . $parseQuery->getRequestTime());
                    foreach (RegionIdObject::$REGION_ID as $key => $regionId) {
                        $this->messageBus->dispatch(
                            new ParserQueryMessage(
                                $query->getSearchText(),
                                $regionId,
                                $query->isAllRegion(),
                                $parseQuery,
                                true
                            )
                        );
                    }
                }

            } else {
                $this->parserService->parseVacancies(
                    $query->getSearchText(),
                    $query->getRegionId(),
                    'public/ParserOutput/',
                    $parseQuery->getRequestTime(),
                    $this->prepareRequestOption($parseQuery)
                );
                $this->logger->info("CONSUMER PARSER | END PARSING | TEXT: " . $query->getSearchText() . " REGION_ID: " . $query->getRegionId());
                $parseQuery->setReady(true);
                $this->queryRepository->save($parseQuery);
            }

        } catch (\Exception $e) {
            $parseQuery->setFailed(true);
            $this->queryRepository->save($parseQuery);
            $this->logger->error("CONSUMER PARSER | ERROR PARSING | TEXT: " . $query->getSearchText() . " REGION_ID: " . $query->getRegionId() . "\n\n\n" . $e);
        }

    }

    private function prepareRequestOption(VacanciesParseQuery $query): array
    {
        $option = [];
        if ($query->getIndustries()) {
            foreach ($query->getIndustries() as $item) {
                $option['industry'][] = $item;

            }
        }

        if ($query->getSearchFields()) {
            foreach ($query->getSearchFields() as $field) {
                $option['vacancy_search_fields'][] = $field;
            }
        }

        if ($query->getOnlyWithSalary()) {
            $option['only_with_salary'] = $query->getOnlyWithSalary();
        }

        return $option;
    }
}