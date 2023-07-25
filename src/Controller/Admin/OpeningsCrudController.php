<?php

namespace App\Controller\Admin;

use App\Entity\Openings;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OpeningsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Openings::class;
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
