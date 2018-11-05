<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel - <?php echo $viewData['company_name']; ?></title>
        <link href="<?php echo base_url; ?>/assets/css/template.css" rel="stylesheet" />
        <script src="<?php echo base_url; ?>/assets/js/jQuery.js"></script>
        <script src="<?php echo base_url; ?>/assets/js/script.js"></script>
        <script type="text/javascript"> var base_url = '<?php echo base_url; ?>';</script>
    </head>
    <body><div class="leftmenu">
            <div class="company_name">
                <?php echo $viewData['company_name']; ?>
            </div>
            <div class="menuarea">
                <ul>
                    <li><a href="<?php echo base_url; ?>">Home</a></li>
                    <li><a href="<?php echo base_url; ?>/permissions">Permissões</a></li>
                    <li><a href="<?php echo base_url; ?>/users">Usuários</a></li>
                    <li><a href="<?php echo base_url; ?>/clients">Clientes</a></li>
                    <li><a href="<?php echo base_url; ?>/providers">Fornecedores</a></li>
                    <li><a href="<?php echo base_url; ?>/inventory">Estoque</a></li>
                    <li><a href="<?php echo base_url; ?>/sales">Vendas</a></li>
                    <li><a href="<?php echo base_url; ?>/purchases">Compras</a></li>
                    <li><a href="<?php echo base_url; ?>/report">Relatórios</a></li>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="top">
                <div class="top_right"><a href="<?php echo base_url . '/login/logout'; ?>">Sair</a></div>
                <div class="top_right"><?php echo utf8_encode($viewData['user_name']); ?></div>    			
            </div>
            <div class="area">
                <?php $this->loadViewInTemplate($viewName, $viewData); ?>
            </div> 
        </div>

    </body>
</html>
