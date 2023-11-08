<?php

namespace App\Twig\Components;

use App\DTO\SearchDto;
use App\Repository\ProductRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
final class ProductCards
{
    use DefaultActionTrait;

    public ?SearchDto $searchDto = null;

    public function __construct(private ProductRepository $productRepository)
    {

    }

    public function getProducts()
    {
        return $this->productRepository->search($this->searchDto);
    }
}
