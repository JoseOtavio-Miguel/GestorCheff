<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-color: #6c5ce7;
        --secondary-color: #a29bfe;
        --danger-color: #ff7675;
        --success-color: #00b894;
        --warning-color: #fdcb6e;
        --dark-color: #2d3436;
        --light-color: #f5f6fa;
    }
    
    .card-detail {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .card-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 1.5rem;
    }
    
    .badge {
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
    }
    
    .badge-aguardando {
        background-color: #ffeaa7;
        color: var(--dark-color);
    }
    
    .badge-preparando {
        background-color: #81ecec;
        color: var(--dark-color);
    }
    
    .badge-entregue {
        background-color: var(--success-color);
        color: white;
    }
    
    .badge-cancelado {
        background-color: var(--danger-color);
        color: white;
    }
    
    .info-box {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .info-box h5 {
        color: var(--primary-color);
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .info-box p {
        margin-bottom: 8px;
    }
    
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table thead th {
        background-color: #f8f9fa;
        border: none;
        padding: 15px;
        font-weight: 600;
        color: var(--dark-color);
    }
    
    .table tbody tr {
        transition: all 0.2s;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .table tbody td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .btn-danger {
        background-color: var(--danger-color);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
    }
    
    .btn-danger:hover {
        background-color: #e17070;
    }
    
    .btn-outline-secondary {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
    }
    
    .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .modal-header {
        padding: 1.25rem;
    }
    
    .total-summary {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }
    
    .status-timeline {
        position: relative;
        padding-left: 30px;
        margin-top: 20px;
    }
    
    .status-timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e0e0e0;
    }
    
    .status-step {
        position: relative;
        margin-bottom: 20px;
    }
    
    .status-step::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #e0e0e0;
    }
    
    .status-step.active::before {
        background-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
    }
    
    .status-step.completed::before {
        background-color: var(--success-color);
    }
    
    .status-step.canceled::before {
        background-color: var(--danger-color);
    }
    
    .status-step p {
        margin-bottom: 5px;
        color: #7f8c8d;
    }
    
    .status-step.active p,
    .status-step.completed p,
    .status-step.canceled p {
        color: var(--dark-color);
        font-weight: 500;
    }
</style>

<div class="container py-5">
    <div class="card card-detail">
        <div class="card-header text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="fas fa-receipt me-2"></i>Pedido #<?= $pedido['id'] ?></h2>
                <span class="badge <?= getStatusBadgeClass($pedido['status']) ?>">
                    <?= ucfirst($pedido['status']) ?>
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="info-box">
                        <h5><i class="fas fa-info-circle me-2"></i>Informações do Pedido</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="far fa-calendar-alt me-2"></i>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido['criado_em'])) ?></p>
                                <p><strong><i class="fas fa-money-bill-wave me-2"></i>Valor Total:</strong> R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-truck me-2"></i>Tipo de Entrega:</strong> <?= $pedido['tipo_entrega'] ?? 'Delivery' ?></p>
                                <?php if(isset($pedido['forma_pagamento'])): ?>
                                <p><strong><i class="fas fa-credit-card me-2"></i>Pagamento:</strong> <?= ucfirst($pedido['forma_pagamento']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <h5><i class="fas fa-map-marker-alt me-2"></i>Informações de Entrega</h5>
                        <p><strong>Cliente:</strong> <?= esc($pedido['cliente_nome']) ?></p>
                        <p><strong>Endereço:</strong> <?= esc($pedido['cliente_endereco']) ?></p>
                        <p><strong>Telefone:</strong> <?= esc($pedido['cliente_telefone']) ?></p>
                        <?php if(!empty($pedido['observacoes'])): ?>
                        <p class="mt-3"><strong><i class="fas fa-sticky-note me-2"></i>Observações:</strong></p>
                        <p class="text-muted"><?= esc($pedido['observacoes']) ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="info-box">
                        <h5><i class="fas fa-utensils me-2"></i>Itens do Pedido</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th class="text-center">Qtd</th>
                                        <th class="text-end">Preço Unitário</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($itens)): ?>
                                        <?php foreach ($itens as $item): ?>
                                            <tr>
                                                <td><?= esc($item['item_nome']) ?></td>
                                                <td class="text-center"><?= $item['quantidade'] ?></td>
                                                <td class="text-end">R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                                                <td class="text-end">R$ <?= number_format($item['preco_total'], 2, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="text-center">Nenhum item encontrado.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td class="text-end fw-bold">R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                   <div class="info-box">
                        <h5><i class="fas fa-history me-2"></i>Status do Pedido</h5>

                        <div class="status-timeline">
                            <!-- 1. Pedido Recebido -->
                            <div class="status-step
                                <?= $pedido['status'] == 'aguardando' ? 'active' : ($pedido['status'] != 'cancelado' ? 'completed' : '') ?>
                            ">
                                <p class="mb-1">Pedido Recebido</p>
                                <small class="text-muted"><?= date('d/m H:i', strtotime($pedido['criado_em'])) ?></small>
                            </div>

                            <!-- 2. Em Preparação -->
                            <div class="status-step
                                <?= $pedido['status'] == 'preparando' ? 'active' : '' ?>
                                <?= in_array($pedido['status'], ['enviado','finalizado']) ? 'completed' : '' ?>
                            ">
                                <p class="mb-1">Em Preparação</p>
                                <small class="text-muted">
                                    <?= isset($pedido['preparando_em']) ? date('d/m H:i', strtotime($pedido['preparando_em'])) : '-' ?>
                                </small>
                            </div>

                            <!-- 3. Enviado para Entrega -->
                            <div class="status-step
                                <?= $pedido['status'] == 'enviado' ? 'active' : '' ?>
                                <?= $pedido['status'] == 'finalizado' ? 'completed' : '' ?>
                            ">
                                <p class="mb-1">Enviado para Entrega</p>
                                <small class="text-muted">
                                    <?= isset($pedido['enviado_em']) ? date('d/m H:i', strtotime($pedido['enviado_em'])) : '-' ?>
                                </small>
                            </div>

                            <!-- 4. Pedido Finalizado -->
                            <div class="status-step
                                <?= $pedido['status'] == 'finalizado' ? 'active completed' : '' ?>
                            ">
                                <p class="mb-1">Pedido Finalizado</p>
                                <small class="text-muted">
                                    <?= isset($pedido['finalizado_em']) ? date('d/m H:i', strtotime($pedido['finalizado_em'])) : '-' ?>
                                </small>
                            </div>

                            <!-- 5. Cancelado -->
                            <?php if ($pedido['status'] == 'cancelado'): ?>
                                <div class="status-step canceled active">
                                    <p class="mb-1">Pedido Cancelado</p>
                                    <small class="text-muted">
                                        <?= isset($pedido['cancelado_em']) ? date('d/m H:i', strtotime($pedido['cancelado_em'])) : '-' ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                    <div class="info-box">
                        <h5><i class="fas fa-file-invoice-dollar me-2"></i>Resumo Financeiro</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>R$ <?= number_format($pedido['subtotal'] ?? $pedido['valor_total'], 2, ',', '.') ?></span>
                        </div>
                        <?php if(isset($pedido['taxa_entrega']) && $pedido['taxa_entrega'] > 0): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Taxa de Entrega:</span>
                            <span>R$ <?= number_format($pedido['taxa_entrega'], 2, ',', '.') ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if(isset($pedido['desconto']) && $pedido['desconto'] > 0): ?>
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Desconto:</span>
                            <span>- R$ <?= number_format($pedido['desconto'], 2, ',', '.') ?></span>
                        </div>
                        <?php endif; ?>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('pedidos/rastrear') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar para Meus Pedidos
                </a>
                
                <?php if (in_array($pedido['status'], ['aguardando', 'preparando'])): ?>
                <button class="btn btn-danger cancelar-pedido" data-pedido-id="<?= $pedido['id'] ?>">
                    <i class="fas fa-times-circle me-2"></i> Cancelar Pedido
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cancelamento -->
<div class="modal fade" id="cancelarPedidoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar Cancelamento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja cancelar este pedido?</p>
                <p class="text-muted">Esta ação não pode ser desfeita e pode estar sujeita a políticas de cancelamento.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-arrow-left me-2"></i>Voltar</button>
                <button type="button" class="btn btn-danger" id="confirmarCancelamento">
                    <i class="fas fa-trash-alt me-2"></i>Confirmar Cancelamento
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
$(document).ready(function () {
    let pedidoId;

    $('.cancelar-pedido').click(function () {
        pedidoId = $(this).data('pedido-id');
        $('#cancelarPedidoModal').modal('show');
    });

    $('#confirmarCancelamento').click(function () {
        $.post('<?= base_url('pedidos/cancelar') ?>', {
            pedido_id: pedidoId,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        }, function (res) {
            if (res.success) {
                location.reload();
            } else {
                alert(res.message || 'Erro ao cancelar pedido');
            }
        }).fail(function () {
            alert('Erro ao comunicar com o servidor.');
        });
    });
});
</script>
<?= $this->endSection() ?>