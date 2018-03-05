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

$pdf=new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
$pdf->Image('../recursos/img/mppa.jpg',10,10,50,20,'');
$pdf->Cell(70,12,utf8_decode(''),0,0,'C');
$pdf->SetFont('Arial','B',12);
$query = mysqli_query("SELECT r.ru_descripcion from rubros r WHERE r.ru_codigo=".$_GET['r']);
$result = mysqli_fetch_array($query);
$pdf->Cell(150,12,utf8_decode('BENEFICIO '.$result['ru_descripcion']),0,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(60,5,utf8_decode('I. IDENTIFICACIÒN'),1,1,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(170,12,utf8_decode('POR TIPO DE RUBRO'),0,0,'R');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,utf8_decode(''),0,0,'C');
$pdf->Cell(40,5,utf8_decode('1.-MUNICIPIO'),1,0,'C');
$pdf->Cell(20,5,utf8_decode('2.-MES'),1,1,'C');
$pdf->Cell(40,5,utf8_decode(''),0,0,'C');
$pdf->Cell(180,12,utf8_decode(''),0,0,'C');
$pdf->SetFont('Arial','',6);
if($_GET['mu']>0){
	$querymun = mysqli_query("SELECT * from municipio m where m.mun_codigo=".$_GET['mu']);
	$resultmun = mysqli_fetch_array($querymun);	
	$pdf->Cell(40,5,utf8_decode($resultmun['mun_descrip']),1,0,'C');
}else{
	$pdf->Cell(40,5,utf8_decode('TODOS'),1,0,'C');
}
if($_GET['m']>0){
	$pdf->Cell(20,5,utf8_decode($_GET['m']),1,1,'C');
}else{
	$pdf->Cell(20,5,utf8_decode('TODOS'),1,1,'C');	
}
$pdf->SetFont('Arial','B',8);
$pdf->Ln(8);
$pdf->Cell(280,5,utf8_decode('II. REGISTRO DE BENEFICIO DE '.$result['ru_descripcion']),1,0,'L');
$pdf->Cell(50,5,utf8_decode(''),0,1,'C');
$pdf->Cell(30,10,utf8_decode('MES'),1,0,'C');
$pdf->Cell(50,10,utf8_decode('MUNICIPIO'),1,0,'C');
$pdf->Cell(50,10,utf8_decode('TIPO DE RUBRO'),1,0,'C');
$pdf->Cell(30,10,utf8_decode('PRODUCCIÓN'),1,0,'C');
$pdf->Cell(120,5,utf8_decode('SUPERFICIE'),1,1,'C');
$pdf->Cell(160,5,utf8_decode(''),0,0,'C');	
$pdf->Cell(30,5,utf8_decode('SIEMBRA'),1,0,'C');	
$pdf->Cell(30,5,utf8_decode('RENOVACIÓN'),1,0,'C');
$pdf->Cell(30,5,utf8_decode('REHABILITACIÓN'),1,0,'C');
$pdf->Cell(30,5,utf8_decode('COSECHA'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$queryp = "SELECT pr_mes,m.mun_descrip,rt.rut_descripcion,SUM(pd.prd_cantidad)  as cantidad  from produccion_detalle pd, produccion p, rubro_tipo rt, establecimiento e, municipio m where p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and p.pr_codigo=pd.prd_prcodigo and pd.prd_rutcodigo=rt.rut_codigo AND p.pr_estado='ACTIVA' and pd.prd_estado='ACTIVA' and pd.prd_estado='ACTIVA'";
if($_GET['m']>0){
	$queryp.=" and pr_mes=".$_GET['m'];
}
if($_GET['mu']>0){
	$queryp.=" and mun_codigo=".$_GET['mu'];
}
if($_GET['r']>0){
	$queryp.=" and pr_rucodigo=".$_GET['r'];
}
$queryp.= " GROUP BY rt.rut_descripcion order by mun_descrip" ;
$querypg = mysqli_query($queryp);
while ($resultp = mysqli_fetch_array($querypg)){
	$pdf->Cell(30,5,utf8_decode($resultp['pr_mes']),1,0,'C');
	$pdf->Cell(50,5,utf8_decode($resultp['mun_descrip']),1,0,'C');
	$pdf->Cell(50,5,utf8_decode($resultp['rut_descripcion']),1,0,'C');
	$pdf->Cell(30,5,utf8_decode($resultp['cantidad']/1),1,0,'C');
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='SIEMBRA' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA'";
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}	
	$querydg.=" group BY pd.prd_rutcodigo,rt.rut_descripcion order BY pd.prd_rutcodigo";
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');	
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='RENOVACIÓN' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA'";
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}
	$querydg.=" group BY pd.prd_rutcodigo,rt.rut_descripcion order BY pd.prd_rutcodigo";
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');	
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='REHABILITACIÓN' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA'";
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}
	$querydg.=" group BY pd.prd_rutcodigo,rt.rut_descripcion order BY pd.prd_rutcodigo";
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');
	$querydg1 = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='COSECHA' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA'";
	if($_GET['m']>0){
		$querydg1.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg1.=" and mun_codigo=".$_GET['mu'];
	}	
	$querydg1.=" group BY pd.prd_rutcodigo,rt.rut_descripcion order BY pd.prd_rutcodigo";	
	$queryd1 = mysqli_query($querydg1);
	$resultd1 = mysqli_fetch_array($queryd1);	
	$pdf->Cell(30,5,utf8_decode($resultd1['prd_cantidad']/1),1,1,'C');
}
/**************************************************TOTALES*************************************************************/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(30,5,utf8_decode(''),0,0,'C');
	$pdf->Cell(50,5,utf8_decode(''),0,0,'C');
	$pdf->Cell(50,5,utf8_decode('TOTALES'),1,0,'C');
	$queryt = "SELECT pr_mes,m.mun_descrip,rt.rut_descripcion,SUM(pd.prd_cantidad)  as cantidad  from produccion_detalle pd, produccion p, rubro_tipo rt, establecimiento e, municipio m where p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and p.pr_codigo=pd.prd_prcodigo and pd.prd_rutcodigo=rt.rut_codigo AND p.pr_estado='ACTIVA' and pd.prd_estado='ACTIVA' and pd.prd_estado='ACTIVA'";
	if($_GET['m']>0){
		$queryt.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$queryt.=" and mun_codigo=".$_GET['mu'];
	}
	if($_GET['r']>0){
		$queryt.=" and pr_rucodigo=".$_GET['r'];
	}
	$queryt=mysqli_query($queryt);
	$resultt=mysqli_fetch_array($queryt);
	$pdf->Cell(30,5,utf8_decode($resultt['cantidad']/1),1,0,'C');
