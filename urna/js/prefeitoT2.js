$(function (){ 
    $(this).mousedown(function (e) {
            var ide = e.target.id;
            
            //Aqui serão feitas as ações quando se aperta o botão CONFIRMA
            if(ide == "confirma"){
				if($("#habilitaConfirma").text() == "true"){
					$('#' + ide).attr("src","image/" + ide + "_down.jpg"); 
					$(location).attr('href','fim.html');
				}else{
                        try { $('#audioOps').get(0).play(); } catch(e){}
                        notifica('information','Para <strong>CONFIRMAR</strong> seu voto é necessário escolher os dois primeiros números<br /> ou votar em BRANCO.<br /><br />[ FECHAR ]');
                }
            }
            
            //Aqui serão feitas as ações quando se aperta os botões com números
            if(ide.substring(0, 2) == 'n_'){

				//desabitar utilização de números 
                if($("#habilitaNumeros").text() == "false"){
                    try { 
						$('#audioOps').get(0).play(); 
					
					} catch(e){}
                        notifica('information','Nesta situação a utilização de qualquer número está bloqueada!');
                        return false;
                }
                //Flag utilizada para habilitar/desabilitar utilização do botao Corrige
                $("#habilitaCorrige").text("true");
                
                matriz = ide.split("_");
                $('#' + ide).attr("src","image/" + ide.substr(0, 1) + ide.substr(2, 1) + "_down.jpg"); 
                
                if($("#cxNumero1").text().length == 0){
                    $('#cxNumero1').text(matriz[1]);
                    $( "#cxNumero1" ).finish();
                    $("#cxNumero2").effect( "pulsate", {times:20}, 25000 );
                }else if($("#cxNumero2").text().length == 0){
                    $('#cxNumero2').text(matriz[1]);
                    $( "#cxNumero2" ).finish();
					$("#habilitaConfirma").text("true");
                    num = $("#cxNumero1").text() + $("#cxNumero2").text();
                    mostrarPartido(num);
                    mostrarCandidato(num,"prefeito"); 
                }               
  
            }
            
    });

});

	var listaPartidos = new Array("91", "92");

    var notifica = function generate(type,texto) {
        var n = noty({
            text        : texto,
            type        : type,
            dismissQueue: true,
            modal       : true,
            layout      : 'center',
            theme       : 'defaultTheme',
            maxVisible  : 10
        });
    } 
	
	var partidoExiste = false;
    var mostrarPartido = function(num){

        $.getJSON('json/partidosT2prefeito.json', function(p) {
            partidoExiste = false;
            $.each(p.partido, function(i, field){
                if(field.numero == num){
                    $("#partidoNome").text(field.nome);
                    partidoExiste = true;
                }
            });
            if(partidoExiste){
                $("#partidoLabel").show();
                $("#partidoNome").show();
				$("#obs").show();

            }else{
                $("#partidoLabel").hide();
                $("#partidoNome").hide();
                $("#avisoErrado").show();
                $("#avisoNulo").show();
                $("#avisoLegenda").hide();
                $("#obs").hide();
				
            }		
        });
    };

    var mostrarCandidato = function(num,cargo){
    var candidatoExiste = false;
	var numSuplente1;
	var numSuplente2;
	var numVice;
	var numeroPart;
    $.getJSON('json/candidatosT2.json', function(c) {	

            $.each(c, function(i, field){ 
    
                if(i == cargo){
				
					$.each(field, function(i, campo){ 
						//Neste caso, o candidato esta na lista de candidatos do json 
						if(campo.numero == num){
							$("#candidatoNome").text(campo.nome);
							$("#foto").attr("src","image/figuras/161x225/" + campo.foto + ".jpg");
							$("#obs").hide();
							candidatoExiste = true;
							
							numVice = num + 'a';
							 
						}
							
						if(numVice != ''){
							if(campo.numero == num + 'a'){
								$("#vicePrefeitoNome").text(campo.nome);
								$("#fotoVice").attr("src","image/figuras/161x225/" + campo.foto + ".jpg");
							}
						}

							
					});
						
				}               
            });
            
            if(!candidatoExiste){
				//neste ponto é preciso identificar para os cargos proporcionais se os dois primeiros números são de algum partido e portanto teremos voto de legenda.
				numeroPart = num.substring(0, 2);
				if(jQuery.inArray(numeroPart, listaPartidos) != -1) {			
					if(cargo == "senador"){
						$('#candidato').hide();
						$("#cxFoto").hide();
						$('#numeros').show();
						$("#numeroLabel").show();
						$("#cabecalho").show();
						$("#regua").show();
						$("#instrucoes").show();
						$("#avisoInexistente").hide();
						$("#avisoLegenda").hide();
						$('#regua').css("width","545");
						
						$("#partidoLabel").hide();
						$("#partidoNome").hide();
						$("#avisoLegenda").hide();
						$("#avisoErrado").show();
						$("#obs").hide();
						$("#avisoNulo").show();
									
					}else{			
						$('#candidato').hide();
						$("#cxFoto").hide();
						$('#numeros').show();
						$("#numeroLabel").show();
						$("#cabecalho").show();
						$("#regua").show();
						$("#instrucoes").show();
						$("#avisoInexistente").show();
						$("#avisoLegenda").show();
						$('#regua').css("width","545");
						
						$("#partidoLabel").show();
						$("#partidoNome").show();
						$("#avisoLegenda").show();
						$("#avisoErrado").hide();
						$("#obs").hide();
						$("#avisoNulo").hide();
					
					}
				}else{
					$('#candidato').hide();
					$("#cxFoto").hide();
					$('#numeros').show();
					$("#numeroLabel").show();
					$("#cabecalho").show();
					$("#regua").show();
					$("#instrucoes").show();
					$("#avisoLegenda").show();
					$('#regua').css("width","545");
					
					$("#partidoLabel").hide();
					$("#partidoNome").hide();
					$("#avisoLegenda").hide();
					$("#avisoInexistente").hide();
					$("#avisoErrado").show();
					$("#obs").hide();
					$("#avisoNulo").show();
				}

            }else{
				$("#numeroLabel").show();
                $("#cxFoto").show();
                $("#labelCanditato").show();
			    $('#candidato').show();
                $("#candidatoLabel").show();
                $("#candidatoNome").show();
                $("#partidoLabel").show();
                $("#partidoNome").show();
				$("#cabecalho").show();
				$("#regua").show();
				$("#instrucoes").show();
   			    $('#regua').css("width","545");
				
				$("#fotoVice").show();
                $("#cxFotoVice").show();
                $("#labelVice").show(); 
                $("#vicePrefeitoLabel").show(); 
                $("#vicePrefeitoNome").show(); 
				$("#avisoInexistente").hide();
				$("#avisoLegenda").hide();
				$('#regua').css("width","445");
					
			}

        });      

    };

    var habilitaInfo = function(){
        $("#habilitaConfirma").text("true");
        $("#numeroLabel").show();
        $("#cabecalho").show();
        $("#regua").show();
        $("#instrucoes").show();
    }