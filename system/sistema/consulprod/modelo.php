<?php

$eliminar = filter_input(INPUT_POST, eliminar);
$codigo = filter_input(INPUT_POST, codigo);
if ($eliminar == 1 and $codigo != "") {
    $delete = paraTodos::arrayDelete("pr_codigo=$codigo", "produccion");
}
$consul_prod = paraTodos::arrayConsulta("m.mes_descripcion, e.est_nombre, r.ru_descripcion,pr_codigo", "produccion pr, tools_mes m, establecimiento e, rubros r", "pr.pr_mes=m.mes_codigo and pr.pr_estcodigo=e.est_codigo and pr.pr_rucodigo=r.ru_codigo");