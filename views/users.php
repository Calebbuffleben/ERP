<h1>Usuários</h1>
<div class="button"><a href="<?php echo base_url; ?>/users/add">Adicionar Usuário</a></div>

<table border="0" width="100%">
    <tr>
        <th>Nome de usuário</th>
        <th>Grupo de Permissões</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($users_list as $us): ?>
        <tr>
            <td><?php echo $us['user_name']; ?></td>
            <td width="200"><?php echo $us['name']; ?></td>
            <td width="160">
                <div class="button button_small"><a href="<?php echo base_url;; ?>/users/edit/<?php echo $us['id']; ?>">Editar</a></div>
                <div class="button button_small"><a href="<?php echo base_url;; ?>/users/delete/<?php echo $us['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a></div>
            </td>
        </tr>
    <?php endforeach; ?>
</table>