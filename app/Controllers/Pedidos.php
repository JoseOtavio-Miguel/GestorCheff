<?php
namespace App\Controllers;
use App\Models\ItensCardapioModel;
use App\Models\UsuariosModel; 
use App\Models\ItensPedidoModel;
use App\Models\EnderecoModel;
use App\Models\PedidosModel;
use CodeIgniter\Controller; 



class Pedidos extends BaseController {

    /**
     * Página de pedidos do restaurante
     * 
     * @param int $restauranteId
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index($restauranteId)
    {
        $pedidosModel = new \App\Models\PedidosModel();

        $pedidos = $pedidosModel->where('restaurante_id', $restauranteId)->orderBy('criado_em', 'DESC')->findAll();

        return view('restaurantes/pedidos-restaurante', [
            'pedidos' => $pedidos
        ]);
    }


public function salvar()
{
    $pedidoModel   = new \App\Models\PedidosModel();
    $itemModel     = new \App\Models\ItensCardapioModel();
    $usuarioModel  = new \App\Models\UsuariosModel();
    $enderecoModel = new \App\Models\EnderecoModel();

    $itensJson  = $this->request->getPost('itens');
    $enderecoId = $this->request->getPost('endereco_id');

    if (empty($itensJson)) {
        return redirect()->back()->with('error', 'Carrinho está vazio.');
    }

    $itens = json_decode($itensJson, true);
    if (empty($itens) || !is_array($itens)) {
        return redirect()->back()->with('error', 'Itens inválidos.');
    }

    // Pega o usuário logado
    $usuarioId = session()->get('usuario_id');
    if (!$usuarioId) {
        return redirect()->back()->with('error', 'Usuário não autenticado.');
    }

    $usuario = $usuarioModel->find($usuarioId);
    if (!$usuario) {
        return redirect()->back()->with('error', 'Usuário não encontrado.');
    }

    // Pega endereço
    $endereco = $enderecoModel->find($enderecoId);
    if (!$endereco) {
        return redirect()->back()->with('error', 'Endereço inválido.');
    }

    // Calcula o valor total
    $valorTotal = 0;
    foreach ($itens as $item) {
        $cardapio = $itemModel->find($item['id']);
        if (!$cardapio) continue;

        $valorTotal += $cardapio['preco'] * $item['quantidade'];

        $restauranteId = $cardapio['restaurante_id'];
    }

    if ($valorTotal <= 0) {
        return redirect()->back()->with('error', 'Erro ao calcular o valor total.');
    }

    // Prepara os dados para salvar o pedido
    $pedidoData = [
        'restaurante_id'      => $restauranteId, // ou dinâmico se você tiver isso no contexto
        'usuario_id'          => $usuarioId,
        'cliente_nome'        => $usuario['nome'] . ' ' . $usuario['sobrenome'],
        'cliente_telefone'    => $usuario['telefone'] ?? '',
        'cliente_endereco'    => $endereco['logradouro'] . ', ' . $endereco['numero'] . ' - ' . $endereco['bairro'] . ', ' . $endereco['cidade'] . '/' . $endereco['estado'],
        'valor_total'         => $valorTotal,
        'status'              => 'aguardando',
        'criado_em'           => date('Y-m-d H:i:s'),
        'atualizado_em'       => date('Y-m-d H:i:s'),
    ];

    if (!$pedidoModel->save($pedidoData)) {
        return redirect()->back()->with('error', 'Erro ao salvar o pedido.');
    }

    $pedidoId = $pedidoModel->getInsertID(); // pega o ID do pedido recém-salvo
    $itensPedidoModel = new \App\Models\ItensPedidoModel();

    foreach ($itens as $item) {
        $cardapio = $itemModel->find($item['id']);
        if (!$cardapio) continue;

        $itensPedidoModel->save([
            'pedido_id'      => $pedidoId,
            'cardapio_id'    => $cardapio['id'],
            'quantidade'     => $item['quantidade'],
            'preco_unitario' => $cardapio['preco'],
            'preco_total'    => $cardapio['preco'] * $item['quantidade']
        ]);
    }


    return redirect()->to('usuarios/painelUsuario')->with('success', 'Pedido criado com sucesso!');
}


    /**
     * Rastrear pedidos do usuário
     */
    public function rastrear()
    {
        $pedidoModel = new PedidosModel();
        $restauranteModel = new \App\Models\RestaurantesModel(); // Adicione este model
        
        $usuarioId = session()->get('usuario_id');
        if (!$usuarioId) {
            return redirect()->to('/login')->with('error', 'Você precisa estar logado');
        }

        // Busca pedidos com informações do restaurante
        $pedidos = $pedidoModel->select('pedidos.*, restaurantes.nome as restaurante_nome')
                    ->join('restaurantes', 'restaurantes.id = pedidos.restaurante_id')
                    ->where('pedidos.usuario_id', $usuarioId)
                    ->orderBy('pedidos.criado_em', 'DESC')
                    ->findAll();

        return view('usuarios/rastreio-pedidos', [
            'pedidos' => $pedidos
        ]);
    }


