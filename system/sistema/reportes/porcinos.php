<?php
	/* incluimos primeramente el archivo que contiene la clase fpdf */
	date_default_timezone_set('UTC');	
require('../recursos/fpdf/fpdf.php');
include('../config/conexion.php');
	header("Content-Type: text/html; charset='latin1'");
	class PDF extends FPDF{
		var $widths;
		var $aligns;
// Cargar los datos
function LoadData($file)
{
	$data= consul_carfamcarnet($file);
    return $data;
}

// Tabla simple
function BasicTable($header, $data)
{
    // Cabecera
    foreach($header as $col)
        $this->Cell(35,7,$col,2);
    $this->Ln();
    // Datos
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(35,6,$col,1);
        $this->Ln();
    }
}

// Una tabla más completa
function ImprovedTable($header, $data)
{
    // Anchuras de las columnas
    $w = array(40, 35, 45, 40);
    // Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Datos
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

// Tabla coloreada
function FancyTable($header, $data)
{
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $w = array(40, 35, 45, 40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}				
		function SetWidths($w){
	    	//Set the array of column widths
    		$this->widths=$w;
		}
		function SetAligns($a){
	    	//Set the array of column alignments
    		$this->aligns=$a;
		}
		function Row($data){
	    	//Calculate the height of the row
    		$nb=0;
	    	for($i=0;$i<count($data);$i++)
       	 	$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    		$h=5*$nb;
    		//Issue a page break first if needed
    		$this->CheckPageBreak($h);
    		//Draw the cells of the row
    		for($i=0;$i<count($data);$i++){
        		$w=$this->widths[$i];
        		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        		//Save the current position
        		$x=$this->GetX();
        		$y=$this->GetY();
        		//Draw the border
        		$this->Rect($x,$y,$w,$h);
        		//Print the text
        		$this->MultiCell($w,5,$data[$i],0,$a);
        		//Put the position to the right of the cell
        		$this->SetXY($x+$w,$y);
    		}
    		//Go to the next line
    		$this->Ln($h);
		}
		function CheckPageBreak($h){
    		//If the height h would cause an overflow, add a new page immediately
   			if($this->GetY()+$h>$this->PageBreakTrigger)
        	$this->AddPage($this->CurOrientation);
		}
		function NbLines($w,$txt){
    		//Computes the number of lines a MultiCell of width w will take
    		$cw=&$this->CurrentFont['cw'];
    		if($w==0)
        	$w=$this->w-$this->rMargin-$this->x;
    		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    		$s=str_replace("\r",'',$txt);
    		$nb=strlen($s);
    		if($nb>0 and $s[$nb-1]=="\n")
        	$nb--;
    		$sep=-1;
    		$i=0;
    		$j=0;
    		$l=0;
    		$nl=1;
    		while($i<$nb){
        		$c=$s[$i];
        		if($c=="\n"){
            		$i++;
            		$sep=-1;
            		$j=$i;
            		$l=0;
            		$nl++;
            		continue;
        		}
        		if($c==' ')
            	$sep=$i;
        		$l+=$cw[$c];
        		if($l>$wmax){
            		if($sep==-1){
                		if($i==$j)
                    	$i++;
            		}
            		else
                		$i=$sep+1;
            			$sep=-1;
            			$j=$i;
            			$l=0;
            			$nl++;
        		}
        		else
            		$i++;
    		}
    		return $nl;
		}
	}

$pdf=new FPDF('l','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
$query = mysqli_query("select * from produccion pr, establecimiento e, rubros r, municipio m, parroquia p WHERE pr.pr_codigo=".$_GET['id']." and pr.pr_estcodigo=e.est_codigo and pr.pr_rucodigo=r.ru_codigo and e.est_muncodigo=m.mun_codigo and e.est_parcodigo=p.par_codigo");
$result = mysqli_fetch_array($query);
if($result['pr_mes']==1){
	$mes = 'ENERO';
}
if($result['pr_mes']==2){
	$mes = 'FEBRERO';
}
if($result['pr_mes']==3){
	$mes = 'MARZO';
}
if($result['pr_mes']==4){
	$mes = 'ABRIL';
}
if($result['pr_mes']==5){
	$mes = 'MAYO';
}
if($result['pr_mes']==6){
	$mes = 'JUNIO';
}
if($result['pr_mes']==7){
	$mes = 'JULIO';
}
if($result['pr_mes']==8){
	$mes = 'AGOSTO';
}
if($result['pr_mes']==9){
	$mes = 'SEPTIEMBRE';
}
if($result['pr_mes']==10){
	$mes = 'OCTUBRE';
}
if($result['pr_mes']==11){
	$mes = 'NOVIEMBRE';
}
if($result['pr_mes']==12){
	$mes = 'DICIEMBRE';
}
$pdf->Image('../recursos/img/mppa.jpg',10,10,50,20,'');
$pdf->Cell(80,12,utf8_decode(''),0,0,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(120,12,utf8_decode('BENEFICIO DE PORCINOS'),0,0,'C');
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
$pdf->Cell(48,5,utf8_decode($result['mun_descrip']),1,0,'C');
$pdf->Cell(20,5,utf8_decode($mes),1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Ln(4);
$pdf->Cell(70,5,utf8_decode('4.- PARROQUIA'),1,0,'C');
$pdf->Cell(40,5,utf8_decode('5.- TIPO DE MATADERO'),1,0,'C');
$pdf->Cell(90,5,utf8_decode('5.- NOMBRE DE LA EXPLOTACIÓN O ESTABLECIMIENTO'),1,0,'C');
$pdf->Cell(80,5,utf8_decode('6.- NOMBRE DEL PROPIETARIO O RAZON SOCIAL'),1,1,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(5,5,utf8_decode(''),1,0,'C');
$pdf->Cell(5,5,utf8_decode(''),1,0,'C');
$pdf->Cell(60,5,utf8_decode($result['par_descrip']),1,0,'C');
$pdf->Cell(40,5,utf8_decode($result['est_tipo']),1,0,'C');
$pdf->Cell(5,5,utf8_decode(''),1,0,'C');
$pdf->Cell(85,5,utf8_decode($result['est_nombre']),1,0,'C');
$pdf->Cell(80,5,utf8_decode($result['est_propietario']),1,1,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Ln(4);
$pdf->Cell(200,5,utf8_decode('II. REGISTRO DE BENEFICIO DE PORCINOS'),1,0,'L');
$pdf->Cell(50,5,utf8_decode('DIRECCIÓN:'),0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,10,utf8_decode('7.- TIPO DE ANIMAL'),1,0,'C');
$pdf->Cell(30,10,utf8_decode('8.- Nº DE CABEZAS'),1,0,'C');
$pdf->Cell(50,5,utf8_decode('9.- TOTAL KILOGRAMOS'),1,0,'C');
$pdf->Cell(50,5,utf8_decode('PESO PROMEDIO'),1,1,'C');
$pdf->Cell(70,10,utf8_decode(''),0,0,'C');
$pdf->Cell(30,10,utf8_decode(''),0,0,'C');
$pdf->Cell(25,5,utf8_decode('10.- EN PIE'),1,0,'C');	
$pdf->Cell(25,5,utf8_decode('11.- EN CANAL'),1,0,'C');
$pdf->Cell(25,5,utf8_decode('10.- EN PIE'),1,0,'C');	
$pdf->Cell(25,5,utf8_decode('11.- EN CANAL'),1,0,'C');
$pdf->Ln(5);
$queryp = mysqli_query("SELECT rt.rut_descripcion,SUM(pd.prd_cantidad)  as cantidad  from produccion_detalle pd, produccion p, rubro_tipo rt where p.pr_codigo=pd.prd_prcodigo and p.pr_codigo=".$result['pr_codigo']." and pd.prd_rutcodigo=rt.rut_codigo GROUP BY rt.rut_descripcion");
while ($resultp = mysqli_fetch_array($queryp)){
	$pdf->Cell(70,5,utf8_decode($resultp['rut_descripcion']),1,0,'C');
	$pdf->Cell(30,5,utf8_decode($resultp['cantidad']/1),1,0,'C');
	$queryd = mysqli_query("SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm WHERE p.pr_codigo=".$result['pr_codigo']." and p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='EN PIE' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo group BY pd.prd_rutcodigo,rt.rut_descripcion order BY pd.prd_rutcodigo");
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(25,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');
	$queryd1 = mysqli_query("SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm WHERE p.pr_codigo=".$result['pr_codigo']." and p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='EN CANAL' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo group BY pd.prd_rutcodigo,rt.rut_descripcion order BY pd.prd_rutcodigo");
	$resultd1 = mysqli_fetch_array($queryd1);	
	$pdf->Cell(25,5,utf8_decode($resultd1['prd_cantidad']/1),1,0,'C');
	$pdf->Cell(25,5,utf8_decode($resultd['prd_cantidad']/$resultp['cantidad']),1,0,'C');
	$pdf->Cell(25,5,utf8_decode($resultd1['prd_cantidad']/$resultp['cantidad']),1,1,'C');	
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(280,5,utf8_decode('III. PROCEDENCIA Y DESTINO DE LA PRODUCCION'),1,1,'L');
$pdf->Cell(140,5,utf8_decode('12.- PROCEDENCIA DE LA PRODUCCION'),1,0,'C');
$pdf->Cell(140,5,utf8_decode('13.- DESTINO DE LA PRODUCCION'),1,1,'C');
$pdf->SetFont('Arial','B',6);
$pdf->Cell(50,10,utf8_decode(''),1,0,'C');
$pdf->Cell(30,10,utf8_decode(''),1,0,'C');
$pdf->Cell(30,10,utf8_decode(''),1,0,'C');
$pdf->Cell(30,10,utf8_decode(''),1,0,'C');
$pdf->Cell(50,10,utf8_decode(''),1,0,'C');
$pdf->Cell(30,10,utf8_decode(''),1,0,'C');
$pdf->Cell(30,10,utf8_decode(''),1,0,'C');
$pdf->Cell(30,10,utf8_decode(''),1,1,'C');
$pdf->ln(-10);
$pdf->Cell(50,5,utf8_decode('ENTIDAD'),0,0,'C');
$pdf->Cell(30,5,utf8_decode('CABEZA'),0,0,'C');
$pdf->Cell(30,5,utf8_decode('CABEZA'),0,0,'C');
$pdf->Cell(30,5,utf8_decode('CABEZA'),0,0,'C');
$pdf->Cell(50,5,utf8_decode('ENTIDAD'),0,0,'C');
$pdf->Cell(30,5,utf8_decode('KG'),0,0,'C');
$pdf->Cell(30,5,utf8_decode('KG'),0,0,'C');
$pdf->Cell(30,5,utf8_decode('KG'),0,1,'C');
$pdf->Cell(50,5,utf8_decode(''),0,0,'C');
$pdf->Cell(30,5,utf8_decode('LECHONES'),0,0,'C');
$pdf->Cell(30,5,utf8_decode('CERDAS'),0,0,'C');
$pdf->Cell(30,5,utf8_decode('VERRACOS'),0,0,'C');
$pdf->Cell(50,5,utf8_decode(''),0,0,'C');
$pdf->Cell(30,5,utf8_decode('LECHONES'),0,0,'C');
$pdf->Cell(30,5,utf8_decode('CERDA'),0,0,'C');
$pdf->Cell(30,5,utf8_decode('VERRACOS'),0,1,'C');
$queryd = mysqli_query("SELECT pdes.prdes_entidad from produccion_destino pdes WHERE pdes.prdes_prcodigo=".$result['pr_codigo']." and pdes.prdes_estado='ACTIVO' group by pdes.prdes_entidad");
$cuenta=0;
	while ($resultd = mysqli_fetch_array($queryd)){	
		$cuenta=$cuenta+5;
		$pdf->Cell(140,5,utf8_decode(''),1,0,'C');		
		$pdf->Cell(50,5,utf8_decode($resultd['prdes_entidad']),1,0,'C');
		$queryd1 = mysqli_query("Select (SELECT SUM(pd.prdes_unidad) as prdes_unidad FROM produccion_destino pd, rubro_tipo rt where pd.prdes_prcodigo=".$result['pr_codigo']." and pd.prdes_rutcodigo=rt.rut_codigo and pd.prdes_entidad='".$resultd['prdes_entidad']."' AND rt.rut_descripcion='LECHON') as lechon,(SELECT SUM(pd.prdes_unidad) as prdes_unidad FROM produccion_destino pd, rubro_tipo rt where pd.prdes_prcodigo=".$result['pr_codigo']." and pd.prdes_rutcodigo=rt.rut_codigo and pd.prdes_entidad='".$resultd['prdes_entidad']."' AND rt.rut_descripcion='CERDA') as cerda ,(SELECT SUM(pd.prdes_unidad) as prdes_unidad FROM produccion_destino pd, rubro_tipo rt where pd.prdes_prcodigo=".$result['pr_codigo']." and pd.prdes_rutcodigo=rt.rut_codigo and pd.prdes_entidad='".$resultd['prdes_entidad']."' AND rt.rut_descripcion='VERRACO') as verraco");
		$resultd1 = mysqli_fetch_array($queryd1);
		$pdf->Cell(30,5,utf8_decode($resultd1['lechon']/1),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($resultd1['cerda']/1),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($resultd1['verraco']/1),1,1,'C');
}
$queryd = mysqli_query("SELECT pdes.prpr_entidad from produccion_procede pdes WHERE pdes.prpr_prcodigo=".$result['pr_codigo']." and pdes.prpr_estado='ACTIVO' group by pdes.prpr_entidad");
$pdf->Ln(-$cuenta);
	while ($resultd = mysqli_fetch_array($queryd)){	
		$pdf->Cell(50,5,utf8_decode($resultd['prpr_entidad']),1,0,'C');
		$queryd1 = mysqli_query("Select (SELECT SUM(pd.prpr_unidad) as prpr_unidad FROM produccion_procede pd, rubro_tipo rt where pd.prpr_prcodigo=".$result['pr_codigo']." and pd.prpr_rutcodigo=rt.rut_codigo and pd.prpr_entidad='".$resultd['prpr_entidad']."' AND rt.rut_descripcion='LECHON') as lechon,(SELECT SUM(pd.prpr_unidad) as prpr_unidad FROM produccion_procede pd, rubro_tipo rt where pd.prpr_prcodigo=".$result['pr_codigo']." and pd.prpr_rutcodigo=rt.rut_codigo and pd.prpr_entidad='".$resultd['prpr_entidad']."' AND rt.rut_descripcion='CERDA') as cerda ,(SELECT SUM(pd.prpr_unidad) as prpr_unidad FROM produccion_procede pd, rubro_tipo rt where pd.prpr_prcodigo=".$result['pr_codigo']." and pd.prpr_rutcodigo=rt.rut_codigo and pd.prpr_entidad='".$resultd['prpr_entidad']."' AND rt.rut_descripcion='verraco') as verraco");
		$resultd1 = mysqli_fetch_array($queryd1);
		$pdf->Cell(30,5,utf8_decode($resultd1['lechon']/1),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($resultd1['cerda']/1),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($resultd1['verraco']/1),1,1,'C');
	}
$pdf->Ln(8);
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
$querye = mysqli_query("SELECT p.per_nombres as nomelab,p.per_apellidos apeelab,p.per_cargo cargelab,p.per_telefono telefelab, p1.per_nombres as nomtrans,p1.per_apellidos apetrans,p1.per_cargo cargtrans,p1.per_telefono teleftrans, p2.per_nombres as nomenc,p2.per_apellidos apeenc,p2.per_cargo cargenc,p2.per_telefono telefenc from produccion pr LEFT JOIN personal p on p.per_codigo=pr.pr_perelab LEFT JOIN personal p1 on p1.per_codigo=pr.pr_pertrans LEFT JOIN personal p2 on p2.per_codigo=pr.pr_perencuest where pr.pr_codigo=".$result['pr_codigo']);
$resulte = mysqli_fetch_array($querye);	
$pdf->Cell(80,5,utf8_decode(''),0,0,'C');
$pdf->Cell(60,5,utf8_decode(''),0,0,'C');
$pdf->Cell(50,5,utf8_decode(''),0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,utf8_decode($resulte['apeelab']." ".$resulte['nomelab']),1,0,'C');
$pdf->Cell(60,5,utf8_decode($resulte['cargelab']),1,0,'C');
$pdf->Cell(50,5,utf8_decode($resulte['telefelab']),1,0,'C');
$pdf->Cell(54,5,utf8_decode($result['pr_fechaelab']),1,0,'C');
$pdf->Cell(36,5,utf8_decode(''),1,1,'C');
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
$pdf->Cell(80,5,utf8_decode($resulte['apeenc']." ".$resulte['nomenc']),1,0,'C');
$pdf->Cell(30,5,utf8_decode(''),1,0,'C');
$pdf->Cell(80,5,utf8_decode($resulte['apetrans']." ".$resulte['nomtrans']),1,0,'C');
$pdf->Cell(54,5,utf8_decode($result['pr_fechatrans']),1,0,'C');
$pdf->Cell(36,5,utf8_decode(''),1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(36,10,utf8_decode('OBSERVACIONES'),0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(280,10,utf8_decode($result['pr_observacion']),0,'J');
$pdf->SetXY(220,50);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(0,15,utf8_decode($result['est_direccion']),0,'L');
$pdf->Output();
?>