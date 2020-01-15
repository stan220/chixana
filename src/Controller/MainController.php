<?php

namespace App\Controller;

use App\Repository\ChixApproveRepository;
use App\Repository\ChixRepository;
use App\Service\BoardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /** @var ChixRepository */
    private $chixRepository;

    /** @var ChixApproveRepository */
    private $approveRepository;

    /** @var BoardService */
    private $boardService;

    public function __construct(
        BoardService $boardService,
        ChixRepository $chixRepository,
        ChixApproveRepository $approveRepository
    ) {
        $this->chixRepository = $chixRepository;
        $this->approveRepository = $approveRepository;
        $this->boardService = $boardService;
    }

    /**
     * @Route("/")
     * @return Response
     * @throws \Exception
     */
    public function index(): Response
    {
        $chixi = $this->chixRepository->findAllForToday();
        $approves = $this->approveRepository->findLast();
        $weekBoard = $this->boardService->getWeek();

        return $this->render('index/index.html.twig', compact('weekBoard', 'chixi', 'approves'));
    }
}
