<?php

namespace App\Controllers;

use App\Models\RestaurantesModel;
use CodeIgniter\Controller;

class Restaurantes extends Controller
{
    protected $restaurantesModel;

    public function __construct()
    {
        $this->restaurantesModel = new RestaurantesModel(); // ← instanciando o model
    }
    
    public function cadastro()
    {
        return view('restaurantes/cadastro-restaurante');
    }


    public function cadastrar()
    {
        $restaurantes = new RestaurantesModel();
        

        // Pega os dados do formulário
        $data = [
            'nome'        => $this->request->getPost('nome'),
            'descricao'   => $this->request->getPost('descricao'),
            'cnpj'        => $this->request->getPost('cnpj'),
            'telefone'    => $this->request->getPost('telefone'),
            'email'       => $this->request->getPost('email'),
            'rua'         => $this->request->getPost('rua'),
            'cidade'      => $this->request->getPost('cidade'),
            'estado'      => strtoupper($this->request->getPost('estado')),
            'cep'         => $this->request->getPost('cep'),
            'status'      => $this->request->getPost('status') ?? 'ativo',
            'senha'       => password_hash($this->request->getPost('senha'), PASSWORD_DEFAULT), // <--- cuidado aqui, já falo disso abaixo
        ];

        if ($restaurantes->save($data)) {
            return redirect()->to('/restaurantes/cadastro')->with('success', 'Restaurante cadastrado com sucesso!');
        } else {
            return redirect()->to('/restaurantes/cadastro')->with('error', 'Erro ao cadastrar restaurante.');
        }
    }


    public function login()
    {
        return view('restaurantes/login-restaurante');

    }

    public function logout()
    {
        return view('/home');

    }

    public function painel($restauranteId)
    {
        return view('restaurantes/painel-restaurante', [  // <-- CERTO
            'restauranteId' => $restauranteId,
            'restauranteNome' => session()->get('restaurante_nome')
        ]);
    }   



    public function logar()
    {
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        // Buscar o restaurante no banco
        $restauranteModel = new RestaurantesModel();
        $restaurante = $restauranteModel->where('email', $email)->first(); // <-- Aqui!!

        if ($restaurante && password_verify($senha, $restaurante['senha'])) {
            // Login bem-sucedido!

            // Salvar os dados na sessão
            session()->set([
                'restaurante_id' => $restaurante['id'],
                'restaurante_nome' => $restaurante['nome'],
                'logado' => true
            ]);

            // Redireciona para o painel
            return view('restaurantes/painel-restaurante', [
                'restauranteId' => $restaurante['id'], // <- pega o ID real do restaurante!
                'restauranteNome' => session()->get('restaurante_nome')
            ]);
            
        } else {
            // Login inválido
            return redirect()->back()->with('error', 'E-mail ou senha incorretos.');
        }
    }

    /**
    * Exibe o formulário de edição de um restaurante.
    */
    public function editar($id)
        {
            $restaurante = $this->restaurantesModel->find($id);

            if (!$restaurante) {
                return redirect()->to(base_url('restaurantes'))->with('error', 'Restaurante não encontrado.');
            }

            return view('restaurantes/editar-restaurante', [
                'restaurante' => $restaurante
            ]);
        }

    /**
    * Processa os dados e atualiza o restaurante.
    */

    
    public function atualizar($id)
    {
        $restaurante = $this->restaurantesModel->find($id);

        if (!$restaurante) {
            return redirect()->to(base_url('restaurantes'))->with('error', 'Restaurante não encontrado.');
        }

        $dados = $this->request->getPost();

        // Se quiser permitir alteração de senha, deve fazer verificação e hash aqui.
        unset($dados['senha']); // Proteção, caso não queira alterar a senha diretamente.

        $this->restaurantesModel->update($id, $dados);

        return redirect()->to(base_url('restaurantes'))->with('success', 'Dados do restaurante atualizados com sucesso!');
    }

    
    public function pedidos($restauranteId)
    {
        // Carrega o model de pedidos
        $pedidosModel = new \App\Models\PedidosModel();

        // Busca todos os pedidos do restaurante
        $pedidos = $pedidosModel
            ->where('restaurante_id', $restauranteId)
            ->orderBy('id', 'DESC')
            ->findAll();

        // Envia dados para a view
        return view('restaurantes/pedidos-restaurante', [
            'restauranteId' => $restauranteId,
            'restauranteNome' => session()->get('restaurante_nome'),
            'pedidos' => $pedidos
        ]);
    }

}