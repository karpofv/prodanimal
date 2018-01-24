<?php include("includes/conf/parametros.php");?>
<?php include("includes/layout/headp.php");?>

<a class="hiddenanchor" id="signup"></a>
<a class="hiddenanchor" id="signin"></a>

<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
            <?php
                    if($_GET[info]!=""){
                        $error_msg = $info[$_GET[info]];
                    ?>
                <div class="row animated flipInY">
                    <div class="alert alert-danger alert-dismissible fade in">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $error_msg;?>
                    </div>
                </div>
                <?php
                    }
                    ?>
                    <form action="index2.php" method="post">
                        <h1>Ingresa a Prodanimal</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Usuario" name="user" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Contraseña" name="pass" required="" />
                        </div>
                        <div>
                            <button type="submit" class="btn btn-default">Ingresar</button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">
                            <div class="clearfix"></div>
                            <br />
                            <div>
                                <h1><i class="fa fa-paw"></i> Produccion Animal</h1>
                                <p>©2017 Produccion animal</p>
                            </div>
                        </div>
                    </form>
        </section>
    </div>
</div>
<?php include("includes/layout/footp.php");?>