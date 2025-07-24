<?php

namespace App\Providers;

use App\Models\Admin\SiteSetting;
use App\Models\Admin\User; // Use the correct User model namespace, typically App\Models\User
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        try {
            // Check DB connection before proceeding to avoid errors during initial setup
            DB::connection()->getPdo();

            // Only run the setup logic if the database has been migrated
            if (Schema::hasTable('migrations')) {

                // 1. Seed permissions if the table is empty
                if (Permission::count() === 0) {
                    Artisan::call('db:seed', ['--class' => 'PermissionSeeder', '--force' => true]);
                    logger()->info('✅ Permissions seeded.');
                }

                // 2. Create roles if they don't exist
                $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'sanctum']);
                $adminRole      = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'sanctum']);
                $customerRole   = Role::firstOrCreate(['name' => 'Customer', 'guard_name' => 'sanctum']);
                
                // 3. Assign permissions to roles as specified
                $superAdminRole->syncPermissions(Permission::all());

                $adminPermissions = Permission::whereNotIn('name', [
                    'role-list', 'role-create', 'role-edit', 'role-delete',  'customer-order-list',
            'customer-order-create',
            'customer-order-edit',
            'customer-order-delete','user-list',
            'user-create',
            'user-edit',
            'user-delete',
                ])->get();
                $adminRole->syncPermissions($adminPermissions);
                
                $customerPermissions = Permission::whereNotIn('name', [
                    'role-list', 'role-create', 'role-edit', 'role-delete',
                    'user-list', 'user-create', 'user-edit', 'user-delete',
                    'order-list', 'menu-create', 'menu-edit', 'menu-delete',
                    'plat-list', 'order-delete', 'site-settings-access',
                    'site-settings-edit', 'type-list', 'type-create',
                    'type-edit', 'type-delete','client-list',
            'client-create',
            'client-edit',
            'client-delete','order-list',
            'order-create',
            'order-edit',
            'order-delete',
            'update-order-status',
                ])->get();
                $customerRole->syncPermissions($customerPermissions);

                // 4. Create default users if none exist
                if (User::count() === 0) {
                    $superAdmin = User::create([
                        'name' => 'Super Admin',
                        'email' => 'nuetagdiegildas@gmail.com',
                        'password' => Hash::make('Machebou2025')
                    ]);
                    $superAdmin->assignRole('Super Admin');

                    $admin = User::create([
                        'name' => 'Admin',
                        'email' => 'admin@gmail.com',
                        'password' => Hash::make('Admin2025')
                    ]);
                    $admin->assignRole('Admin');
                }

                // 5. Ensure default site settings exist with all footer data
                if (!SiteSetting::first()) {
                    SiteSetting::create([
                        'site_name'           => 'FoodExpress',
                        'primary_color'        => '#4F46E5',
                        'secondary_color'      => '#FF6B6B',
                        'contact_email'        => 'contact@foodexpress.com',
                        'phone_number'         => '(123) 456-7890',
                        'footer_address'       => '123 Food Street, Cityville',
                        'footer_about_text'    => 'Your favorite meals, delivered fast and fresh right to your door. Quality ingredients, unforgettable taste.',
                        'social_facebook_url'  => '#',
                        'social_instagram_url' => '#',
                        'social_twitter_url'   => '#',
                    ]);
                    logger()->info('🎨 Default site settings created.');
                }

                // 6. Share the settings object with all views
                View::share('settings', SiteSetting::first());
            }

        } catch (\Exception $e) {
            // Log any errors that occur during the auto-setup process
            logger()->error('🚨 Auto-setup failed: ' . $e->getMessage());
        }
    }
}