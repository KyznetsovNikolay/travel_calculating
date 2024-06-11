<?php

namespace App\Controller;

use App\Dto\Travel\CalculateDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\UseCase\Travel\Calculate as CalculateHandler;

#[Route(path: '/travel')]
class TravelController extends AbstractController
{
    #[Route(path: '/calculate', methods: ['POST'])]
    public function calculate(#[MapRequestPayload] CalculateDto $dto, CalculateHandler $handler): Response
    {
        $discount = $handler->handle($dto);
        return $this->json($discount);
    }
}