$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultt['rut_descripcion']."' and tm.tip_medida='SIEMBRA' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA'";
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}	
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');	
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultt['rut_descripcion']."' and tm.tip_medida='RENOVACIÓN' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA'";
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');	
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultt['rut_descripcion']."' and tm.tip_medida='REHABILITACIÓN' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA'";
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');
	$querydg1 = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultt['rut_descripcion']."' and tm.tip_medida='COSECHA' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA'";
	if($_GET['m']>0){
		$querydg1.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg1.=" and mun_codigo=".$_GET['mu'];
	}	
	$queryd1 = mysqli_query($querydg1);
	$resultd1 = mysqli_fetch_array($queryd1);	
	$pdf->Cell(30,5,utf8_decode($resultd1['prd_cantidad']/1),1,1,'C');
/********************************************PAGINA 2******************************************************************************/
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
$pdf->Image('../recursos/img/mppa.jpg',10,10,50,20,'');
$pdf->Cell(70,12,utf8_decode(''),0,0,'C');
$pdf->SetFont('Arial','B',12);
$query = mysqli_query("SELECT r.ru_descripcion from rubros r WHERE r.ru_codigo=".$_GET['r']);
$result = mysqli_fetch_array($query);
$pdf->Cell(150,12,utf8_decode('BENEFICIO '.$result['ru_descripcion']),0,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(60,5,utf8_decode('I. IDENTIFICACIÒN'),1,1,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(170,12,utf8_decode('POR CATEGORÍA'),0,0,'R');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,utf8_decode(''),0,0,'C');
$pdf->Cell(40,5,utf8_decode('1.-MUNICIPIO'),1,0,'C');
$pdf->Cell(20,5,utf8_decode('2.-MES'),1,1,'C');
$pdf->Cell(40,5,utf8_decode(''),0,0,'C');
$pdf->Cell(180,12,utf8_decode(''),0,0,'C');
$pdf->SetFont('Arial','',6);
if($_GET['mu']>0){
	$querymun = mysqli_query("SELECT * from municipio m where m.mun_codigo=".$_GET['mu']);
	$resultmun = mysqli_fetch_array($querymun);	
	$pdf->Cell(40,5,utf8_decode($resultmun['mun_descrip']),1,0,'C');
}else{
	$pdf->Cell(40,5,utf8_decode('TODOS'),1,0,'C');
}
if($_GET['m']>0){
	$pdf->Cell(20,5,utf8_decode($_GET['m']),1,1,'C');
}else{
	$pdf->Cell(20,5,utf8_decode('TODOS'),1,1,'C');	
}
$pdf->SetFont('Arial','B',8);
$pdf->Ln(8);
$pdf->Cell(280,5,utf8_decode('II. REGISTRO DE BENEFICIO DE '.$result['ru_descripcion']),1,0,'L');
$pdf->Cell(50,5,utf8_decode(''),0,1,'C');
$pdf->Cell(30,10,utf8_decode('MES'),1,0,'C');
$pdf->Cell(50,10,utf8_decode('MUNICIPIO'),1,0,'C');
$pdf->Cell(50,10,utf8_decode('CATEGORÍA'),1,0,'C');
$pdf->Cell(30,10,utf8_decode('PRODUCCIÓN'),1,0,'C');
$pdf->Cell(120,5,utf8_decode('SUPERFICIE'),1,1,'C');
$pdf->Cell(160,5,utf8_decode(''),0,0,'C');	
$pdf->Cell(30,5,utf8_decode('SIEMBRA'),1,0,'C');	
$pdf->Cell(30,5,utf8_decode('RENOVACIÓN'),1,0,'C');
$pdf->Cell(30,5,utf8_decode('REHABILITACIÓN'),1,0,'C');
$pdf->Cell(30,5,utf8_decode('COSECHA'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$queryp = "SELECT pr_mes,m.mun_descrip,rt.rut_descripcion,SUM(pd.prd_cantidad)  as cantidad  from produccion_detalle pd, produccion p, rubro_tipo rt, establecimiento e, municipio m where p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and p.pr_codigo=pd.prd_prcodigo and pd.prd_rutcodigo=rt.rut_codigo AND p.pr_estado='ACTIVA' and pd.prd_estado='ACTIVA' and pd.prd_estado='ACTIVA' and prd_rucatcodigo=".$_GET['c'];
if($_GET['m']>0){
	$queryp.=" and pr_mes=".$_GET['m'];
}
if($_GET['mu']>0){
	$queryp.=" and mun_codigo=".$_GET['mu'];
}
if($_GET['r']>0){
	$queryp.=" and pr_rucodigo=".$_GET['r'];
}
$queryp.= " GROUP BY rt.rut_descripcion order by mun_descrip" ;
$querypg = mysqli_query($queryp);
while ($resultp = mysqli_fetch_array($querypg)){
	$pdf->Cell(30,5,utf8_decode($resultp['pr_mes']),1,0,'C');
	$pdf->Cell(50,5,utf8_decode($resultp['mun_descrip']),1,0,'C');
	$pdf->Cell(50,5,utf8_decode($resultp['rut_descripcion']),1,0,'C');
	$pdf->Cell(30,5,utf8_decode($resultp['cantidad']/1),1,0,'C');
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='SIEMBRA' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA'and prd_rucatcodigo=".$_GET['c'];
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}	
	$querydg.=" group BY pd.prd_rutcodigo,rt.rut_descripcion order BY pd.prd_rutcodigo";
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion p, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='RENOVACIÓN' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA' and prd_rucatcodigo=".$_GET['c'];
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}	
	$querydg.=" group BY pd.prd_rutcodigo,rt.rut_descripcion order BY pd.prd_rutcodigo";
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='REHABILITACIÓN' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA' and prd_rucatcodigo=".$_GET['c'];
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}	
	$querydg.=" group BY pd.prd_rutcodigo,rt.rut_descripcion order BY pd.prd_rutcodigo";
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');
	$querydg1 = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='COSECHA' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA' and prd_rucatcodigo=".$_GET['c'];
	if($_GET['m']>0){
		$querydg1.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg1.=" and mun_codigo=".$_GET['mu'];
	}	
	$querydg1.=" group BY pd.prd_rutcodigo,rt.rut_descripcion order BY pd.prd_rutcodigo";	
	$queryd1 = mysqli_query($querydg1);
	$resultd1 = mysqli_fetch_array($queryd1);	
	$pdf->Cell(30,5,utf8_decode($resultd1['prd_cantidad']/1),1,1,'C');
}
/**************************************************TOTALES*************************************************************/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(30,5,utf8_decode(''),0,0,'C');
	$pdf->Cell(50,5,utf8_decode(''),0,0,'C');
	$pdf->Cell(50,5,utf8_decode('TOTALES'),1,0,'C');
	$queryp = "SELECT pr_mes,m.mun_descrip,rt.rut_descripcion,SUM(pd.prd_cantidad)  as cantidad  from produccion_detalle pd, produccion p, rubro_tipo rt, establecimiento e, municipio m where p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and p.pr_codigo=pd.prd_prcodigo and pd.prd_rutcodigo=rt.rut_codigo AND p.pr_estado='ACTIVA' and pd.prd_estado='ACTIVA' and pd.prd_estado='ACTIVA' and prd_rucatcodigo=".$_GET['c'];
	if($_GET['m']>0){
		$queryp.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$queryp.=" and mun_codigo=".$_GET['mu'];
	}
	if($_GET['r']>0){
		$queryp.=" and pr_rucodigo=".$_GET['r'];
	}
	$queryp = mysqli_query($queryp);
	$resultp = mysqli_fetch_array($queryp);	
	$pdf->Cell(30,5,utf8_decode($resultp['cantidad']/1),1,0,'C');
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='SIEMBRA' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA' and prd_rucatcodigo=".$_GET['c'];
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}	
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='RENOVACIÓN' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA' and prd_rucatcodigo=".$_GET['c'];
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}	
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');
	$querydg = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='REHABILITACIÓN' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA' and prd_rucatcodigo=".$_GET['c'];
	if($_GET['m']>0){
		$querydg.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg.=" and mun_codigo=".$_GET['mu'];
	}	
	$queryd = mysqli_query($querydg);
	$resultd = mysqli_fetch_array($queryd);	
	$pdf->Cell(30,5,utf8_decode($resultd['prd_cantidad']/1),1,0,'C');
	$querydg1 = "SELECT rt.rut_descripcion,SUM(pm.prmov_cantidad) as prd_cantidad, tm.tip_medida FROM produccion P, produccion_detalle pd, rubro_tipo rt, tipos_medidas tm, produccion_movimiento pm, municipio m, establecimiento e  WHERE p.pr_codigo=pd.prd_prcodigo AND pd.prd_rutcodigo=rt.rut_codigo and tm.tip_rucodigo=rt.rut_rucodigo AND rt.rut_descripcion='".$resultp['rut_descripcion']."' and tm.tip_medida='COSECHA' and pm.prmov_prdcodigo=pd.prd_codigo and pm.prmov_tipcodigo=tm.tip_codigo and p.pr_estcodigo=e.est_codigo and e.est_muncodigo=m.mun_codigo and pm.prmov_estado='ACTIVA' and p.pr_estado='ACTIVA' and prd_rucatcodigo=".$_GET['c'];
	if($_GET['m']>0){
		$querydg1.=" and pr_mes=".$_GET['m'];
	}
	if($_GET['mu']>0){
		$querydg1.=" and mun_codigo=".$_GET['mu'];
	}	
	$queryd1 = mysqli_query($querydg1);
	$resultd1 = mysqli_fetch_array($queryd1);	
	$pdf->Cell(30,5,utf8_decode($resultd1['prd_cantidad']/1),1,1,'C');
$pdf->Output();
?>