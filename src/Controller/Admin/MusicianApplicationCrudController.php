<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\MusicianApplication;
use App\Entity\MusicianApplicationStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class MusicianApplicationCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return MusicianApplication::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Candidatura musicista')
            ->setEntityLabelInPlural('Candidature musicisti');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield $this->makeOptional(TextField::new('firstName', 'Nome'));
        yield $this->makeOptional(TextField::new('lastName', 'Cognome'));
        yield $this->makeOptional(TextField::new('email', 'Email'));
        yield $this->makeOptional(TextField::new('telefono', 'Telefono'));
        yield $this->makeOptional(TextEditorField::new('projectDescription', 'Descrizione progetto'));
        yield $this->makeOptional(TextField::new('musicGenre', 'Genere musicale'));
        yield $this->makeOptional(TextField::new('materialLink', 'Link materiale'));
        yield $this->makeOptional(TextField::new('availability', 'Disponibilità'));
        yield $this->makeOptional(DateTimeField::new('requestedAt', 'Data richiesta'));
        yield $this->makeOptional(ChoiceField::new('stato', 'Stato')->setChoices($this->enumChoices(MusicianApplicationStatus::cases())));
    }
}
