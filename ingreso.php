<?php
   // error_reporting(E_ALL & ~E_WARNING);
    session_start();
    
    $error = isset($_SESSION['error_login']) ? $_SESSION['error_login'] : '';
    
    session_unset();
    session_destroy();
    
    $mantenimiento = false;

    /*$mantenimiento = 1;
    echo $mantenimiento;*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Unidad de información</title>

<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom -->
<link href="css/style.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

	<div class="container">
    	<div class="row" style="margin-top: 50px; ">
    		<div class="col-md-4"></div><!-- /.col-md-4 -->
    		<div class="col-md-4">
    					<div class="panel panel-amuni">
    						<div class="panel-heading">
    							<h1 class="panel-title">
    								<strong>Unidad de información</strong>
    							</h1>
    						</div>
    						<div class="panel-body">
                            <?php
                            if ($mantenimiento) {
                            ?>
                                <div class="row">
                                    <div class="col-md-12 alert alert-warning">
                                        <h3><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Sitio en mantenimiento</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <h3>En este momento estamos realizando copias de seguridad de la base de datos y haciendo actualizaciones en el sistema.<br><br>Nos disculpamos por los inconvenientes, por favor intente de nuevo más tarde. <br><br><small><strong>IT UDI</strong></small></h3>
                                    </div>
                                </div>
                            <?php                                
                            } else {
                            ?>
                                <form id="login" name="login" method="post" action="principal.php" autocomplete="off">
    							    <div class="form-group">
    								    <label for="user">Usuario</label>
    								    <input type="text" class="form-control" id="user" name="user" placeholder="Usuario" />
    								</div>
    								<div class="form-group">
    								    <label for="pass">Contraseña</label>
    								    <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña" />
                                    </div>
    								<button type="submit" class="btn btn-md btn-amuni pull-right">Entrar</button>
    							</form><!-- /#login -->
                            <?php
                            }
                            ?>
    						</div><!-- /.panel-body -->
    					</div><!-- /.panel .panel-primary -->
    		</div><!-- /.col-md-4 -->
    		<div class="col-md-4"></div><!-- /.col-md-4 -->
    	</div><!-- /.row -->
    	
    	<div class="row">
            <div class="col-md-4"></div><!-- /.col-md-4 -->
    	    <div class="col-md-4">
    	    <?php
                if ($error) {
    	    ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong> <?php echo $error; ?>
                </div>
            <?php
                }
            ?>
            </div>
            <div class="col-md-4"></div><!-- /.col-md-4 -->
        </div>
        
        <div class="row">
            <div class="col-md-4"></div><!-- /.col-md-4 -->
            <div class="col-md-4">
                <a href="index.php" class="btn btn-md btn-default btn-block">
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                    Pagina principal de LAIP
                </a>
            </div><!-- /.col-md-4 -->
            <div class="col-md-4"></div><!-- /.col-md-4 -->
            
        </div>
	</div><!-- /.container -->

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/jquery.validate.min.js"></script>

	<script type="text/javascript">
        $(document).ready(function(){
            $('#user').focus();
            
            $('form').validate({
                rules: {
                    user: {
                        required: true
                    },
                    pass: {
                        required: true
                    }
                },
                messages: {
                    user: {
                        required: 'Por favor introduzca su usuario'
                    },
                    pass: {
                    	required: 'Por favor introduzca su contraseña'
                    }
                },
                errorElement: "span",
        	    errorClass: "help-block error-help-block",
        	    highlight: function (element, errorClass, validClass) {
            	    $(element).closest('.form-group').addClass('has-error');
        	    },
        	    unhighlight: function (element, errorClass, validClass) {
        	        $(element).closest('.form-group').removeClass('has-error');
        	    },
        	    errorPlacement: function (error, element) {
            	    if (element.prop("type") === "checkbox" || element.prop("type") === "radio") {
        	            error.appendTo(element.parent().parent());
        	        } else if (element.parent(".input-group").length) {
        	            error.insertAfter(element.parent());
        	        } else {
        	            error.insertAfter(element);
        	        }
        	    }
            });
        })
    </script>

</body>
</html>