<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Nova;

use CauriLand\Foundation\Fortify\Models\Permission as PermissionModel;
use CauriLand\Foundation\Fortify\Nova\Fields\RoleBooleanGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Vyuldashev\NovaPermission\Permission as VyuldashevPermissionResource;
use Vyuldashev\NovaPermission\RoleBooleanGroup as VyuldashevRoleBooleanGroup;

final class Permission extends VyuldashevPermissionResource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PermissionModel::class;

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        return $query->novaResources();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function fields(Request $request): array
    {
        $fields = parent::fields($request);

        $fieldIndex = collect($fields)
            ->filter(fn ($field) => get_class($field) === VyuldashevRoleBooleanGroup::class)
            ->keys()
            ->first();

        $fields[$fieldIndex] = RoleBooleanGroup::make(__('nova-permission-tool::permissions.roles'), 'roles');

        return $fields;
    }
}