    public function detalhes($pedidoId)
    {
        $db = \Config\Database::connect();
        $pedidoModel = new \App\Models\PedidosModel();

        // Busca o pedido
        $pedido = $pedidoModel->find($pedidoId);
        if (!$pedido) {
            return redirect()->back()->with('error', 'Pedido não encontrado');
        }

        // Verifica se pertence ao usuário logado
        if ($pedido['usuario_id'] != session()->get('usuario_id')) {
            return redirect()->back()->with('error', 'Acesso não autorizado');
        }

        // Busca os itens do pedido
        $query = "
            SELECT itens_pedido.*, itens_cardapio.nome AS item_nome
            FROM itens_pedido
            JOIN itens_cardapio ON itens_cardapio.id = itens_pedido.cardapio_id
            WHERE itens_pedido.pedido_id = ?
        ";
        $itens = $db->query($query, [$pedidoId])->getResultArray();

        // Busca o log de status
        $logs = $db->table('pedido_status_log')
                ->where('pedido_id', $pedidoId)
                ->orderBy('horario', 'ASC')
                ->get()
                ->getResultArray();

        return view('usuarios/detalhes-pedido', [
            'pedido' => $pedido,
            'itens'  => $itens,
            'logs'   => $logs  // <-- passa os logs para a view
        ]);
    }




    // Cancelar Pedido
    public function cancelar($id)
    {
        $pedidoModel = new PedidosModel();

        $pedidoModel->update($id, ['status' => 'cancelado']);

        return redirect()->back()->with('msg', 'Pedido cancelado!');
    }

    // Confirmar Pedido
    public function confirmar($id)
    {
        $pedidoModel = new PedidosModel();

        $pedidoModel->update($id, ['status' => 'preparando']);

        return redirect()->back()->with('msg', 'Pedido confirmado!');
    }

    // Enviar Pedido
    public function enviar($id)
    {
        $pedidoModel = new PedidosModel();

        $pedidoModel->update($id, ['status' => 'enviado']);

        return redirect()->back()->with('msg', 'Pedido enviado!');
    }

    public function confirmarEntrega($id)
    {
        $pedidoModel = new \App\Models\PedidosModel();

        // Busca o pedido
        $pedido = $pedidoModel->find($id);
        if (!$pedido) {
            return redirect()->back()->with('error', 'Pedido não encontrado');
        }

        // Verifica se o pedido está no status correto
        if ($pedido['status'] !== 'enviado') {
            return redirect()->back()->with('error', 'Este pedido ainda não pode ser finalizado.');
        }

        // Atualiza o status para FINALIZADO
        $pedidoModel->update($id, ['status' => 'finalizado']);

        return redirect()->back()->with('success', 'Entrega confirmada! Pedido finalizado.');
    }
}

?>