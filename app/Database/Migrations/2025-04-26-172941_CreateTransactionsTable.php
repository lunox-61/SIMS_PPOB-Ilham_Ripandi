<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'invoice_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'service_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'service_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'transaction_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'comment'    => 'TOPUP or PAYMENT',
            ],
            'amount' => [
                'type' => 'INT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true); 
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
