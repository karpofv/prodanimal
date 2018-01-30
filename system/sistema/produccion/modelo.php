<?php
$opcion = $_POST[actd];
$codigoest = $_POST[codigoest];
$editar = $_POST[editar];
$fecha = $_POST[fecha];
$selmes = $_POST[selmes];
$codigoestab = $_POST[codigoestab];
$selelab = $_POST[selelab];
$fechae = $_POST[fechae];
$seleen = $_POST[seleen];
$selrubro = $_POST[selrubro];
$observ = $_POST[observ];
$codigo = $_POST[codigo];
    if($opcion!=""){
        if($opcion==2){
            $consul_rubros = paraTodos::arrayConsulta("*", "rubros r, rubro_estableci re", "re.rue_rucodigo=ru_codigo and rue_estcodigo=$codigoest");
            foreach($consul_rubros as $rubros){
?>
    <option value="<?php echo $rubros['ru_codigo'];?>"><?php echo $rubros['ru_descripcion'];?></option>
<?php
            }
        }
        if($opcion==3){
            $valida_mes = paraTodos::arrayConsultanum("pr_codigo", "produccion", "pr_estado=1 and pr_mes=$selmes and pr_estcodigo=$codigoestab and pr_rucodigo=$selrubro");
            if($valida>0){
                paraTodos::showMsg("Ya existen proudcciones en el mes seleccionado", "alert-danger");
            } else {
                paraTodos::arrayInserte("pr_codigo,pr_estcodigo, pr_mes, pr_rucodigo, pr_fechaelab, pr_fechatrans, pr_perelab, pr_pertrans, pr_perencuest, pr_observacion, pr_estado", "produccion","$codigoestab,$selmes,$selrubro,'$fechae','$fecha',$selelab,$seleen,$seleen,'$observ',1");
                $consulprcodigo = paraTodos::arrayConsulta("max(pr_codigo) as pr_codigo", "produccion", "pr_estcodigo=$codigoestab");
                echo $consulprcodigo[0]['pr_codigo'];
            }
        }
    } else {
    }
?>