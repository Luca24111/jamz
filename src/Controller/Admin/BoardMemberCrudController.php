<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\BoardMember;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class BoardMemberCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return BoardMember::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Membro consiglio')
            ->setEntityLabelInPlural('Membri consiglio');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield $this->makeOptional(TextField::new('firstName', 'Nome'));
        yield $this->makeOptional(TextField::new('lastName', 'Cognome'));
        yield $this->makeOptional(TextField::new('role', 'Ruolo'));
        yield $this->makeOptional(TextEditorField::new('bio', 'Bio'));
        yield $this->makeOptional(TextField::new('email', 'Email'));
        yield $this->makeOptional(TextField::new('photo', 'Foto'));
        yield $this->makeOptional(IntegerField::new('displayOrder', 'Ordine'));
    }
}
