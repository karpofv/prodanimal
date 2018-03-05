<?php
	/* incluimos primeramente el archivo que contiene la clase fpdf */
	date_default_timezone_set('UTC');
    error_reporting(E_ALL);
    ini_set('display_errors', false);
    ini_set('display_startup_errors', false);        
require('../../../includes/fpdf/fpdf.php');
include('../../../includes/tools.php');
include('../../../includes/conexion.php');
	header("Content-Type: text/html; charset='latin1'");
	class PDF extends FPDF{
		var $widths;
		var $aligns;
	}

$pdf=new FPDF('l','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
$codigo = filter_input(INPUT_GET, id);
$result = paraTodos::arrayConsulta("*", "produccion pr, establecimiento e, rubros r, municipio m, parroquia p", "pr.pr_codigo=".$codigo." and pr.pr_estcodigo=e.est_codigo and pr.pr_rucodigo=r.ru_codigo and e.est_muncodigo=m.mun_codigo and e.est_parcodigo=p.par_codigo");
if($result[0]['pr_mes']==1){
	$mes = 'ENERO';
}
if($result[0]['pr_mes']==2){
	$mes = 'FEBRERO';
}
if($result[0]['pr_mes']==3){
	$mes = 'MARZO';
}
if($result[0]['pr_mes']==4){
	$mes = 'ABRIL';
}
if($result[0]['pr_mes']==5){
	$mes = 'MAYO';
}
if($result[0]['pr_mes']==6){
	$mes = 'JUNIO';
}
if($result[0]['pr_mes']==7){
	$mes = 'JULIO';
}
if($result[0]['pr_mes']==8){
	$mes = 'AGOSTO';
}
if($result[0]['pr_mes']==9){
	$mes = 'SEPTIEMBRE';
}
if($result[0]['pr_mes']==10){
	$mes = 'OCTUBRE';
}
if($result[0]['pr_mes']==11){
	$mes = 'NOVIEMBRE';
}
if($result[0]['pr_mes']==12){
	$mes = 'DICIEMBRE';
}
$pdf->Cell(0,4,utf8_decode('SEA________________'),0,1,'R');
$pdf->Cell(80,12,utf8_decode(''),0,0,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(120,12,utf8_decode('BENEFICIO APÍCOLA'),0,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(80,5,utf8_decode('I. IDENTIFICACIÒN'),1,1,'L');
$pdf->Cell(80,12,utf8_decode(''),0,0,'C');
$pdf->Cell(120,5,utf8_decode(''),0,0,'C');
$pdf->Cell(60,5,utf8_decode('1.-MUNICIPIO'),1,0,'C');
$pdf->Cell(20,5,utf8_decode('2.-MES'),1,1,'C');
$pdf->Cell(80,5,utf8_decode(''),0,0,'C');
$pdf->Cell(120,12,utf8_decode(''),0,0,'C');
$pdf->Cell(6,5,utf8_decode(''),1,0,'C');
$pdf->Cell(6,5,utf8_decode(''),1,0,'C');
$pdf->SetFont('Arial','',6);
$pdf->Cell(48,5,utf8_decode($result[0]['mun_descrip']),1,0,'C');
$pdf->Cell(20,5,utf8_decode($mes),1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Ln(4);
$pdf->Cell(90,5,utf8_decode('4.- PARROQUIA'),1,0,'C');
$pdf->Cell(110,5,utf8_decode('5.- NOMBRE DE LA EXPLOTACIÓN O ESTABLECIMIENTO'),1,0,'C');
$pdf->Cell(80,5,utf8_decode('6.- NOMBRE DEL PROPIETARIO O RAZON SOCIAL'),1,1,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(5,5,utf8_decode(''),1,0,'C');
$pdf->Cell(5,5,utf8_decode(''),1,0,'C');
$pdf->Cell(80,5,utf8_decode($result[0]['par_descrip']),1,0,'C');
$pdf->Cell(5,5,utf8_decode(''),1,0,'C');
$pdf->Cell(105,5,utf8_decode($result[0]['est_nombre']),1,0,'C');
$pdf->Cell(80,5,utf8_decode($result[0]['est_propietario']),1,1,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Ln(4);
$pdf->Cell(200,5,utf8_decode('II. PRODUCCIÓN APÍCOLA'),1,0,'L');
$pdf->Cell(50,5,utf8_decode('DIRECCIÓN:'),0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,10,utf8_decode('7.- TIPO DE ANIMAL'),1,0,'C');
$pdf->Cell(30,10,utf8_decode('8.- PRODUCCIÓN'),1,0,'C');
$pdf->Cell(100,5,utf8_decode('9.- DISTRIBUCIÓN DE LA PRODUCCIÓN'),1,1,'C');
$pdf->Cell(70,10,utf8_decode(''),0,0,'C');
$pdf->Cell(30,10,utf8_decode(''),0,0,'C');
$pdf->Cell(50,5,utf8_decode('INDUSTRIA'),1,0,'C');	
$pdf->Cell(50,5,utf8_decode('EMBASADOR'),1,0,'C');	
$pdf->Ln(5);
$queryp = paraTodos::arrayConsulta("rt.rut_descripcion,SUM(pd.prd_cantidad)  as cantidad", "produccion_detalle pd, produccion p, rubro_tipo rt", "p.pr_codigo=pd.prd_prcodigo and p.pr_codigo=".$result[0]['pr_codigo']." and pd.prd_rutcodigo=rt.rut_codigo GROUP BY rt.rut_descripcion");
foreach ($queryp as $resultp){
	$pdf->Cell(70,5,utf8_decode($resultp['rut_descripcion']),1,0,'C');
	$pdf->Cell(30,5,utf8_decode($resultp['cantidad']),1,0,'C');
        $resultd = paratodos::arrayConsulta("rt.rut_descripcion,pm.prmov_cantidad", "produccion p, produccion_detalle pd, produccion_movimiento pm, rubros r, tipos_medidas tm, rubro_tipo rt", "p.pr_codigo=pd.prd_prcodigo and pd.prd_codigo=pm.prmov_prdcodigo and p.pr_codigo=".$codigo." and p.pr_rucodigo=r.ru_codigo and tm.tip_rucodigo=r.ru_codigo AND tm.tip_codigo=pm.prmov_tipcodigo and tm.tip_medida='INDUSTRIA' and rt.rut_rucodigo=r.ru_codigo and rt.rut_descripcion='".$resultp['rut_descripcion']."'  and pm.prmov_estado='ACTIVO'");
	$pdf->Cell(50,5,utf8_decode($resultd[0]['prmov_cantidad']),1,0,'C');
        $resultd = paraTodos::arrayConsulta("rt.rut_descripcion,pm.prmov_cantidad", "produccion p, produccion_detalle pd, produccion_movimiento pm, rubros r, tipos_medidas tm, rubro_tipo rt", "p.pr_codigo=pd.prd_prcodigo and pd.prd_codigo=pm.prmov_prdcodigo and p.pr_codigo=".$codigo." and p.pr_rucodigo=r.ru_codigo and tm.tip_rucodigo=r.ru_codigo AND tm.tip_codigo=pm.prmov_tipcodigo and tm.tip_medida='EMBASADORA' and rt.rut_rucodigo=r.ru_codigo and rt.rut_descripcion='".$resultp['rut_descripcion']."'  and pm.prmov_estado='ACTIVO'");
	$pdf->Cell(50,5,utf8_decode($resultd[0]['prmov_cantidad']),1,1,'C');
}
$pdf->Ln(9);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(250,5,utf8_decode('III. DESTINO DE LA PRODUCCIÓN'),1,1,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(90,5,utf8_decode('ENTIDAD'),1,0,'C');
$pdf->Cell(40,5,utf8_decode('MIEL'),1,0,'C');
$pdf->Cell(40,5,utf8_decode('CERA'),1,0,'C');
$pdf->Cell(40,5,utf8_decode('POLEN'),1,0,'C');
$pdf->Cell(40,5,utf8_decode('JALEA REAL'),1,0,'C');
$pdf->Ln(5);
$queryd = paraTodos::arrayConsulta("prdes_entidad", "produccion_destino pds", "pds.prdes_estado='ACTIVO' and pds.prdes_prcodigo=$codigo GROUP BY prdes_entidad");
	foreach ($queryd as $resultd ){	
		$pdf->Cell(90,5,utf8_decode($resultd['prdes_entidad']),1,0,'C');
                $resultd1 = paraTodos::arrayConsulta("prdes_unidad", " produccion_destino pds, rubro_tipo r", "pds.prdes_rutcodigo=r.rut_codigo and pds.prdes_prcodigo=$codigo and prdes_entidad='".$resultd['prdes_entidad']."' and r.rut_descripcion='MIEL'  AND pds.prdes_estado='ACTIVO'");
		$pdf->Cell(40,5,utf8_decode($resultd1[0]['prdes_unidad']),1,0,'C');
                $resultd1 = paraTodos::arrayConsulta("prdes_unidad", "produccion_destino pds, rubro_tipo r", "pds.prdes_rutcodigo=r.rut_codigo and pds.prdes_prcodigo=$codigo and prdes_entidad='".$resultd['prdes_entidad']."' and r.rut_descripcion='CERA'  AND pds.prdes_estado='ACTIVO'");
		$pdf->Cell(40,5,utf8_decode($resultd1[0]['prdes_unidad']),1,0,'C');
                $resultd1 = paraTodos::arrayConsulta("prdes_unidad", "produccion_destino pds, rubro_tipo r", "pds.prdes_rutcodigo=r.rut_codigo and pds.prdes_prcodigo=$codigo and prdes_entidad='".$resultd['prdes_entidad']."' and r.rut_descripcion='POLEN'  AND pds.prdes_estado='ACTIVO'");
		$pdf->Cell(40,5,utf8_decode($resultd1[0]['prdes_unidad']),1,0,'C');
                $resultd1 = paraTodos::arrayConsulta("prdes_unidad", "produccion_destino pds, rubro_tipo r", "pds.prdes_rutcodigo=r.rut_codigo and pds.prdes_prcodigo=$codigo and prdes_entidad='".$resultd['prdes_entidad']."' and r.rut_descripcion='JALEA REAL'  AND pds.prdes_estado='ACTIVO'");
		$pdf->Cell(40,5,utf8_decode($resultd1[0]['prdes_unidad']),1,1,'C');
	}
$pdf->Ln(9);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(280,5,utf8_decode('IV.- DATOS DEL INFORMANTE'),1,1,'L');
$pdf->SetFont('Arial','',8);

$pdf->Cell(80,10,utf8_decode('10.- NOMBRES Y APELLIDOS'),1,0,'C');
$pdf->Cell(60,10,utf8_decode('11.- CARGO'),1,0,'C');
$pdf->Cell(50,10,utf8_decode('12.- TELÉFONO'),1,0,'C');
$pdf->Cell(54,10,utf8_decode('13.- FECHA DE ELABORACIÓN'),1,0,'C');
$pdf->SetFont('Arial','B',7);
$pdf->MultiCell(36,5,utf8_decode('FIRMA DEL INFORMANTE Y SELLO DE LA EMPRESA'),1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->ln(-5);
$resulte = paraTodos::arrayConsulta("p.per_nombres as nomelab,p.per_apellidos apeelab,p.per_cargo cargelab,p.per_telefono telefelab, p1.per_nombres as nomtrans,p1.per_apellidos apetrans,p1.per_cargo cargtrans,p1.per_telefono teleftrans, p2.per_nombres as nomenc,p2.per_apellidos apeenc,p2.per_cargo cargenc,p2.per_telefono telefenc", "produccion pr LEFT JOIN personal p on p.per_codigo=pr.pr_perelab LEFT JOIN personal p1 on p1.per_codigo=pr.pr_pertrans LEFT JOIN personal p2 on p2.per_codigo=pr.pr_perencuest", "pr.pr_codigo=$codigo");
$pdf->Cell(80,5,utf8_decode(''),0,0,'C');
$pdf->Cell(60,5,utf8_decode(''),0,0,'C');
$pdf->Cell(50,5,utf8_decode(''),0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(80,10,utf8_decode($resulte[0]['apeelab']." ".$resulte[0]['nomelab']),1,0,'C');
$pdf->Cell(60,10,utf8_decode($resulte[0]['cargelab']),1,0,'C');
$pdf->Cell(50,10,utf8_decode($resulte[0]['telefelab']),1,0,'C');
$pdf->Cell(54,10,utf8_decode($result[0]['pr_fechaelab']),1,0,'C');
$pdf->Cell(36,10,utf8_decode(''),1,1,'C');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(280,5,utf8_decode('V.- DATOS DE LEVANTAMIENTO Y TRANSCRIPCIÓN'),1,1,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(80,10,utf8_decode('14.- APELLIDO Y NOMBRE DEL ENCUESTADOR'),1,0,'C');
$pdf->Cell(30,10,utf8_decode('FIRMA'),1,0,'C');
$pdf->Cell(80,10,utf8_decode('15.- APELLIDO Y NOMBRE DEL TRANSCRIPTOR'),1,0,'C');
$pdf->Cell(54,10,utf8_decode('13.- FECHA DE ELABORACIÓN'),1,0,'C');
$pdf->SetFont('Arial','B',7);
$pdf->MultiCell(36,10,utf8_decode('FIRMA DEL TRANSCRIPTOR'),1,'C');
$pdf->SetFont('Arial','',8);
$pdf->ln(-5);
$pdf->Cell(80,5,utf8_decode(''),0,0,'C');
$pdf->Cell(30,5,utf8_decode(''),0,0,'C');
$pdf->Cell(80,5,utf8_decode(''),0,1,'C');
$pdf->Cell(80,10,utf8_decode($resulte[0]['apeenc']." ".$resulte[0]['nomenc']),1,0,'C');
$pdf->Cell(30,10,utf8_decode(''),1,0,'C');
$pdf->Cell(80,10,utf8_decode($resulte[0]['apetrans']." ".$resulte[0]['nomtrans']),1,0,'C');
$pdf->Cell(54,10,utf8_decode($result[0]['pr_fechatrans']),1,0,'C');
$pdf->Cell(36,10,utf8_decode(''),1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(36,10,utf8_decode('OBSERVACIONES'),0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(280,10,utf8_decode($result[0]['pr_observacion']),0,'J');
$pdf->SetXY(220,50);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(0,15,utf8_decode($result[0]['est_direccion']),0,'L');
$pdf->Output();