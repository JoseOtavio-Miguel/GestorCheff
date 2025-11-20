<?php
namespace App\Models;

use CodeIgniter\Model;

class PedidoStatusLogModel extends Model
{
    protected $table = 'pedido_status_log';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'pedido_id',
        'status',
        'horario'
    ];

    public $timestamps = false;
}
