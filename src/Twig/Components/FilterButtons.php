<?php

namespace App\Twig\Components;

use App\DTO\SearchDto;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent()]
final class FilterButtons
{
    use DefaultActionTrait;

    #[LiveProp(updateFromParent: true)]
    public ?SearchDto $searchDto = null;
}
