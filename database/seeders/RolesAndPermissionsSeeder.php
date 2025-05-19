<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Matikan foreign key check sementara supaya bisa truncate tabel dengan FK
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Bersihkan tabel yang terkait role & permission
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        Role::truncate();
        Permission::truncate();

        // Hidupkan lagi foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Buat role
        $admin = Role::create(['name' => 'admin']);
        $author = Role::create(['name' => 'author']);
        $editor = Role::create(['name' => 'editor']);
        $user = Role::create(['name' => 'user']);

        // Daftar permission
        $permissions = [
            'tulis artikel',
            'edit artikel',
            'hapus artikel',
            'publish artikel',
            'komentar',
            'hapus komentar',
            'like',
            'manage users',
            'akses dashboard',
        ];

        // Buat permission
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permission ke role
        $author->givePermissionTo(['tulis artikel', 'edit artikel', 'komentar', 'like']);
        $editor->givePermissionTo(['edit artikel', 'hapus komentar', 'publish artikel', 'akses dashboard']);
        $admin->givePermissionTo(Permission::all());
        $user->givePermissionTo(['komentar', 'like']);
    }
}
