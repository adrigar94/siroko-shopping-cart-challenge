<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Api\Cart;

use Adrian\SirokoShoppingCart\ShoppingCart\Application\Get\GetOpenCartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/cart', name: 'GetOpenCartController', methods: ['GET'])]
class GetOpenCartController extends AbstractController
{
    public function __construct(private GetOpenCartService $getOpenCart)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $userUuid = $this->getUserUuidFromRequest($request);

        $cart = $this->getOpenCart->__invoke($userUuid);

        return $this->json($cart->toNative(), JsonResponse::HTTP_OK);
    }

    private function getUserUuidFromRequest(Request $request): string
    {
        $requestData = json_decode($request->getContent(), true);
        if (!isset($requestData['user_uuid'])) {
            throw new \InvalidArgumentException('User uuid is required');
        }
        return $requestData['user_uuid'];
    }
}