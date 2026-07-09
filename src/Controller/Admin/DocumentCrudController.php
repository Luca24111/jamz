<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Document;
use App\Entity\DocumentType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class DocumentCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Document::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Documento')
            ->setEntityLabelInPlural('Documenti');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield $this->makeOptional(ChoiceField::new('tipo', 'Tipo')->setChoices($this->enumChoices(DocumentType::cases())));
        yield $this->makeOptional(TextField::new('title', 'Titolo'));
        yield $this->makeOptional(TextField::new('fileName', 'Nome file'));
        yield $this->makeOptional(TextField::new('path', 'Path'));
        yield $this->makeOptional(DateField::new('uploadedAt', 'Data caricamento'));
    }
}
