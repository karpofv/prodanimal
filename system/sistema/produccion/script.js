function addestablec(codigo, mun, nombre){
	$("#establec").val(nombre);
	$("#codigoestab").val(codigo);
	$("#VentanaVer").html( "" );
}
$("#fecha").focusout(function(){
	if($("#fecha").val()<$("#fechae").val()){
		$("#alertfec").removeClass("collapse");	
		$("#btnsavedg").attr("disabled", true);
	}else{
		$("#alertfec").addClass("collapse");
		$("#btnsavedg").attr("disabled",false);		
	}
});
$("#fechae").focusout(function(){
	if($("#fecha").val()<$("#fechae").val()){
		$("#alertfec").removeClass("collapse");
		$("#btnsavedg").attr("disabled", true);
	}else{
		$("#alertfec").addClass("collapse");
		$("#btnsavedg").attr("disabled",false);
	}
});