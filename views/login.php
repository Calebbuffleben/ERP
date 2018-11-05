<html>
    <head>
        <title>ERP</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>/assets/css/login.css"/>
        <script type="text/javascript" src="<?php echo base_url; ?>/assets/css/css.css"></script>
    </head>
    <body>
        <div class="loginarea">
            <img src="<?php echo base_url; ?>/assets/images/logo.jpg" width="200"/>
            <form method="POST" action="">
                <input type="email" name="email" placeholder="Digite seu e-mail" />

                <input type="password" name="password" placeholder="Digite sua senha" />

                <input type="submit" value="Entrar" /><br/>

                <?php if (isset($error) && !empty($error)): ?>
                    <div class="warning"><?php echo $error; ?></div>
                <?php endif; ?>
            </form>
        </div>

    </body>
</html>
