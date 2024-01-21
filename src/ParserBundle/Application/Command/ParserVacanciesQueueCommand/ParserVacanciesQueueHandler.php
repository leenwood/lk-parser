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
        ParserVacanciesQueueCommand $request
    ): void
    {
        dd("parsing");
        $query = new VacanciesParseQuery();
        $query->setRequestTime(time());
        $query->setSearchText($request->searchText);
        $query->setRegionId($request->regionId);
        $query->setAllRegion($request->allRegion);
        $query->setIndustries($request->industries);
        $query->setSearchFields($request->searchFields);
        $query->setReady(false);
        $query->setFailed(false);
        $query->setOnlyWithSalary($request->onlyWithSalary);
        $this->repository->save($query);
        $this->messageBus->dispatch(new ParserQueryMessage(
            $request->searchText,
            $request->regionId,
            $request->allRegion,
            $query
        ));
    }

}