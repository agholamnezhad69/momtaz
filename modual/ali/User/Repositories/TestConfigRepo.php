<?php


namespace ali\User\Repositories;

use Alexusmai\LaravelFileManager\Services\ConfigService\ConfigRepository;
use Alexusmai\LaravelFileManager\Services\ConfigService\DefaultConfigRepository;
use ali\RolePermissions\Models\Permission;

class TestConfigRepo extends DefaultConfigRepository implements ConfigRepository
{

    public function getDiskList(): array
    {


        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN)) {

            return ['public_html', 'storage_private', 'storage_public', 'download_host'];

        } else if (auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)) {

            return ['public_html','storage_private'];
        }

        return [];


    }

}
