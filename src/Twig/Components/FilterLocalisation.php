<?php

namespace App\Twig\Components;

use LogicException;
use App\DTO\SearchDto;
use App\Services\Localisator;
use App\Form\LocalisationType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\LiveArg;

#[AsLiveComponent()]
final class FilterLocalisation extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public ?SearchDto $searchDto = null;

    #[LiveProp(updateFromParent: true)]
    public int $results = 0;

    public array $cities = [];

    public function __construct(private Localisator $localisator)
    {
    }

    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(LocalisationType::class, $this->searchDto);
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
    public function selectCity(#[LiveArg()] string $city)
    {
       
        $this->formValues['address'] = $city;
        $this->cities = [];
        [$longitude, $latitude] = $this->localisator->getLocalisation($this->searchDto->address);
        $this->searchDto->latitude = $latitude;
        $this->searchDto->longitude = $longitude;
        $this->update();
        
    }

    #[LiveAction]
    public function searchCity()
    {
        try {
            $this->submitForm();

            /** @var SearchDto $searchDto */
            $this->searchDto = $this->getForm()->getData();
            $this->cities = $this->localisator->getCities($this->searchDto->address);
        } catch (LogicException $e) {
        }
    }

    #[LiveAction]
    public function save()
    {
        $this->submitForm();

        /** @var SearchDto $searchDto */
        $this->searchDto = $this->getForm()->getData();
        [$longitude, $latitude] = $this->localisator->getLocalisation($this->searchDto->address);
        $this->searchDto->latitude = $latitude;
        $this->searchDto->longitude = $longitude;

        return $this->redirectToRoute('app_home', $this->searchDto->generateQueryParameters());
    }
}
