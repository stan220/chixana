<?php

namespace App\Controller;

use App\Repository\ChixApproveRepository;
use App\Repository\ChixRepository;
use App\Value\ChixBoard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /** @var ChixRepository */
    private $chixRepository;

    /** @var ChixApproveRepository */
    private $approveRepository;

    public function __construct(
        ChixRepository $chixRepository,
        ChixApproveRepository $approveRepository
    )
    {
        $this->chixRepository = $chixRepository;
        $this->approveRepository = $approveRepository;
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
        $board = new ChixBoard(\count($chixi));

        return $this->render('index/index.html.twig', compact('board', 'chixi', 'approves'));
    }
}
