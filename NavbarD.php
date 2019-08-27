<div class="container-fluid px-0 d-none d-lg-block">
    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-around p-0">
        <div class="col-2 d-flex justify-content-between align-items-center">
            <a class="navbar-brand" onclick="window.location.href='VABOptions.php'" title="Menu" data-toggle="tooltip"><img class="img-fluid" src="img/logo/nav1.png"></a>
            <p id="nav-title" class="font-weight-bold">
    
            </p>
        </div>
        <div class="collapse navbar-collapse col-9 d-flex justify-content-center align-items-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item mx-2 text-center">        
                    <a id="orange" class="<?php if($sel === 'trabajadores'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VTrabajador.php'" title="Trabajadores"><img src="img/usuarios.png">Trabajadores</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'edr'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VEstadoResultados.php'" title="Estado de Resultados"><img src="img/clientes.png">Estado de Resultados</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'fde'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VFlujoEfectivo.php'" title="Flujo de Efectivo"><img src="img/negocios.png">Flujo de efectivo</a>
                </li>
            </ul>
        </div>
        <div class="col-1 d-flex justify-content-end align-items-center text-center">
            <a id="nav-salir" class="nav-link font-weight-bold" href="index.php?cerrar_sesion" title="Salir"><img src="img/salir.png">Salir</a>
        </div>
    </nav>
</div>

<div class="contaier-fluid d-lg-none">
    <nav class="navbar navbar-light bg-light justify-content-around p-0">
        <button class="d-lg-none navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item mx-2 text-center">        
                    <a class="navbar-brand" onclick="window.location.href='VABOptions.php'" title="Menu" data-toggle="tooltip"><img class="img-fluid" src="img/logo/nav1.png"></a>
                </li>
                <li class="nav-item mx-2 text-center">        
                    <a id="orange" class="<?php if($sel === 'trabajadores'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VTrabajador.php'" title="Trabajadores"><img src="img/usuarios.png">Trabajadores</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'edr'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VEstadoResultados.php'" title="Estado de Resultados"><img src="img/clientes.png">Estado de Resultados</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'fde'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VFlujoEfectivo.php'" title="Flujo de Efectivo"><img src="img/negocios.png">Flujo de efectivo</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a id="nav-salir" class="nav-link font-weight-bold" href="index.php?cerrar_sesion" title="Salir"><img src="img/salir.png">Salir</a>
                </li>
            </ul>
        </div>
    </nav>
</div>