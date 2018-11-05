<h1>Fornecedores</h1>
<?php if ($edit_permission): ?>
    <div class="button"><a href="<?php echo base_url; ?>/providers/add">Adicionar Fornecedor</a></div>
<?php endif; ?>

<input type="text" id="busca" data-type="search_clients" />

<table border="0" width="100%">
    <tr>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($providers_list as $p): ?>
        <tr>
            <td><?php echo $p['name']; ?></td>
            <td width="100"><?php echo $p['phone']; ?></td>
            <td width="150"><?php echo $p['email']; ?></td>
            <td width="160" style="text-align:center">
                <?php if ($edit_permission): ?>
                    <div class="button button_small"><a href="<?php echo base_url; ?>/providers/edit/<?php echo $p['id']; ?>">Editar</a></div>
                    <div class="button button_small"><a href="<?php echo base_url; ?>/providers/delete/<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a></div>
                <?php else: ?>
                    <div class="button button_small"><a href="<?php echo base_url; ?>/providers/view/<?php echo $p['id']; ?>">Visualizar</a></div>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="pagination">
    <?php for ($q = 1; $q <= $p_count; $q++): ?>
        <div class="pag_item <?php echo ($q == $p) ? 'pag_ativo' : ''; ?>"><a href="<?php echo base_url; ?>/providers?p=<?php echo $q; ?>"><?php echo $q; ?></a></div>
    <?php endfor; ?>
    <div style="clear:both"></div>
</div>

