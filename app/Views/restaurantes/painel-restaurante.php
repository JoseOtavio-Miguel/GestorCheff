<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>




<div class="container py-5">
    <h1 class="painel-title text-center mb-5 fw-bold">
        Bem-vindo!
    </h1>
    <h2 class="painel-title text-center mb-5 fw-bold">
        Ao Gestor Cheff
        Seu Painel de Controle</i>
    </h2>


    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 text-center h-100 card-hover">
                <div class="card-body p-5">
                    <div class="icone-custom mb-3">
                        <i class="bi bi-journal-text text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">Cardápio</h4>
                    <p class="text-muted">Gerencie seus pratos e bebidas.</p>
                    <a href="<?= base_url('cardapio/' . $restauranteId) ?>" class="btn-custom btn btn-danger w-75 mt-3">Ver Cardápio</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 text-center h-100 card-hover">
                <div class="card-body p-5">
                    <div class="icone-custom mb-3">
                        <i class="bi bi-bag-check text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">Pedidos</h4>
                    <p class="text-muted">Acompanhe os pedidos recebidos.</p>
                    <a href="<?= base_url('/restaurante/pedidos/' . $restauranteId) ?>" class="btn-custom btn btn-danger w-75 mt-3">Ver Pedidos</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 text-center h-100 card-hover">
                <div class="card-body p-5">
                    <div class="icone-custom mb-3">
                        <i class="bi bi-bar-chart-line text-danger text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">Relatórios</h4>
                    <p class="text-muted">Fature mais analisando seus números.</p>
                    <a href="<?= base_url('relatorios') ?>" class="btn-custom btn btn-danger w-75 mt-3">Ver Relatórios</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 text-center h-100 card-hover">
                <div class="card-body p-5">
                    <div class="icone-custom icone-custom mb-3">
                        <i class="bi bi-gear " style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">Perfil</h4>
                    <p class="text-muted">Atualize seus dados e preferências.</p>
                    <a href="<?= base_url('restaurantes/editar/' . $restauranteId) ?>" class="btn-custom btn btn-danger w-75 mt-3">Editar Perfil</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 text-center h-100 card-hover">
                <div class="card-body p-5">
                    <div class="mb-3">
                        <i class=" bi bi-box-arrow-right text-secondary " style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">Sair</h4>
                    <p class="text-muted">Encerre sua sessão com segurança.</p>
                    <a href="<?= base_url('restaurantes/logout') ?>" class="btn btn-secondary w-75 mt-3">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-hover:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        background: #ffe3c5;
    }


    .painel-title {
        font-size: 2.8rem;
        font-weight: 700;
        background: linear-gradient(10deg,rgb(210, 28, 28),rgb(255, 238, 0));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card-hover:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        background: #ffe3c5;
    }
</style>

<?= $this->endSection() ?>
