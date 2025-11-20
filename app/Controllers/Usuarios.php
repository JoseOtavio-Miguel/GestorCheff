<?php

namespace App\Controllers;
use App\Models\UsuariosModel; 
use App\Models\EnderecoModel;
use CodeIgniter\Controller; 

class Usuarios extends BaseController
{
    public function index()
    {
        echo view('');
    }

    // Página de Login do Usuario
    public function login()
    {
        return view('usuarios/login-usuario');
    }
    

    // Retorna a página para cadastro
    public function cadastro()
    {
        return view('usuarios/cadastro-usuario');
    }

    public function atualizar($id)
    {
        $usuarioModel = new \App\Models\UsuarioModel();

        $data = $this->request->getPost([
            'nome', 'sobrenome', 'datanascimento', 'email', 'telefone'
        ]);

        // Validação simples (você pode adaptar para usar rules do CI4)
        if (!$usuarioModel->update($id, $data)) {
            return redirect()->back()->with('errors', $usuarioModel->errors());
        }

        return redirect()->to('/usuarios/perfil')->with('success', 'Perfil atualizado com sucesso!');
    }



    public function informacao()
    {
        $usuarioId = session()->get('usuario_id');

        if (!$usuarioId) {
            return redirect()->to('/usuarios/login');
        }

        $usuarioModel = new UsuariosModel();
        $enderecoModel = new EnderecoModel();

        $usuario = $usuarioModel->find($usuarioId);

        if (!$usuario) {
            throw new \Exception('Usuário não encontrado');
        }

        $enderecos = $enderecoModel->where('usuario_id', $usuarioId)->findAll();

        return view('usuarios/informacao-usuario', [
            'usuario'   => $usuario,
            'enderecos' => $enderecos // <-- Enviando para a view
        ]);
    }



    public function painelUsuario()
    {
        // Pega o ID do usuário da sessão
        $usuarioId = session()->get('usuario_id');

        // Verifica se o usuário está logado
        // Se não estiver logado, redireciona para a página de login
        if (!$usuarioId) {
            return redirect()->to('/usuarios/login');
        }


        $usuarioModel = new UsuariosModel(); // veja que no seu controller é UsuariosModel (plural)
        $usuario = $usuarioModel->find($usuarioId);

        if (!$usuario) {
            throw new \Exception('Usuário não encontrado');
        }

        return view('usuarios/painel-usuario', ['usuario' => $usuario]);
    }
        



    /* ------------  CRUD USUARIO  ------------ */

    // Cadastra o Usuário no Banco de Dados
    // Cadastra o Usuário no Banco de Dados
    public function cadastrar()
    {
        // Verifica se o usuário já está logado
        $usuarios = new UsuariosModel();
    
        $validation = \Config\Services::validation();
    
        // Verifica se o usuário já está logado
        $rules = [
            'nome' => 'required|min_length[3]|max_length[50]',
            'sobrenome' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'telefone' => 'permit_empty|max_length[20]',
            'cpf' => 'required|is_unique[usuarios.cpf]',
            'datanascimento' => 'required|valid_date',
            'senha' => 'required|min_length[8]',
            'confirmasenha' => 'required|matches[senha]'
        ];
        
        // Define as mensagens de erro personalizadas
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Pega os dados do formulário
        $data = [
            'nome'            => $this->request->getPost('nome'),
            'sobrenome'       => $this->request->getPost('sobrenome'),
            'email'           => $this->request->getPost('email'),
            'telefone'        => $this->request->getPost('telefone'),
            'cpf'             => $this->request->getPost('cpf'),
            'datanascimento'  => $this->request->getPost('datanascimento'),
            'senha'           => password_hash($this->request->getPost('senha'), PASSWORD_DEFAULT), // senha criptografada
        ];

        
        $usuarios->save($data); 
        
        // Redireciona para a página de login com uma mensagem de sucesso
        return redirect()->to('/usuarios/login')->with('success', 'Usuário cadastrado com sucesso! Faça o login.');
    }




    /* ------------  LOGIN/LOGOUT  ------------ */
    public function logar()
    {
        $session = session();
        $model = new UsuariosModel();

        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        // Verifica se existe o usuário
        $usuario = $model->where('email', $email)->first();

        if ($usuario) {
            // Confere a senha
            if (password_verify($senha, $usuario['senha'])) {
                $sessionData = [
                    'usuario_id' => $usuario['id'],
                    'nome' => $usuario['nome'],
                    'email' => $usuario['email'],
                    'telefone' => $usuario['telefone'],   
                    'cpf' => $usuario['cpf'],             
                    'datanascimento' => $usuario['datanascimento'], 
                    'logged_in' => true
                ];
                $session->set($sessionData);

                $session->set($sessionData);
                return redirect()->to(base_url('/usuarios/painelUsuario'))->with('success', 'Login realizado com sucesso!');
            } else {
                return redirect()->back()->with('error', 'Senha incorreta.');
            }
        } else {
            return redirect()->back()->with('error', 'E-mail não encontrado.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('usuarios/login'))->with('success', 'Você saiu com sucesso.');
    }

    public function editar($id)
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuario = $usuarioModel->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuário não encontrado');
        }

        return view('usuarios/editar', ['usuario' => $usuario]);
    }

}
