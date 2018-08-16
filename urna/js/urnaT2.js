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
