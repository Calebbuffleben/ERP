<h1>Fornecedores - Editar</h1>

<?php if (isset($error_msg) && !empty($error_msg)): ?>
    <div class="warn"><?php echo $error_msg; ?></div>
<?php endif; ?>

<form method="POST">

    <label for="name">Nome</label><br/>
    <input type="text" name="name" value="<?php echo $provider_info['name']; ?>" required /><br/><br/>

    <label for="email">E-mail</label><br/>
    <input type="email" name="email" value="<?php echo $provider_info['email']; ?>" /><br/><br/>

    <label for="phone">Telefone</label><br/>
    <input type="text" name="phone" value="<?php echo $provider_info['phone']; ?>" /><br/><br/>

    <input type="submit" value="Alterar" />

</form>

<script type="text/javascript" src="<?php echo base_url; ?>/assets/js/script_clients_add.js"></script>