function excluirProd(obj) {
    $(obj).closest('tr').remove();
}
function registerProduct() {
    var form = "<div class='form_products_register'>" +
            "<form method='POST'>" +
            "<label for='name'>Nome</label><br/>" +
            "<input type='text' id='name' name='name' required /><br/><br/>" +
            "<label for='price'>Preço</label><br/>" +
            "<input type='text' id='price' name='price' required /><br/><br/>" +
            "<label for='quant'>Quantidade</label><br/>" +
            "<input type='number' id='quant' name='quant' required /><br/><br/>" +
            "<input type='button' value='Adicionar' id='add' onclick='addProd(this)' class='addProd'/>" +
            "</form></div>";
    $('#register').append(form);
}
function registerProvider() {
    var form = "<div class='form_provider_register'>" +
            "<form method='POST' action='" + base_url + "/providers/add'>" +
            "<label for='provider_name'>Nome</label><br/>" +
            "<input type='text' name='provider_name' required /><br/><br/>" +
            "<label for='email'>Email</label><br/>" +
            "<input type='text' name='provider_email' required /><br/><br/>" +
            "<label for='phone'>Telefone</label><br/>" +
            "<input type='text' name='provider_phone' required /><br/><br/>" +
            "</form></div>";
    $('#register_provider').append(form);
}
function addProd(obj) {
    var name = $('#name').val();
    var price = $('#price').val();
    var quant = $('#quant').val();
    var subTotal = price * quant;

    var tr = '<tr>' +
            '<td>' + name + '</td>' +
            '<td>' + quant + '</td>' +
            '<td>' + price + '</td>' +
            '<td>' + subTotal + '</td>' +
            '<td><a href="javascript:;" onclick="excluirProd(this)">Excluir</a></td>' +
            '</tr>';
    $('#show_products').append(tr);
    updateTotal();
}
function updateTotal() {
    if ($("#total_price").value == null) {
        var total = 0;
    } else {
        var total = $("#total_price").val();
    }
    for (var q = 0; q < $('#quant').length; q++) {
        var quant = $('#quant').eq(q);

        var price = $('#price').val();
        var subtotal = price * parseInt(quant.val());

        total += subtotal;
    }
    $('input[name=total_price]').val(total);
}