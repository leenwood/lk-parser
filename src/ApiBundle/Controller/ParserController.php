<?php

namespace App\ApiBundle\Controller;

use App\ApiBundle\RequestObject\BaseParseRequestObject;
use App\ParserBundle\Application\Command\ParserVacanciesQueueCommand\ParserVacanciesQueueCommand;
use App\ParserBundle\Application\Command\ParserVacanciesQueueCommand\ParserVacanciesQueueHandler;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParserController extends AbstractFOSRestController
{
    public function __construct(
        private LoggerInterface $logger
    )
    {
    }


    /**
     *
     * @ParamConverter("requestObject", class="App\ApiBundle\RequestObject", converter="fos_rest.request_body")
     *
     * @param Request $request
     * @param ParserVacanciesQueueHandler $parserVacanciesQueueHandler
     * @param BaseParseRequestObject $requestObject
     * @return Response
     */
    #[Post(path: '/api/parse/start', name: 'Base Parsing')]
    public function startParseVacancies(
        Request $request,
        ParserVacanciesQueueHandler $parserVacanciesQueueHandler,
        BaseParseRequestObject $requestObject
    ): Response
    {
        try {
            ($parserVacanciesQueueHandler)(new ParserVacanciesQueueCommand([
                'searchText' => $request->request->getString('searchText'),
                'regionId' => $request->request->getInt('regionId'),
                'allRegion' => $request->request->getBoolean('allRegion'),
                'searchFields' => json_decode($request->request->getString('searchField'), true),
                'industries' => json_decode($request->request->getString('industries'), true)
            ]));
        } catch (\Throwable $e) {
            $this->logger->error(sprintf("BaseParsingRequest-error | Request parameters: %s | Error text: %s",
                json_encode([
                    'searchText' => $request->request->getString('searchText'),
                    'regionId' => $request->request->getInt('regionId'),
                    'allRegion' => $request->request->getBoolean('allRegion'),
                    'searchFields' => json_decode($request->request->getString('searchField'), true),
                    'industries' => json_decode($request->request->getString('industries'), true)
                ]),
                $e
            ));
            dd($e);
        }

        return $this->handleView($this->view('ok'));
    }

    #[Route('/api/test', name: 'test_server', methods: 'GET')]
    public function apiTest()
    {
        return new JsonResponse(['status' => Response::HTTP_OK]);
    }

    #[Route('/api/test_view', name: 'test', methods: 'GET')]
    public function test(
    ): Response
    {
        return $this->render('agreeable_puppy/index.html.twig', [
            'controller_name' => 'AgreeablePuppyController',
        ]);
    }
}