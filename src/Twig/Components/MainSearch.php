<?php

namespace App\Twig\Components;

use App\DTO\SearchDto;
use App\Form\MainSearchType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent()]
final class MainSearch extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?SearchDto $searchDto = null;

    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(MainSearchType::class, $this->searchDto);
    }


    #[LiveAction]
    public function save()
    {
        $this->submitForm();

        /** @var SearchDto $searchDto */
        $this->searchDto = $this->getForm()->getData();

        return $this->redirectToRoute('app_home', ['search' => $this->searchDto->search]);
    }
}
