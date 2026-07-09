<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\AdminUser;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AdminUserCrudController extends BaseCrudController
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public static function getEntityFqcn(): string
    {
        return AdminUser::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Utente admin')
            ->setEntityLabelInPlural('Utenti admin');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield $this->makeOptional(TextField::new('email', 'Email'));
        yield $this->makeOptional(
            ChoiceField::new('roles', 'Ruoli')
                ->allowMultipleChoices()
                ->setChoices([
                    'Admin' => 'ROLE_ADMIN',
                ])
        );
        yield $this->makeOptional(
            TextField::new('plainPassword', 'Password')
                ->setFormTypeOption('mapped', true)
                ->onlyOnForms()
        );
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof AdminUser) {
            $this->hashPasswordIfProvided($entityInstance);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof AdminUser) {
            $this->hashPasswordIfProvided($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function hashPasswordIfProvided(AdminUser $user): void
    {
        $plainPassword = $user->getPlainPassword();

        if ($plainPassword === null || trim($plainPassword) === '') {
            return;
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
        $user->setPlainPassword(null);
    }
}
