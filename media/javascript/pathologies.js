/**
type== notice,warning,error,success
*/
function showAlert(type,message,selector){
	var iconeClass="success";
	var alertClass="alert-success";
	
	if(type=="notice"){
		iconeClass="icon-info-sign";
		alertClass="alert-info";
	}
	if(type=="warning"){
		iconeClass=" icon-warning-sign";
		alertClass="alert-warning";
	}
	if(type=="success"){
		iconeClass="icon-ok-sign";
		alertClass="alert-success";
	}
	if(type=="error"){
		iconeClass=" icon-remove-sign";
		alertClass="alert-danger";
	}
	
	var html ="<div class=\"alert "+alertClass+" \">"
		+"<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>"
		+"<i class=\" "+iconeClass+" icon-red\"></i>  "+message
	+"</div>";
	$(selector).html(html);
}

/*
function formatNumber(number)
{
    var number = number.toFixed(2) + '';
    var x = number.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ' ' + '$2');
    }
    return x1 + x2;
}*/


function validationEncaissement(){
	$ajax({
		type : "POST",
		async:false,
		url : url,
		contentType:"application/json",
		dataType : "json"
		
	});
}




function getDataChequesFromJson(data){
	var cheques = [];
	var chequesJson = data.tableChequesLitigieux;
	for(var i =0;i<chequesJson.length;i++){
		var json = chequesJson[i];
		console.log(json);
		
		var button ="";
		if(json.encaissable == true){
			button ="<a href=encaisserCheque.action?idCheque="+json.idCheque+"&numDossier="+data.numeroDossier+">"
			+"<button type=\"button\" class=\"btn btnValiderCheque btn-success\">"
			+"<i class=\"icon-pencil icon-white\"></i></button></a>";
		}
		
		cheques.push([json.montant,json.encaisse,json.numcheque,json.resteDu,json.situation,button]);
		
	}
	return cheques;
}



function getResult(url,tableCheques){
	$.ajax({
		type : "GET",
		async:false,
		url : url,
		contentType:"application/json",
		dataType : "json",
		success : function(data, textStatus, request) {	
			
			if(data.data!=null && data.codeRetour!="KO"){
				
				//Bloc Infos
				console.log(data);
				console.log(data.data.nom);
				$('#libelle_nom').text(data.data.nom);
				$('#libelle_prenom').text(data.data.prenom);
				//$('#libelle_montantRepartir').text(/*formatNumber(*/data.data.montantRepartir/*) + " EUR"*/);
				$('#numDossierAffiche').text(data.data.numeroDossier);
				var date = data.data.dateEncaissement;
				var maDate = new Date(date);
				var day = (maDate.getDate() + 1);
				day= (day < 10) ? '0'+day : day; 
				var month = maDate.getMonth();
				month = (month < 10) ? '0'+month : month;
				var year = maDate.getFullYear();
				$('#libelle_dateEncaissement').text(day+ '/' + month + '/' +  year);
				$(".blocInfos").show();
				
				//Bloc du tableau
				var cheques =getDataChequesFromJson(data.data);
				if(cheques.length==0){
					showAlert("notice",$(".messages .noresultfound").html(),".message_alert");
				}
				
				if(cheques.length>0){
					$('.blocTable').show();
					
					
					tableCheques.DataTable( {
				        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "Tout"]],
				        "language": {
				            "url": "../../js/jquery.DataTables.language.French.json"
				        },
				        destroy: true,
				        data: cheques
					});
					
				    }else{
						$('.blocTable').hide();
						$('.blocInfos').hide();
					}
				
				}
			},
		error : function() {
			alert("Erreur(s) lors du chargement");
		}
});
}


function verifChamps(){
	var result = true;
	if($("#numDossier").val()!=""){
    	$("#numDossier").closest("div").removeClass("has-error");
	}else{
		result = false;
		$("#numDossier").closest("div").addClass("has-error");
	}

	if($("#codeOrgRecep").val()!=""){
    	$("#codeOrgRecep").closest("div").removeClass("has-error");
	}else{
		result = false;
		$("#codeOrgRecep").closest("div").addClass("has-error");
	}
	
	/*if($("#libelle_montantRepartir").text()!=""){
    	montant_repartir =$("#libelle_montantRepartir").text() ;
	}*/
	return result;
}

$(document).ready(function(){

	$('.blocInfos').hide();
	$('.blocTable').hide();
	
	montant_repartir = "";
	
	/*$('#btnValiderCheque').on('click',function(){
		$('#btnValiderCheque').disable = true;
	});
	*/
	
	
	$('#enregistrementPaiement').on('click',function(){
    	var url =$('#contextPath').text()+"enregistrementPaiement.action";
    	document.location.href=url;
    });
	
	
	$('#numDossier').on('change',function(){
    	if(verifChamps()){
    		$(".errorMessages").hide();
    		var numDossier = $("#numDossier").val();
    		var codeOrgRecep = $("#codeOrgRecep").val();
    		var deviseCode= $("#code").val();
    		var url =$('#contextPath').text()+"/encaissement/encaisser/results.action?numDossier="+numDossier+"&codeOrgRecep="+codeOrgRecep+"&code="+deviseCode;
    		getResult(url,$('#tableChequesLitigieux'));
    	}else{
    		$(".errorMessages").show();
    	}
	});
	
	$('fraisEtReliquat').on('click',function(){
		var numDossier = $("#numDossierString").val();
		$ajax({
			type : "POST",
			async:false,
			url : $('#contextPath').text()+"/encaissement/encaisser/fraisEtReliquat.action?numDossier="+numDossier,
			contentType:"application/json",
			dataType : "json"
			
		});
	})
	
	$('#btnSearch').on('click',function(){
		if(verifChamps()){
    		$(".errorMessages").hide();
    		var numDossier = $("#numDossier").val();
    		var codeOrgRecep = $("#codeOrgRecep").val();
    		var deviseCode=$("#code").val();
    		var url =$('#contextPath').text()+"/encaissement/encaisser/results.action?numDossier="+numDossier+"&codeOrgRecep="+codeOrgRecep+"&code="+deviseCode;
    		getResult(url,$('#tableChequesLitigieux'));
    	}else{
    		$(".errorMessages").show();
    	}
	 });
	
	
	
	
});


