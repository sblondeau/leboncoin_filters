<?php

namespace App\Twig\Components;

use App\DTO\SearchDto;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Services\DistanceCalculator;
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

    public function __construct(private ProductRepository $productRepository, private DistanceCalculator $distanceCalculator)
    {
    }

    public function mount(SearchDto $searchDto)
    {
        $this->searchDto = $searchDto;
        $this->searchProducts();
    }

    #[LiveListener('updateProducts')]
    public function udpate(#[LiveArg()] string $searchDto)
    {
        $this->searchDto = unserialize($searchDto);
        $this->searchProducts();
    }

    private function searchProducts(): void
    {
        $this->products = $this->productRepository->search($this->searchDto);
        if ($this->searchDto->getLatitude() && $this->searchDto->longitude) {
            $this->products = array_filter(
                $this->products,
                fn ($product) => $this->distanceCalculator->getDistance($this->searchDto, $product) <= $this->searchDto->radius
            );
        }

        
        $this->results = count($this->products);
    }
}
