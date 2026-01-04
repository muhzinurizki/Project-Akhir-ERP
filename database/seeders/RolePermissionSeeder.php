<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        DB::transaction(function () {

            /**
             * ======================================================
             * 1. DEFINISI PERMISSION
             * ======================================================
             */
            $permissions = [
                // Master
                'user.manage',
                'master.view',

                // Purchasing
                'purchase_request.create',
                'purchase_request.view',
                'purchase_request.approve',
                'purchase_order.create',
                'goods_receipt.create',

                // Inventory
                'inventory.view',
                'inventory.transfer',
                'inventory.approve_transfer',
                'inventory.stock_opname',

                // Production
                'work_order.create',
                'work_order.approve',
                'material_usage.create',
                'production_progress.create',

                // QC
                'qc.process',

                // Sales
                'quotation.create',
                'sales_order.approve',
                'delivery_order.create',
                'invoice.create',

                // Finance
                'ap.view',
                'ap.pay',
                'ar.view',
                'ar.receive',
            ];

            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'web',
                ]);
            }

            /**
             * ======================================================
             * 2. DEFINISI ROLE
             * ======================================================
             */
            $roles = [
                'Admin',
                'Manager',
                'Purchasing',
                'Warehouse',
                'Production',
                'QC',
                'Sales',
                'Finance',
            ];

            foreach ($roles as $role) {
                Role::firstOrCreate([
                    'name' => $role,
                    'guard_name' => 'web',
                ]);
            }

            /**
             * ======================================================
             * 3. ASSIGN PERMISSION KE ROLE (SYNC)
             * ======================================================
             */
            Role::findByName('Admin')->syncPermissions(Permission::all());

            Role::findByName('Manager')->syncPermissions([
                'purchase_request.approve',
                'inventory.approve_transfer',
                'work_order.approve',
                'sales_order.approve',
            ]);

            Role::findByName('Purchasing')->syncPermissions([
                'purchase_request.create',
                'purchase_request.view',
                'purchase_order.create',
            ]);

            Role::findByName('Warehouse')->syncPermissions([
                'inventory.view',
                'inventory.transfer',
                'inventory.stock_opname',
                'goods_receipt.create',
            ]);

            Role::findByName('Production')->syncPermissions([
                'work_order.create',
                'material_usage.create',
                'production_progress.create',
            ]);

            Role::findByName('QC')->syncPermissions([
                'qc.process',
            ]);

            Role::findByName('Sales')->syncPermissions([
                'quotation.create',
                'delivery_order.create',
                'invoice.create',
            ]);

            Role::findByName('Finance')->syncPermissions([
                'ap.view',
                'ap.pay',
                'ar.view',
                'ar.receive',
            ]);
        });
    }
}
