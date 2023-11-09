<?php

namespace App\Twig\Components;

use App\DTO\SearchDto;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent()]
final class FilterProducts
{
    use DefaultActionTrait;

    #[LiveProp]
    public ?SearchDto $searchDto = null;

    /**
     * @var Product[]
     */
    #[LiveProp]
    public ?array $products = [];

    #[LiveProp()]
    public int $results = 0;

    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function mount(SearchDto $searchDto)
    {
        $this->searchDto = $searchDto;
        $this->products = $this->productRepository->search($this->searchDto);
        $this->results = count($this->products);
    }

    #[LiveListener('updateProducts')]
    public function udpate(#[LiveArg()] string $searchDto)
    {
        $this->searchDto = unserialize($searchDto);
        $this->products = $this->productRepository->search($this->searchDto);
        $this->results = count($this->products);
        
    }
}
