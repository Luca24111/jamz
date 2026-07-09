<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class EventCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Evento')
            ->setEntityLabelInPlural('Eventi');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield $this->makeOptional(TextField::new('title', 'Titolo'));
        yield $this->makeOptional(TextEditorField::new('description', 'Descrizione'));
        yield $this->makeOptional(TextEditorField::new('eventReport', 'Report evento'));
        yield $this->makeOptional(DateTimeField::new('createdAt', 'Creato il'));
        yield $this->makeOptional(DateTimeField::new('eventDate', 'Data evento'));
        yield $this->makeOptional(TextField::new('location', 'Luogo'));
        yield $this->makeOptional(TextField::new('coverImage', 'Immagine copertina'));
        yield $this->makeOptional(TextField::new('participationLink', 'Link partecipazione'));
        yield CollectionField::new('images', 'Immagini')->hideOnForm();
    }
}
