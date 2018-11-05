$(function () {
    $('.tabitem').on('click', function () {

        $('.activetab').removeClass('activetab');
        $(this).addClass('activetab');

        var item = $('.activetab').index();
        $('.tabbody').hide();
        $('.tabbody').eq(item).show();
    });

    $('#busca').on('focus', function () {
        $(this).animate({
            width: '250px'
        }, 'fast');
    });

    $('#busca').on('blur', function () {
        if ($(this).val() == '') {
            $(this).animate({
                width: '100px'
            }, 'fast');
        }
        setTimeout(function () {
            $('.searchresults').hide();
        }, 500);
    });

});

$(document).ready(function () {
    $('#busca').keyup(function () {
        var datatype = $(this).attr('data-type');
        var q = $(this).val();

        if (datatype != '') {
            $.ajax({
                url: base_url + '/ajax/' + datatype,
                type: 'GET',
                data: {q: q},
                dataType: 'json',
                success: function (json) {
                  //  console.log(json[0].name);
                    if ($('.searchresults').length == 0) {
                        $('#busca').after('<div class="searchresults"></div>');
                    }
                    $('.searchresults').css('left', $('#busca').offset().left + 'px');
                    $('.searchresults').css('top', $('#busca').offset().top + $('#busca').height() + 3 + 'px');
                    
                    var conteudo = '';
                    
                    for ( var i = 0; i < json.length; i++){
                        conteudo += '<div class="si"><a href="'+json[i].link+'">' + json[i].name + '</a></div>';;
                    }
                    
                    $('.searchresults').html(conteudo);
                    $('.searchresults').show();
                }
            });
        }
    });
});

/*$(document).ready(function () {
 $('#busca').keyup(function () {
 $('form').submit(function () {
 var dados = $(this).serialize();
 
 $.ajax({
 url: base_url + '/ajax/' + datatype,
 type: 'GET',
 data: {q: q},
 dataType: 'json',
 success: function (data) {
 $('#resultado').empty().html(data);
 }
 });
 return false;
 });
 $('form').trigger('submit');
 });
 });*/