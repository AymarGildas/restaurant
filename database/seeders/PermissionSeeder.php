<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Role Management
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            // User Management
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
              // User Management
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',


            // Menu Management
            'menu-list',
            'menu-create',
            'menu-edit',
            'menu-delete',

            // plat (menus) Management
            'plat-list',
            'plat-create',
            'plat-edit',
            'plat-delete',

            // types Management
            'type-list',
            'type-create',
            'type-edit',
            'type-delete',

             // cart Management
            'cart-list',
            'cart-create',
            'cart-edit',
            'cart-delete',

             // checkout Management
            'checkout-list',
            'checkout-create',
            'checkout-edit',
            'checkout-delete',

            // Order Management
            'order-list',
            'order-create',
            'order-edit',
            'order-delete',
            'update-order-status',

             // Order Management
            'customer-order-list',
            'customer-order-create',
            'customer-order-edit',
            'customer-order-delete',
            'customer-update-order-status',

            

            // Checkout / Payment Management
            'checkout-list',
            'checkout-create',

            // Dashboard
            'access-dashboard',

            // Site Settings
            'site-settings-access',
            'site-settings-edit',
            'map-view'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'sanctum']
            );
        }
    }
}
