<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ---------------------------------------------------
// HOME
// ---------------------------------------------------
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');

// ---------------------------------------------------
// RESTAURANTES
// ---------------------------------------------------
$routes->group('restaurantes', function($routes) {

    // Páginas
    $routes->get('cadastro', 'Restaurantes::cadastro');
    $routes->get('login', 'Restaurantes::login');
    $routes->get('logout', 'Restaurantes::logout');
    $routes->get('editar/(:num)', 'Restaurantes::editar/$1');
    $routes->get('painel/(:num)', 'Restaurantes::painel/$1');
    $routes->get('pedidos/(:num)', 'Pedidos::index/$1');


    // Ações
    $routes->post('cadastrar', 'Restaurantes::cadastrar');
    $routes->post('logar', 'Restaurantes::logar');
    $routes->post('atualizar/(:num)', 'Restaurantes::atualizar/$1');
});

// ---------------------------------------------------
// USUÁRIOS
// ---------------------------------------------------
$routes->group('usuarios', function($routes) {

    // Páginas
    $routes->get('cadastro', 'Usuarios::cadastro');
    $routes->get('login', 'Usuarios::login');
    $routes->get('informacao', 'Usuarios::informacao');
    $routes->get('editar/(:num)', 'Usuarios::editar/$1');
    $routes->get('painelUsuario', 'Usuarios::painelUsuario');

    // Ações
    $routes->post('cadastrar', 'Usuarios::cadastrar');
    $routes->post('logar', 'Usuarios::logar');
    $routes->get('logout', 'Usuarios::logout');
});

// ---------------------------------------------------
// CARDÁPIO
// ---------------------------------------------------
$routes->group('cardapio', function($routes) {

    $routes->get('listar/(:num)', 'Cardapio::listar/$1');
    $routes->get('painel/(:num)', 'Cardapio::painel/$1');
    $routes->get('editar/(:num)', 'Cardapio::editar/$1');
    $routes->get('novo/(:num)', 'Cardapio::novo/$1');
    $routes->get('(:num)', 'Cardapio::index/$1');

    $routes->post('salvar/(:num)', 'Cardapio::salvar/$1');
    $routes->post('atualizar/(:num)', 'Cardapio::atualizar/$1');
});

// Cardápio para usuários
$routes->get('cardapiousuario/cardapio', 'CardapioUsuario::cardapio');

// ---------------------------------------------------
// ENDEREÇO
// ---------------------------------------------------
$routes->group('endereco', function($routes) {

    $routes->get('perfil', 'Endereco::perfil');
    $routes->post('salvar', 'Endereco::salvar');
    $routes->post('excluir/(:num)', 'Endereco::excluir/$1');
    $routes->post('atualizar/(:num)', 'Endereco::atualizar/$1');
});

// API de endereços
$routes->get('api/enderecos/usuario/(:num)', 'Api\Enderecos::usuario/$1');

// ---------------------------------------------------
// PEDIDOS
// ---------------------------------------------------
$routes->group('pedidos', function($routes) {

    $routes->get('rastrear', 'Pedidos::rastrear');
    $routes->post('salvar', 'Pedidos::salvar');
    $routes->post('confirmar/(:num)', 'Pedidos::confirmar/$1');
    $routes->get('enviar/(:num)', 'Pedidos::enviar/$1');
    $routes->post('confirmarEntrega/(:num)', 'Pedidos::confirmarEntrega/$1');


    // Rotas adicionais para usuário
    $routes->get('detalhes/(:num)', 'Pedidos::detalhes/$1');
    $routes->post('cancelar/(:num)', 'Pedidos::cancelar/$1');
});

// Pedidos do restaurante
$routes->get('restaurante/pedidos/(:num)', 'Pedidos::index/$1');

// ---------------------------------------------------
// RELATÓRIOS
// ---------------------------------------------------
$routes->get('relatorios', 'Relatorios::index');
$routes->get('relatorios/sincronizar', 'Relatorios::sincronizar');
