<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container py-5">
    <h1 class="mb-4"><i class="bi bi-truck me-2"></i>Meus Pedidos</h1>
    
    <?php if (empty($pedidos)): ?>
        <div class="alert alert-info">
            Você ainda não fez nenhum pedido.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nº Pedido</th>
                        <th>Restaurante</th>
                        <th>Data</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td>#<?= $pedido['id'] ?></td>
                            <td><?= esc($pedido['restaurante_nome'] ?? 'Restaurante') ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($pedido['criado_em'])) ?></td>
                            <td>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></td>
                            <td>
                                <span class="badge <?= getStatusBadgeClass($pedido['status']) ?>">
                                    <?= ucfirst($pedido['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('pedidos/detalhes/' . $pedido['id']) ?>" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="bi bi-eye"></i> Detalhes
                                </a>
                                

                                <?php if ($pedido['status'] == 'aguardando' || $pedido['status'] == 'preparando'): ?>
                                    <a href="<?= base_url('pedidos/cancelar/' . $pedido['id']) ?>"
                                    class="btn btn-sm btn-outline-danger cancelar-pedido"
                                    onclick="return confirm('Tem certeza que deseja cancelar este pedido?');">
                                        <i class="bi bi-x-circle"></i> Cancelar
                                    </a>
                                <?php endif; ?>

                                <?php if ($pedido['status'] == 'preparando'): ?>
                                    <a href="<?= base_url('pedidos/enviar/' . $pedido['id']) ?>"
                                    class="btn btn-sm btn-outline-success enviar-pedido">
                                        <i class="bi bi-send-fill"></i> Enviar
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de Confirmação de Cancelamento -->
<div class="modal fade" id="cancelarPedidoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar Cancelamento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja cancelar este pedido?</p>
                <p class="fw-bold">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                <button type="button" class="btn btn-danger" id="confirmarCancelamento">Confirmar Cancelamento</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    let pedidoIdParaCancelar;
    
    // Abre modal de cancelamento
    $('.cancelar-pedido').click(function() {
        pedidoIdParaCancelar = $(this).data('pedido-id');
        $('#cancelarPedidoModal').modal('show');
    });
    
    // Confirma cancelamento
    $('#confirmarCancelamento').click(function() {
        $.ajax({
            url: '<?= base_url('pedidos/cancelar') ?>',
            method: 'POST',
            data: {
                pedido_id: pedidoIdParaCancelar,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Erro ao cancelar pedido');
                }
            },
            error: function() {
                alert('Erro na comunicação com o servidor');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>