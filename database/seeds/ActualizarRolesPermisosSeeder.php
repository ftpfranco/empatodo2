<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ActualizarRolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = Role::where("name", "administrador")->first();
        $permissions =  Permission::all();
        $admin->syncPermissions($permissions);

        $perm = Permission::whereIn("id",[  
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            98,
            53,
            54,
            55,
            56,
            57,
            58,
            59,
            60,
            89,
            90,
            35,
            36,
            37,
            38,
            40,
            41,
            42,
            43,
            99,
            71,
            72
        ])->get();

        $vend = Role::where("name", "vendedor")->first();
        $vend->syncPermissions($perm);

        
    }
}
