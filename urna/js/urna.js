$(function (){
    //Tratamento para execução dos áudios de um cargo para outro - inter.mp3 / inter.wav
    var url = location.href;
    if (url.indexOf("?") > 0) {
        var arr = url.split('?');
        var param = arr[1].split("=");
        //Verifica se audio igual a um, isso aciona o play do audio
        if (param[0] == "audio" && param[1] == 1){
            var song = $('#audioInter');
			try { song.get(0).play(); } catch(e){}
        }
    }

    $('.listaCandidatos').slick({
        dots: false,
        infinite: false,
        speed: 1000,
        slidesToShow: 1,
        touchMove: true,
        slidesToScroll: 1
    });

    $( ".listaCandidatos" ).animate({
                top: "5"
       }, 3000, function() {
    });

    //Definição para todos os botões de alteração do mouse para mão
    for(i = 0; i <= 9; i++){
        $('#n_' + i).css('cursor', 'pointer');
    }
    $('#branco').css('cursor', 'pointer');
    $('#corrige').css('cursor', 'pointer');
    $('#confirma').css('cursor', 'pointer');

    //pulsar as bordas da caixa de número na entrada de cada cargo
    $("#cxNumero1").effect( "pulsate", {times:40}, 50000 );

    //Cor das letras que ficam piscando
    var properties = {
       color : '#808080'
    };

    //Pulsar os avisos de nulo, branco e voto de legenda
    var el = $('#avisoNulo,#avisoBranco,#obs,#avisoLegenda');
    el.pulse(properties, {
        duration : 1000,
        pulses : 20000
    });

    $(this).mousedown(function (e) {

        var ide = e.target.id;

        //Aqui serão feitas as ações quando se aperta o botão BRANCO
        if(ide == "branco"){

            if($("#cxNumero1").text().length == 0){
                $('#' + ide).attr("src","image/" + ide + "_down.jpg");
                $('#cxFoto').hide();
                $('#cxFotoVice').hide();
                $('#numeros').hide();
                $('#candidato').hide();
				$('#partidoNome').hide();
			    $('#partidoLabel').hide();
                $('#avisoErrado').hide();
                $('#avisoLegenda').hide();
                $('#obs').hide();
                $('#avisoNulo').hide();
                $('#avisoInexistente').hide();
                $('#avisoBranco').show();
                $('#regua').css("width","545");
                $("#cabecalho").show();
                $("#regua").show();
                $("#instrucoes").show();
                //Flag utilizada para habilitar/desabilitar o botao Confirma
                $("#habilitaConfirma").text("true");
                //Flag utilizada para habilitar/desabilitar utilização dos botoes numéricos
                $("#habilitaNumeros").text("false");
                //Flag utilizada para habilitar/desabilitar utilização do botao Corrige
                $("#habilitaCorrige").text("true");
                return false;

            }else{
                try { $('#audioOps').get(0).play(); } catch(e){}
                notifica('information','Para votar em <strong>BRANCO</strong> <br /> o campo de voto deve estar vazio.<br /> Aperte CORRIGE para apagar o campo de voto.<br /><br />[ FECHAR ]');
            }

        }

        //Aqui serão feitas as ações quando se aperta o botão CORRIGE
        if(ide == "corrige"){

			if($("#habilitaCorrige").text() == "true"){
				$('#' + ide).attr("src","image/" + ide + "_down.jpg");
				$('#cxFoto').hide();
				$('#candidato').hide();
				$('#labelCanditato').hide();
				$("#cxFotoVice").hide();
				$("#labelVice").hide();
				$("#viceGovernadorLabel").hide();
				$("#viceGovernadorNome").hide();
				$("#fotoVice").hide();
				$('#cxFotoSup1').hide();
				$('#labelSuplente1').hide();
				$('#suplente1Label').hide();
				$('#suplente1Nome').hide();
				$('#cxFotoSup2').hide();
				$('#labelSuplente2').hide();
				$('#suplente2Label').hide();
				$('#suplente2Nome').hide();
				$('#cxNumero1').text('');
				$('#cxNumero2').text('');
				$('#cxNumero3').text('');
				$('#cxNumero4').text('');
				$('#cxNumero5').text('');
				$('#numeroLabel').hide();
				$('#numeros').show();
				$('#partidoNome').text('');
				$('#partidoLabel').hide();
				$('#cabecalho').hide();
				$("#regua").hide();
				$("#instrucoes").hide();
				$('#avisoBranco').hide();
				$('#avisoErrado').hide();
				$('#avisoNulo').hide();
				$('#avisoInexistente').hide();
				$('#avisoLegenda').hide();
				$("#habilitaConfirma").text("false");
				$("#cxNumero2").finish();
				$("#cxNumero3").finish();
				$("#cxNumero4").finish();
				$("#cxNumero5").finish();
				$("#cxNumero1").effect( "pulsate", {times:20}, 25000 );

				$("#habilitaNumeros").text("true");
                //Flag utilizada para habilitar/desabilitar utilização do botao Corrige
                $("#habilitaCorrige").text("false");
				return false;

			} else {
                try { $('#audioOps').get(0).play(); } catch(e){}
                notifica('information','Para utilizar o <strong>CORRIGE</strong> <br /> você deve ter digitado algum número<br /> ou ter votado em BRANCO. <br /><br />[ FECHAR ]');

			}
        }

    });

    $(this).mouseup(function (e) {
            var ide = e.target.id;

            if(ide == "branco"){
               $('#' + ide).attr("src","image/" + ide + ".jpg");
            }

            if(ide == "corrige"){
               $('#' + ide).attr("src","image/" + ide + ".jpg");
            }

            if(ide == "confirma"){
               $('#' + ide).attr("src","image/" + ide + ".jpg");
            }

            if(ide.substring(0, 2) == 'n_'){
               $('#' + ide).attr("src","image/" + ide.substr(0, 1) + ide.substr(2, 1) + ".jpg");
            }

    });



});

	var listaPartidos = new Array("91", "92", "93", "94", "95");

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

	    $.ajax({
        'url': '/urna/json/partidos.json',
        'type': 'get',

        'success': function (p) {

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
        },
		error: function(XMLHttpRequest, textStatus, errorThrown){
        alert(errorThrown);
    }
    }); 

    };

    var mostrarCandidato = function(num,cargo){
    var candidatoExiste = false;
	var numSuplente1;
	var numSuplente2;
	var numVice;
	var numeroPart;
    $.getJSON('json/candidatos.json', function(c) {

            $.each(c, function(i, field){
                if(i == cargo){
					$.each(field, function(i, campo){
						//Neste caso, o candidato esta na lista de candidatos do json
						if(campo.numero == num){
							$("#candidatoNome").text(campo.nome);
							//Recupera as fotos no sub-diretório
							if(cargo == 'vereador'){
								$("#foto").attr("src","image/figuras/111x155/" + campo.foto + ".jpg");

							}else if(cargo == 'prefeito'){
								$("#foto").attr("src","image/figuras/161x225/" + campo.foto + ".jpg");

							}else{
								$("#foto").attr("src","image/figuras/135x145/8bpp/" + campo.foto + ".jpg");
							}
							$("#obs").hide();
							candidatoExiste = true;

							if(cargo == "senador"){
								numSuplente1 = num + 'a';
								numSuplente2 = num + 'b';

							} else if(cargo == "governador"){
								numVice = num + 'a';

							} else if(cargo == "presidente"){
								numVice = num + 'a';

							} else if(cargo == "prefeito"){
								numVice = num + 'a';

							}
						}

						if(numSuplente1 != ''){
							if(campo.numero == num + 'a'){
								$("#suplente1Nome").text(campo.nome);
								$("#fotoSup1").attr("src","image/figuras/95x105/8bpp/" + campo.foto + ".jpg");
							}
						}

						if(numSuplente2 != ''){
							if(campo.numero == num + 'b'){
								$("#suplente2Nome").text(campo.nome);
								$("#fotoSup2").attr("src","image/figuras/95x105/8bpp/" + campo.foto + ".jpg");
							}
						}

						if(numVice != ''){
							if(campo.numero == num + 'a'){
								$("#viceGovernadorNome").text(campo.nome);
								if(cargo == "prefeito"){
									$("#fotoVice").attr("src","image/figuras/161x225/" + campo.foto + ".jpg");
								}else{
									$("#fotoVice").attr("src","image/figuras/95x105/8bpp/" + campo.foto + ".jpg");
								}
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

				if(cargo == "senador"){
                    $("#fotoSup1").show();
					$("#cxFotoSup1").show();
                    $("#labelSuplente1").show();
					$("#suplente1Label").show();
					$("#suplente1Nome").show();
					$("#fotoSup2").show();
					$("#cxFotoSup2").show();
                    $("#labelSuplente2").show();
					$("#suplente2Label").show();
					$("#suplente2Nome").show();
     				$('#regua').css("width","345");

				}else if(cargo == "governador"){
					$("#fotoVice").show();
                    $("#cxFotoVice").show();
                    $("#labelVice").show();
                    $("#viceGovernadorLabel").show();
                    $("#viceGovernadorNome").show();
					$("#avisoInexistente").hide();
					$("#avisoLegenda").hide();
					$('#regua').css("width","445");

                }else if(cargo == "presidente"){
					$("#fotoVice").show();
                    $("#cxFotoVice").show();
                    $("#labelVice").show();
                    $("#viceGovernadorLabel").show();
                    $("#viceGovernadorNome").show();
					$('#regua').css("width","445");

                }else if(cargo == "prefeito"){
					$("#fotoVice").show();
                    $("#cxFotoVice").show();
                    $("#labelVice").show();
                    $("#vicePrefeitoLabel").show();
                    $("#vicePrefeitoNome").show();
					$('#regua').css("width","445");

				}

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
