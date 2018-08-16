$(function (){ 
	//alert("function - 1!");
    $(this).mousedown(function (e) {
			//alert("entrei - 2!");
            var ide = e.target.id;

            //Aqui serão feitas as ações quando se aperta o botão CONFIRMA
                if(ide == "confirma"){
                    if($("#habilitaConfirma").text() == "true"){
                        $("#habilitaConfirma").text("false");
                        $('#' + ide).attr("src","image/" + ide + "_down.jpg"); 
                        $(location).attr('href','prefeito.html?audio=1');
                    }else{
                        try { $('#audioOps').get(0).play(); } catch(e){}
                        notifica('information','Para <strong>CONFIRMAR</strong> seu voto é necessário escolher os dois primeiros números<br /> ou votar em BRANCO.<br /><br />[ FECHAR ]');
                    }
                }
                
            //Aqui serão feitas as ações quando se aperta os botões com números
            if(ide.substring(0, 2) == 'n_'){
                
                //desabitar utilização de números 
                if($("#habilitaNumeros").text() == "false"){
                        try { $('#audioOps').get(0).play(); } catch(e){}
                        notifica('information','Nesta situação a utilização de qualquer número está bloqueada!');
                        return false;
                }
                   
                //Flag utilizada para habilitar/desabilitar utilização do botao Corrige
                $("#habilitaCorrige").text("true");
				   
                matriz = ide.split("_");
                $('#' + ide).attr("src","image/" + ide.substr(0, 1) + ide.substr(2, 1) + "_down.jpg"); 

                if($("#cxNumero1").text().length == 0){
					$("#restoVerde").hide();
					$("#regua").hide();
				}else{
					$("#restoVerde").show();
					$("#regua").show();
				}

                if($("#cxNumero1").text().length == 0){
                    $('#cxNumero1').text(matriz[1]);
                    $( "#cxNumero1" ).finish();
                    $("#cxNumero2").effect( "pulsate", {times:20}, 25000 );
                }else if($("#cxNumero2").text().length == 0){
                    $('#cxNumero2').text(matriz[1]);
                    $( "#cxNumero2" ).finish();
                    $("#cxNumero3").effect( "pulsate", {times:20}, 25000 );
					habilitaInfo();
                    num = $("#cxNumero1").text() + $("#cxNumero2").text();
                    mostrarPartido(num);
                }else if($("#cxNumero3").text().length == 0){
                    $('#cxNumero3').text(matriz[1]);
                    $( "#cxNumero3" ).finish();
                    $("#cxNumero4").effect( "pulsate", {times:20}, 25000 );
                }else if($("#cxNumero4").text().length == 0){
                    $('#cxNumero4').text(matriz[1]);
                    $( "#cxNumero4" ).finish();
                    $("#cxNumero5").effect( "pulsate", {times:20}, 25000 );
                }else if($("#cxNumero5").text().length == 0){
                    $('#cxNumero5').text(matriz[1]);
                    $("#cxNumero5").finish();
                    num = $("#cxNumero1").text() + $("#cxNumero2").text() + $("#cxNumero3").text() + $("#cxNumero4").text()  + $("#cxNumero5").text();
                    mostrarCandidato(num,"vereador");
                }               
  
            }
            
    });
	//alert("saindo!");

});