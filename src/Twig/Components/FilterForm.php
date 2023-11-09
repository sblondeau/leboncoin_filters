<?php

namespace App\Twig\Components;

use App\DTO\SearchDto;
use App\Form\FilterType;
use LogicException;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent()]
final class FilterForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public ?SearchDto $searchDto = null;

    #[LiveProp]
    public bool $visible = false;

    #[LiveProp(updateFromParent:true)]
    public int $results = 0;

    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(FilterType::class, $this->searchDto);
    }

    #[LiveAction]
    public function reset()
    {
       $this->searchDto->minPrice = null; 
       $this->searchDto->maxPrice = null; 
       $this->searchDto->isUrgent = false; 

       $this->resetForm();
    }
       
    #[LiveAction]
    public function update()
    {
        try {
            $this->submitForm();

            /** @var SearchDto $searchDto */
            $this->searchDto = $this->getForm()->getData();
            $this->emit('updateProducts', ['searchDto' => serialize($this->searchDto)]);
        } catch (LogicException $e) {
        }
    }

    private function getDataModelValue(): ?string
    {
        return '';
    }

    #[LiveAction]
    public function save()
    {
        $this->submitForm();

        /** @var SearchDto $searchDto */
        $this->searchDto = $this->getForm()->getData();

        return $this->redirectToRoute('app_home', $this->searchDto->generateQueryParameters());
    }

    #[LiveListener('showFilter')]
    public function toggleVisible()
    {
        $this->visible = !$this->visible;
    }
}
