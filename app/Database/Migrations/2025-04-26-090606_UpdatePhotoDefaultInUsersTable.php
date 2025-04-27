<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePhotoDefaultInUsersTable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('users', [
            'photo' => [
                'name'       => 'photo',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'default'    => 'assets/Profile_Photo/default.png',
            ],
        ]);
    }

    public function down()
    {
        // Optional: balik ke default sebelumnya jika dibutuhkan
        $this->forge->modifyColumn('users', [
            'photo' => [
                'name'       => 'photo',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'default'    => 'default.png',
            ],
        ]);
    }
}
