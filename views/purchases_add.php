<h1>Compras - Adicionar</h1>

<form method="POST">
    <label for="client_name">Nome do Fornecedor</label><br/>
    <input type="hidden" name="client_id" />
    <input type="text" name="provider_name" id="provider_name" data-type="search_providers" />
    <div style="clear:both"></div>
    <br/>
    <div class="button" onclick="javascript:registerProvider()">Cadastrar Novo Fornecedor</div>
    <br/><br/>
    <div id="register_provider"></div><br/>

    <label for="status">Status da Venda</label><br/>
    <select name="status" id="status">
        <option value="0">A Pagar</option>
        <option value="1">Pago</option>
        <option value="2">Cancelado</option>
    </select><br/><br/>

    <label for="total_price">Valor total da Compra</label><br/>
    <input type="text" name="total_price" id="total_price" readonly="readonly" /><br/><br/>

    <hr/>

    <h4>Produtos</h4>
    <div class="button" onclick="javascript:registerProduct()">Adicionar Produto</div>
    <div id="register"></div>

    <table border="0" width="100%" id="show_products">
        <tr>
            <th>Nome do Produto</th>
            <th>Quantidade</th>
            <th>Preço Unit.</th>
            <th>Sub-Total</th>
            <th>Excluir</th>
        </tr>
    </table>

    <hr/>

    <input type="submit" value="Adicionar Compra" />
</form>
<script type="text/javascript" src="<?php echo base_url; ?>/assets/js/jquery.mask.js"></script>
<script type="text/javascript" src="<?php echo base_url; ?>/assets/js/script_purchases_add.js"></script>