<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AnimalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animal::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('description'),
            NumberField::new('poids'),
            NumberField::new('taille'),
            TextField::new('habitat'),
            NumberField::new('esperance_vie'),
            TextField::new('espece'),
            TextField::new('imageAniFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageAni')->onlyOnIndex()->setBasePath('/uploads/animals'),
        ];
    }
}
