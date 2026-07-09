<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\EventImage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class EventImageCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventImage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Immagine evento')
            ->setEntityLabelInPlural('Immagini evento');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield $this->makeOptional(AssociationField::new('event', 'Evento'));
        yield $this->makeOptional(TextField::new('url', 'URL immagine'));
        yield $this->makeOptional(TextField::new('altText', 'Alt text'));
        yield $this->makeOptional(IntegerField::new('displayOrder', 'Ordine'));
    }
}
