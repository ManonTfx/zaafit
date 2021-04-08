<?php

namespace App\Controller\Admin;

use App\Entity\Poids;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PoidsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Poids::class;
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
