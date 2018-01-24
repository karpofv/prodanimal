$("#btncancel").click(function(){
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');
    $("#btnsave").html('GUARDAR');
});
$('#distrib_rubro').DataTable({
    "language": {
        "url": "<?php echo $ruta_base;?>/assets/js/Spanish.json"
    }
});
