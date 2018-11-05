<h1>Fornecedores - Adicionar</h1>

<?php if (isset($error_msg) && !empty($error_msg)): ?>
    <div class="warn"><?php echo $error_msg; ?></div>
<?php endif; ?>

<form method="POST">
    <label for="name">Nome</label><br/>
    <input type="text" name="name" required /><br/><br/>
    <label for="email">Email</label><br/>
    <input type="text" name="email" required /><br/><br/>
    <label for="phone">Telefone</label><br/>
    <input type="text" name="phone" required /><br/><br/>
    
    <input type="submit" value="Adicionar" />
</form>
<script type="text/javascript" src="<?php echo base_url; ?>/assets/js/script_providers_add.js"></script>