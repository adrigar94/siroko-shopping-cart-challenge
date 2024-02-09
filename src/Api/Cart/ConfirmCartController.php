<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Api\Cart;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/cart/confirm', name: 'ConfirmCartController', methods: ['POST'])]
class ConfirmCartController extends AbstractController
{
    public function __construct(private ConfirmCartService $confirmCartService)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $userUuid = $this->getUserUuidFromRequest($request);

        $this->confirmCartService->__invoke($userUuid);

        return $this->json([], JsonResponse::HTTP_OK);
    }

    private function getUserUuidFromRequest(Request $request): string
    {
        $userUuid = $request->request->get('user_uuid');
        if (empty($userUuid)) {
            throw new \InvalidArgumentException('User uuid is required');
        }
        return $userUuid;
    }
}