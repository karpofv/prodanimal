$("#btncancel").click(function(){
	$('input[type="text"]').val('');
	$('input[type="number"]').val('');
	$('input[type="date"]').val('');
    $("#btnsave").html('GUARDAR');    
});
$('#establecimiento').DataTable({
    "language": {
        "url": "<?php echo $ruta_base;?>/assets/js/Spanish.json"
    }
});
