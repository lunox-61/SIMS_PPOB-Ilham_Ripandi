<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBannersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'banner_name'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'banner_image'   => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'description'    => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at'     => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at'     => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('banners');
    }

    public function down()
    {
        $this->forge->dropTable('banners');
    }
}
