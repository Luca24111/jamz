<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
        yield $this->makeOptional(
            ImageField::new('coverImage', 'Immagine copertina')
                ->setBasePath('assets/images/events/covers')
                ->setUploadDir('public/assets/images/events/covers')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
        );
        yield $this->makeOptional(TextField::new('participationLink', 'Link partecipazione'));
        yield CollectionField::new('images', 'Immagini')->hideOnForm();
    }
}
