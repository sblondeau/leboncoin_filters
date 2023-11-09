<?php

namespace App\Twig\Components;

use App\DTO\SearchDto;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;

#[AsLiveComponent()]
final class ProductCards
{
    use DefaultActionTrait;

    /**
     * @var Product[]
     */
    #[LiveProp(updateFromParent:true)]
    public ?array $products = [];

    #[LiveProp(updateFromParent:true)]
    public int $results = 0;

}
