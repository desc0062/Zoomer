<?php

namespace App\Controller\Admin;

use App\Entity\Ticket;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\EntityRepository;

class TicketCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ticket::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('status'),
            DateField::new('creationDate'),
            AssociationField::new('userConcerned')
                ->formatValue(function ($value, $entity) {
                    return $entity->getUserConcerned()?->getLastName();
                })
                ->setFormTypeOptions([
                    'choice_label' => 'lastName',
                    'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('u')
                ->where('u.roles LIKE :roles')
                ->setParameter('roles', '%ROLE_USER%')
                ->orderBy('u.lastName', 'ASC');
        },
    ]),
            AssociationField::new('adminConcerned')
            ->formatValue(function ($value, $entity) {
                return $entity->getAdminConcerned()?->getLastName();
            })
            ->setFormTypeOptions([
                'choice_label' => 'lastName',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('a')
                        ->where('a.roles LIKE :roles')
                        ->setParameter('roles', '%ROLE_ADMIN%')
                        ->orderBy('a.lastName', 'ASC');
                },
            ]),
        ];
    }
    
}
