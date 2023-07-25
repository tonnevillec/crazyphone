<?php

namespace App\Controller\Admin;

use App\Entity\Promotions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PromotionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Promotions::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextEditorField::new('description'),
            ImageField::new('image')
                ->setHelp('La hauteur de l\'image doit être de 400 pixel')
                ->setUploadDir('public/uploads/')
                ->setBasePath('/uploads/'),
        ];
    }
}
