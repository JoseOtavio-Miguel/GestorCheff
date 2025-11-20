<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePedidoStatusLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'pedido_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aguardando', 'preparando', 'enviado', 'finalizado', 'cancelado'],
            ],
            'horario' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP'
            ],
        ]);

        $this->forge->addKey('id', true);

        // FOREIGN KEY correta (usa unsigned)
        $this->forge->addForeignKey('pedido_id', 'pedidos', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('pedido_status_log');
    }

    public function down()
    {
        $this->forge->dropTable('pedido_status_log');
    }
}
