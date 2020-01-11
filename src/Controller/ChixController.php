<?php

namespace App\Controller;

use App\Service\ChixService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chix", name="chix_")
 */
class ChixController extends AbstractController
{
    /**
     * @var ChixService
     */
    private $chixService;

    public function __construct(ChixService $chixService)
    {
        $this->chixService = $chixService;
    }

    /**
     * @Route("/{chixId}", requirements={"chixId"="\d+"})
     * @param Request $request
     * @return Response
     * @throws EntityNotFoundException
     */
    public function view(Request $request): Response
    {
        $chixId = $this->getChixId($request);
        $user = $this->getUser();

        $result = $this->chixService->get($chixId, $user);

        return $this->render('chix/view.html.twig', $result);
    }

    /**
     * @Route("/add")
     * @return Response
     */
    public function add(): Response
    {
        $user = $this->getUser();

        $chixId = $this->chixService->add($user);

        return $this->redirectToRoute('chix_app_chix_view', compact('chixId'));

    }

    /**
     * @Route("/{chixId}/approve", requirements={"chixId"="\d+"})
     * @param Request $request
     * @return Response
     * @throws EntityNotFoundException
     */
    public function approve(Request $request): Response
    {
        $chixId = $this->getChixId($request);
        $user = $this->getUser();

        $this->chixService->approve($chixId, $user);

        return $this->redirectToRoute('chix_app_chix_view', compact('chixId'));
    }

    /**
     * @param Request $request
     * @return int
     */
    private function getChixId(Request $request): int
    {
        $chixId = (int) $request->get('chixId');

        if ($chixId < 1) {
            throw new \InvalidArgumentException("Chix not found: $chixId");
        }

        return $chixId;
    }
}
