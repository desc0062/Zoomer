<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class BookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('activity')->setLabel('Activité')->formatValue(function ($value, $entity) {return $entity->getActivity()?->getName(); })->setFormTypeOptions(['choice_label' => 'name', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            }, ]),
            AssociationField::new('user')->setLabel('Prénom')->formatValue(function ($value, $entity) {return $entity->getUser()?->getFirstName(); })->setFormTypeOptions(['choice_label' => 'firstName', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')
                    ->orderBy('c.firstName', 'ASC');
            }, ]),
        ];
    }
}
