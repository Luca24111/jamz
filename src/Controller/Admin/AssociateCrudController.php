<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Associate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class AssociateCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Associate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Associato')
            ->setEntityLabelInPlural('Associati');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield $this->makeOptional(TextField::new('firstName', 'Nome'));
        yield $this->makeOptional(TextField::new('lastName', 'Cognome'));
        yield $this->makeOptional(TextField::new('membershipNumber', 'Numero tessera'));
        yield $this->makeOptional(DateField::new('joinDate', 'Data iscrizione'));
        yield $this->makeOptional(TextField::new('city', 'Città'));
        yield $this->makeOptional(TextField::new('instrument', 'Strumento'));
        yield $this->makeOptional(TextEditorField::new('shortBio', 'Bio breve'));
        yield $this->makeOptional(TextField::new('email', 'Email'));
        yield $this->makeOptional(BooleanField::new('visibleInRegistry', 'Visibile in albo'));
    }
}
