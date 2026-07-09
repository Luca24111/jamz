<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

abstract class BaseCrudController extends AbstractCrudController
{
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(25)
            ->showEntityActionsInlined(true);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, static fn (Action $action): Action => $action->setLabel('Crea'))
            ->update(Crud::PAGE_INDEX, Action::EDIT, static fn (Action $action): Action => $action->setLabel('Modifica'))
            ->update(Crud::PAGE_INDEX, Action::DELETE, static fn (Action $action): Action => $action->setLabel('Elimina'));
    }

    protected function makeOptional(object $field): object
    {
        if (method_exists($field, 'setRequired')) {
            $field->setRequired(false);
        }

        if (method_exists($field, 'setFormTypeOption')) {
            $field->setFormTypeOption('required', false);
        }

        return $field;
    }

    /**
     * @param list<\BackedEnum> $cases
     * @return array<string, \BackedEnum>
     */
    protected function enumChoices(array $cases): array
    {
        $choices = [];

        foreach ($cases as $case) {
            $choices[ucwords(str_replace('_', ' ', $case->value))] = $case;
        }

        return $choices;
    }
}
