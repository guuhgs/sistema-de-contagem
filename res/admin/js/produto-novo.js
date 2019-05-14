$(function(){

      var cores = new Array();
      var tamanhos = new Array();

      $("#btnNome").click(function(){

        var lblNomeProd = $("#lblNome");
        var nomeProd = $("#txtNome").val();

        if(nomeProd.length > 0){

          $("#msg-erro-nome").hide();

          lblNomeProd.text("Nome do produto: " + nomeProd);

          lblNomeProd.show();
          $("#txtNome").hide();
          $("#btnNome").hide();
          $("#atributos").show();
        } else {

            $("#msg-erro-nome").show();
        }
      });

      $("#addCor").click(function(){

        var cor = $("#txtCor").val().toLowerCase();

        if(cor.length > 0){

          $("#msg-erro-cor").hide();

          cores.push(cor);

          $("#txtCor").val("");
          $("#lblCores").text("Cores: " + cores);
          $("#lblCores").show();
          $("#atributos").append("<input type hidden name='cores' value='"+ cores +"'>'");
          $("#btnContar").show();
        } else {

            $("#msg-erro-cor").show();
        }
      });

      $("#addTamanho").click(function(){

        var tamanho = $("#txtTamanho").val().toUpperCase();

        if(tamanho.length > 0){

          $("#msg-erro-tamanho").hide();

          tamanhos.push(tamanho);

          $("#txtTamanho").val("");
          $("#lblTamanhos").text("Tamanhos: " + tamanhos);
          $("#atributos").append("<input type hidden name='tamanhos' value='"+ tamanhos +"'>'");
          $("#btnContar").show();
        } else {

            $("#msg-erro-tamanho").show();
        }
      });
});
