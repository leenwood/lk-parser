<?php

namespace App\ParserBundle\Application\Command\ParserVacanciesQueueCommand;

use App\ParserBundle\Application\Queue\ParserQueryMessage;
use App\ParserBundle\Domain\Entity\VacanciesParseQuery;
use App\ParserBundle\Domain\Repository\VacanciesParseQueryRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ParserVacanciesQueueHandler
{


    public function __construct(
        private MessageBusInterface $messageBus,
        private VacanciesParseQueryRepositoryInterface $repository
    )
    {
    }

    public function __invoke(
        ParserVacanciesQueueCommand $command
    ): void
    {
        $query = new VacanciesParseQuery();
        $query->setRequestTime(time());
        $query->setSearchText($command->searchText);
        $query->setRegionId($command->regionId);
        $query->setAllRegion($command->allRegion);
        $query->setIndustries($command->industries);
        $query->setSearchFields($command->searchFields);
        $query->setReady(false);
        $query->setFailed(false);
        $query->setOnlyWithSalary($command->onlyWithSalary);
        $this->repository->save($query);
        $this->messageBus->dispatch(new ParserQueryMessage(
            $command->searchText,
            $command->regionId,
            $command->allRegion,
            $query
        ));
    }

}