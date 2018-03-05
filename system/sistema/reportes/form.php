<?php
	include_once('../config/conexion.php');
	if ($_GET['g']==0){
		$query=mysqli_query("select ru_descripcion from produccion p, rubros r where p.pr_rucodigo=r.ru_codigo and p.pr_codigo=".$_GET['id']);
		$post=mysqli_fetch_array($query);		
		header('Location: '.strtolower($post['ru_descripcion']).'.php?id='.$_GET['id']);		
	}else{
		$query=mysqli_query("select ru_descripcion from produccion p, rubros r where p.pr_rucodigo=r.ru_codigo and r.ru_codigo=".$_GET['id']);
		$post=mysqli_fetch_array($query);		
		if($post['ru_descripcion']=='APICOLA'){
			header('Location: resumena.php?m='.$_GET['m'].'&mu='.$_GET['mu'].'&r='.$_GET['id'].'&c='.$_GET['c'],'_blank');								
		};
		if($post['ru_descripcion']=='VEGETAL'){
			header('Location: resumenv.php?m='.$_GET['m'].'&mu='.$_GET['mu'].'&r='.$_GET['id'].'&c='.$_GET['c'],'_blank');								
		};
		if($post['ru_descripcion']<>'APICOLA' and $post['ru_descripcion']<>'VEGETAL'){
			header('Location: resumen.php?m='.$_GET['m'].'&mu='.$_GET['mu'].'&r='.$_GET['id'].'&c='.$_GET['c'],'_blank');								
		}
	}
?>