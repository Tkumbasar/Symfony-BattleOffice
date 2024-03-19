<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('lastname'),
            TextField::new('firstname'),
            TextField::new('adress'),
            TextField::new('adressSupp'),
            TextField::new('city'),
            IntegerField::new('cp'),
            TextField::new('country'),
            IntegerField::new('phone'),
            DateTimeField::new('createdAt'),
            DateTimeField::new('updateAt'),
            DateTimeField::new('deleteAt'),
            AssociationField::new('product'),
            AssociationField::new('deliveryLocations'),
          
        ];
    }
    
}
