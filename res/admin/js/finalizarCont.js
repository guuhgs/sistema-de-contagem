$(function(){
    $("#btnFinalizar").click(function(){

        var tabela = $("#tabela1").tableToJSON();

        $.each(tabela, function(key, value){

            $.each(value, function(k, v){

                if(v == ""){

                    tabela[key][k] = "0";
                }
            });
        });

        var idContagem = $("#idContagem").val();

        $.redirect('/salvar-contagem/' + idContagem, {dados:tabela});
    });

    $("#btnFinalizarRec").click(function(){

        var tabela = $("#tabela1").tableToJSON();

        $.each(tabela, function(key, value){

            $.each(value, function(k, v){

                if(v == ""){

                    tabela[key][k] = "0";
                }
            });
        });

        var idContagem = $("#idContagem").val();

        $.redirect('/salvar-recontagem/' + idContagem, {dados:tabela});
    });
});