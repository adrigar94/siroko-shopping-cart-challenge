<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Api\Cart;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/cart/items-count', name: 'GetCartItemsCountController', methods: ['GET'])]
class GetCartItemsCountController extends AbstractController
{
    public function __construct(private GetCartItemsCountService $getCartItemsCountService)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $userUuid = $this->getUserUuidFromRequest($request);

        $itemsCount = $this->getCartItemsCountService->__invoke($userUuid);

        return $this->json(['items_count' => $itemsCount], JsonResponse::HTTP_OK);
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