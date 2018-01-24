		<!-- header-starts -->
<?php
include_once('common/head.php');
?>
		<!-- //header-ends -->           
		<!--left-fixed -navigation-->
<?php
include_once('common/menu.php');
?>
		<!--left-fixed -navigation--> 
		<!-- main content start-->
		<div id="page-wrapper">
            <div class="main-page signup-page">
				<h3 class="title1">Municipios</h3>
                <div class="inline-form widget-shadow">
				    <div class="form-title">
						<h4>Registro de Municipios</h4>
					</div>
					<div class="form-body">
						<div data-example-id="simple-form-inline">
							<form class="form-horizontal" id="frmmunicipios">
								<div class="form-group">
									<label class="col-md-2 control-label">Descripcion</label>
									<div class="col-md-8">
										<div class="input-group">
											<span class="input-group-addon">
											</span>
											<input type="text" class="form-control1" id="descrip" required>
											<input type="text" class="collapse" id="codigo">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Estado</label>
									<div class="col-md-8">
										<div class="input-group input-icon right">
											<span class="input-group-addon">
											</span>
											<select class="form-control1" id="selestado">
												<option>ACTIVO</option>
												<option>INACTIVO</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label"></label>										
									<div class="col-md-8">
										<button type="submit" class="btn btn-default" id="btnsave">GUARDAR</button>
										<button type="button" class="btn btn-danger" id="btncancel">CANCELAR</button>
									</div>
								</div>
				            </form>
						</div>
					</div>
                </div>
            </div>
            <div class="tables">
                <div class="bs-example widget-shadow" data-example-id="hoverable-table">
				    <h4>Municipios Registrados</h4>
				    <table class="table table-hover">
                       <thead>
                           <tr>
                               <th>Municipio</th>
                               <th>Estado</th> 
                               <th>Editar</th> 
                               <th>Eliminar</th> 
                           </tr> 
                       </thead> 
                       <tbody>
						   <?php
                                $query=mysqli_query("select * from municipio");                                
                                while($post=mysqli_fetch_array($query)){
                            ?>
                           <tr> 
                               <th scope="row"><?php echo $post['mun_descrip'];?></th>
                               <td><?php echo $post['mun_estado'];?></td> 
                               <td><a href="#" onclick="editar(<?php echo $post['mun_codigo'];?>,'<?php echo $post['mun_descrip'];?>','<?php echo $post['mun_estado'];?>')"><img src="images/edit.png" width="30px"></a></td>
                               <td><a href="#" onclick="eliminar(<?php echo $post['mun_codigo'];?>)"><img src="images/delete.png" width="30px"></a></td>
                           </tr> 
                           <?php
                                }
                           ?>
                       </tbody>
                    </table>
                </div>
            </div>          
        </div>
		<!--footer-->
		<div class="footer">
		</div>
        <!--//footer-->
	</div>
    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>    
    <!-- Classie -->
    <script src="js/classie.js"></script>
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js"> </script>
    <script src="js/validar.js"></script>
    <script src="js/municipios.js"></script>
</body>
</html>