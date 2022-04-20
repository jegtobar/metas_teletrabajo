<header class="main-header">
    <!-- Logo -->
    <a href="principal.php" class="logo">
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><!-- <img src="img/logo/logoAVE.png" width="140"> --></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      
    </nav>
    
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    <!-- Sidebar user panel 
      <div class="user-panel">
        <div class="pull-left info">
          <p><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;Usuario:</p>
        </div>
        <div class="clearfix"></div><br><br>
      </div>
      -->
      
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
      
         <li class="header"><!-- MAIN NAVIGATION --></li>
         
         <!-- 
         <li class="treeview">
          <a href="#">
            <i class="fa fa-building"></i> <span>Dependencias</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          
          <ul class="treeview-menu">
            <li><a href="categoria.php" id="btn_bitacora_listado"><i class="fa fa-sitemap"></i>Categoría</a></li>
            <li><a href="tipo.php" id="btn_bitacora_listado"><i class="fa fa-institution"></i>Tipo</a></li>
            <li><a href="institucion.php" id="btn_bitacora"><i class="fa fa-building"></i>Instituciones</a></li>
            <li><a href="dependencia.php" id="btn_bitacora_listado"><i class="fa fa-cubes"></i>Dependencias</a></li>
          </ul>
         </li>
         
         <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Responsables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          
          <ul class="treeview-menu">
            <li><a href="persona.php" id="btn_bitacora"><i class="fa fa-users"></i>Personas</a></li>
            <li><a href="rol.php" id="btn_bitacora"><i class="fa fa-user"></i>Roles</a></li>
            <li><a href="responsable.php" id="btn_bitacora_listado"><i class="fa fa-desktop"></i>Responsables</a></li>
          </ul>
         </li> 
         
         <li class="treeview">
          <a href="#">
            <i class="fa fa-warning"></i> <span>Criticidades</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          
          <ul class="treeview-menu">
            <li><a href="criticidad.php" id="btn_bitacora"><i class="fa fa-warning"></i>Criticidades</a></li>
            <li><a href="protocolo.php" id="btn_bitacora_listado"><i class="fa fa-bullseye"></i>Protocolos</a></li>
            <li><a href="accion.php" id="btn_bitacora"><i class="fa fa-lightbulb-o"></i>Acciones</a></li>
          </ul>
         </li>
         
        <li class="treeview">
         <a href="#">
           <i class="fa fa fa-battery-half"></i> <span>Insumos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
         
         <ul class="treeview-menu">
            <li><a href="tipoinsumo.php" id="btn_bitacora"><i class="fa fa-life-ring"></i>Tipos de Insumos</a></li>
            <li><a href="catalogo_insumo.php" id="btn_bitacora"><i class="fa fa-book"></i>Cat&aacute;logo Insumos</a></li>
            <li><a href="accioninsumo.php" id="btn_bitacora"><i class="fa fa-list-ul"></i>Insumos por Acci&oacute;n</a></li>
          </ul>
        </li>
         -->
         <!--- Agregado vehiculos e insumos--
       <li class="treeview <?php echo $clase1;?>">
         <a href="#">
           <i class="fa fa-pencil-square-o"></i> <span>Gesti&oacute;n de Insumos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
         
         <ul class="treeview-menu">
            <li class="<?php echo $clase2;?>"><a href="#" id="btn_bitacora"><i class="fa fa-pencil-square-o"></i>Camiones Cisterna</a>
                <ul  class="treeview-menu">
                    <li><a href="principal.php?section=inventario_vehiculos"><span style="color:#b8c7ce">Inventario</span></a></li>
                    <li><a href="principal.php?section=ubicaciones_vehiculos"><span style="color:#b8c7ce">Ubicaciones</span></a></li>
                    <li><a href="principal.php?section=ubicaciones_constructoras"><span style="color:#b8c7ce">Constructoras</span></a></li>
                </ul>
            </li>
            <li><a href="principal.php?section=agua&js=hidrantes" id="btn_bitacora"><i class="fa fa-lightbulb-o"></i>Agua</a>
            </li>
            
            <li><a href="principal.php?section=insumos&js=mascarilla" id="btn_bitacora"><i class="fa fa-lightbulb-o"></i>Insumos Varios</a></li>            
          </ul>
        </li>         
         <!--  Fin agregado vehiculos e insumos
         
        <li class="treeview">
         <a href="#">
           <i class="fa fa fa-flash"></i> <span>Daños</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
         
         <ul class="treeview-menu">
            <li><a href="catdanios.php" id="btn_bitacora"><i class="fa fa-book"></i>Cat&aacute;logo de Da&ntilde;os</a></li>
            <li><a href="danios.php" id="btn_bitacora"><i class="fa fa-flash"></i>Da&ntilde;os</a></li>
          </ul>
        </li>
        -->
         
         <li class="treeview">
          <a href="accion.php">
            <i class="fa fa-desktop"></i> <span>Ingreso de metas</span>
            <span class="pull-right-container">
            </span>
          </a>
         </li>
         <!-- 
         <li class="treeview">
          <a href="menu_roles.php">
            <i class="fa fa-gear"></i> <span>Permisos</span>
            <span class="pull-right-container">
            </span>
          </a>
         </li>
         
         <li class="treeview">
          <a href="../ave_monitor/menu.php">
            <i class="fa fa-paper-plane-o"></i> <span>Regresar</span>
            <span class="pull-right-container">
            </span>
          </a>
         </li>
          -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>