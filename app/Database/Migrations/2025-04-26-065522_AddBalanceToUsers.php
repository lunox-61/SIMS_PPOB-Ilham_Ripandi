<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBalanceToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'balance' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'after'      => 'photo' // bisa ditaruh setelah kolom `photo`
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'balance');
    }
}
