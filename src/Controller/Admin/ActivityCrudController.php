<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ActivityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activity::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')->setLabel('Activité'),
            DateTimeField::new('date'),
            NumberField::new('nbOfPlaces')->setLabel('Nombre de places'),
            AssociationField::new('animal')->formatValue(function ($value, $entity) {return $entity->getAnimal()?->getName(); })->formatValue(function ($value, $entity) {return $entity->getAnimal()?->getName(); })->setFormTypeOptions(['choice_label' => 'name', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            }, ]),
            TextField::new('description'),
            TextField::new('imageActFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageAct')->onlyOnIndex()->setBasePath('/uploads/activities'),
        ];
    }
}
