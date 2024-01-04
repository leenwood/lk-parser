<?php

namespace App\ApiBundle\Controller;

use App\ParserBundle\Application\Queue\ParserQueryMessage;
use App\ParserBundle\Domain\Entity\VacanciesParseQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ParserController extends AbstractController
{
    #[Route('/api/parse/region', name: 'simple request', methods: 'POST')]
    public function index(
        Request $request,
        MessageBusInterface $messageBus
    ): Response
    {
        $form = $request->getPayload()->all();

        $query = new VacanciesParseQuery();
        $query->setRequestTime(time());
        $query->setSearchText($form['searchText']);
        $query->setRegionId($form['regionId']);
        $query->setAllRegion($form['allRegion']);
        $query->setSearchFields($form['search_field']);
        $query->setReady(false);
        $query->setFailed(false);
        $query->setOnlyWithSalary($form['onlyWithSalary']);
        $messageBus->dispatch(new ParserQueryMessage(
            $form['searchText'],
            $form['regionId'],
            $form['allRegion'],
            $query
        ));

        return new JsonResponse(
            ['status'=> Response::HTTP_OK]
        );
    }

    #[Route('/api/test', name: 'test', methods: 'GET')]
    public function test(
    ): Response
    {
        return $this->render('agreeable_puppy/index.html.twig', [
            'controller_name' => 'AgreeablePuppyController',
        ]);
    }
}