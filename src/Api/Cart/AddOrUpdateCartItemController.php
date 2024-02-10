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

        $cartItemDto = $this->mapRequestToDto($request);

        $this->addOrUpdateCartItemService->__invoke($userUuid, $cartItemDto);

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

    private function mapRequestToDto(Request $request): AddOrUpdateCartItemDto
    {
        $requestData = json_decode($request->getContent(), true);

        $requiredFields = ['sku', 'name', 'priceInCents', 'url', 'thumbnail', 'quantity'];
        foreach ($requiredFields as $field) {
            if (!isset($requestData[$field])) {
                throw new \InvalidArgumentException("$field is required");
            }
        }

        return new AddOrUpdateCartItemDto(
            $requestData['sku'],
            $requestData['name'],
            $requestData['priceInCents'],
            $requestData['url'],
            $requestData['thumbnail'],
            $requestData['quantity']
        );
    }
}