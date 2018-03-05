<div class="panel-heading">
    <h4>Detalles de Producción</h4>
</div>
<div class="panel-body">
    <div class="alert alert-warning alert-dismissable collapse" id="alertmov">
        <strong>¡Cuidado!</strong> Ya se asignó la distribución de este Tipo de Rubro.
    </div>
    <div class="alert alert-warning alert-dismissable collapse" id="alertcant">
        <strong>¡Cuidado!</strong> La Distribución no puede Exceder la Totalidad de la Producción del Rubro.
    </div>
    <form class="form-horizontal" id="frmprodmov">
        <div class="form-group">
            <div class="col-sm-3">
                <label id="tipdistri">Tipo de Distribución</label>
                <input type="text" id="codigodet" class="collapse">
                <select id="seldistrubro" class="form-control">
								</select>
            </div>
            <div class="col-sm-3">
                <label id="totdistri">Total por Distribución</label>
                <input type="number" id="totaldistrib" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
        </div>
        <div class="col-sm-3">
            <button type="submit" class="btn btn-default" id="btnagreg">AGREGAR</button>
            <button type="button" class="btn btn-default" id="btncancel">CANCELAR</button>
        </div>
    </form>
</div>