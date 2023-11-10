<?php

namespace App\Twig\Components;

use App\DTO\SearchDto;
use App\Form\LocalisationType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent()]
final class FilterLocalisation extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    
    #[LiveProp]
    public ?SearchDto $searchDto = null;

    #[LiveProp(updateFromParent:true)]
    public int $results = 0;

    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(LocalisationType::class, $this->searchDto);
    }
}
