<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Api\Cart;

use Adrian\SirokoShoppingCart\ShoppingCart\Application\AddOrUpdate\AddOrUpdateCartItemDto;
use Adrian\SirokoShoppingCart\ShoppingCart\Application\AddOrUpdate\AddOrUpdateCartItemService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/cart/items/{sku}', name: 'AddOrUpdateCartItemController', methods: ['PUT'])]
class AddOrUpdateCartItemController extends AbstractController
{

    public function __construct(private AddOrUpdateCartItemService $addOrUpdateCartItemService)
    {
    }

    public function __invoke(Request $request, string $sku): JsonResponse
    {
        $userUuid = $this->getUserUuidFromRequest($request);

        $cartItemDto = $this->mapRequestToDto($request, $sku);

        $this->addOrUpdateCartItemService->__invoke($userUuid, $cartItemDto);

        return $this->json([], JsonResponse::HTTP_NO_CONTENT);
    }

    private function getUserUuidFromRequest(Request $request): string
    {
        $requestData = json_decode($request->getContent(), true);
        if (!isset($requestData['user_uuid'])) {
            throw new \InvalidArgumentException('User uuid is required');
        }
        return $requestData['user_uuid'];
    }

    private function mapRequestToDto(Request $request, $sku): AddOrUpdateCartItemDto
    {
        $requestData = json_decode($request->getContent(), true);

        $requiredFields = ['name', 'priceInCents', 'url', 'thumbnail', 'quantity'];
        foreach ($requiredFields as $field) {
            if (!isset($requestData[$field])) {
                throw new \InvalidArgumentException("$field is required");
            }
        }

        return new AddOrUpdateCartItemDto(
            $sku,
            $requestData['name'],
            $requestData['priceInCents'],
            $requestData['url'],
            $requestData['thumbnail'],
            $requestData['quantity']
        );
    }
}