<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Api\Cart;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/cart/items/{sku}', name: 'DeleteCartItemController', methods: ['DELETE'])]
class DeleteCartItemController extends AbstractController
{
    public function __construct(private DeleteCartItemService $deleteCartItemService)
    {
    }

    public function __invoke(Request $request, string $sku): JsonResponse
    {
        $userUuid = $this->getUserUuidFromRequest($request);

        $this->deleteCartItemService->__invoke($userUuid, $sku);

        return $this->json([], JsonResponse::HTTP_NO_CONTENT);
    }

    private function getUserUuidFromRequest(Request $request): string
    {
        $uuid = $request->request->get('user_uuid');
        if (empty($uuid)) {
            throw new \InvalidArgumentException('User uuid is required');
        }
        return $uuid;
    }
}