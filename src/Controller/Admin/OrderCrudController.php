<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }
    // Affichage des commandes de manière descendantes 
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        
            ->add('index', 'detail');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createAt', 'Passée le'),
            TextField::new('user.getFullname', 'Utilisateur'),
            MoneyField::new('total', 'Total produits')->setCurrency('EUR'),
            TextField::new('carrierNAme', 'Transport'),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),
            BooleanField::new('isPaid', 'Payée'),
            ArrayField::new('orderDetails', 'Produits Achetés')
        ];
    }
}
