<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\EventImage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Validator\Constraints\File;

final class EventImageCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventImage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Media evento')
            ->setEntityLabelInPlural('Media evento');
    }

    public function configureFields(string $pageName): iterable
    {
        $mediaUploadField = Field::new('url', 'Media')
            ->setFormType(FileUploadType::class)
            ->setFormTypeOptions([
                'upload_dir' => 'public/assets/images/events/gallery',
                'upload_filename' => '[slug]-[timestamp].[extension]',
                'download_path' => 'assets/images/events/gallery',
                'file_constraints' => [
                    new File([
                        'maxSize' => '256M',
                        'extensions' => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif', 'mp4', 'webm', 'mov', 'm4v', 'ogg'],
                    ]),
                ],
                'attr' => [
                    'accept' => 'image/*,video/*',
                ],
            ])
            ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-file-upload.js'))
            ->onlyOnForms();

        yield IdField::new('id')->hideOnForm();
        yield $this->makeOptional(AssociationField::new('event', 'Evento'));
        yield TextField::new('publicPath', 'File')->hideOnForm();
        yield $this->makeOptional($mediaUploadField);
        yield $this->makeOptional(TextField::new('altText', 'Alt text'));
        yield $this->makeOptional(IntegerField::new('displayOrder', 'Ordine'));
    }
}
