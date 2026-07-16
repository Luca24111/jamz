<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Document;
use App\Entity\DocumentType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Validator\Constraints\File;

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
        $documentUploadField = Field::new('path', 'File')
            ->setFormType(FileUploadType::class)
            ->setFormTypeOptions([
                'upload_dir' => 'public/assets/documents',
                'upload_filename' => '[slug]-[timestamp].[extension]',
                'download_path' => 'assets/documents',
                'file_constraints' => [
                    new File([
                        'maxSize' => '64M',
                    ]),
                ],
                'attr' => [
                    'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip',
                ],
            ])
            ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-file-upload.js'))
            ->onlyOnForms();

        yield IdField::new('id')->hideOnForm();
        yield $this->makeOptional(ChoiceField::new('tipo', 'Tipo')->setChoices($this->enumChoices(DocumentType::cases())));
        yield $this->makeOptional(TextField::new('title', 'Titolo'));
        yield $this->makeOptional(TextField::new('fileName', 'Nome file'));
        yield TextField::new('publicPath', 'Percorso file')->hideOnForm();
        yield $this->makeOptional($documentUploadField);
        yield $this->makeOptional(DateField::new('uploadedAt', 'Data caricamento'));
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Document) {
            $this->normalizeDocumentMetadata($entityInstance);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Document) {
            $this->normalizeDocumentMetadata($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function normalizeDocumentMetadata(Document $document): void
    {
        $path = '';
        $fileName = '';

        try {
            $path = trim($document->getPath());
        } catch (\Error) {
            $path = '';
        }

        try {
            $fileName = trim($document->getFileName());
        } catch (\Error) {
            $fileName = '';
        }

        if ($path !== '' && $fileName === '') {
            $document->setFileName(basename($path));
        }

        try {
            $document->getUploadedAt();
        } catch (\Error) {
            $document->setUploadedAt(new \DateTimeImmutable('today'));
        }
    }
}
