<?php

namespace App\Controller\Admin;

use App\Entity\ContactInformations;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactInformationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContactInformations::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
