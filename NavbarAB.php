<div class="container-fluid px-0 d-none d-lg-block fixed-top">
    <nav class="navbar fixed navbar-expand-lg navbar-light bg-light justify-content-around p-0">
        <div class="col-2 d-flex justify-content-between align-items-center">
            <a class="navbar-brand" onclick="window.location.href='VABOptions.php'" title="Menu" data-toggle="tooltip"><img class="img-fluid" src="img/logo/nav1.png"></a>
            <p id="nav-title" class="font-weight-bold">

            </p>
        </div>
        <div class="collapse navbar-collapse col-9 d-flex justify-content-center align-items-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item mx-2 text-center">        
                    <a id="orange" class="<?php if($sel === 'usuarios'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VUsuarios_ab.php'" title="Usuarios"><img src="img/usuarios.png">Usuarios</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'clientes'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VClienteab.php'" title="Clientes"><img src="img/clientes.png">Clientes</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'negocios'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VNegociosab.php'" title="Negocios"><img src="img/negocios.png">Negocios</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a id="orange" class="<?php if($sel === 'suscripciones'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VSuscripcion.php'" title="Suscripciones"><img src="img/agenda.png">Suscripciones</a>
                </li>
            </ul>
        </div>
        <div class="col-1 d-flex justify-content-end align-items-center text-center text-uppercase">
            <a id="nav-salir" class="nav-link font-weight-bold" href="index.php?cerrar_sesion" title="Salir"><img src="img/salir.png">Salir</a>
        </div>
    </nav>
</div>

<div class="container-fluid d-lg-none">
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
                    <a id="orange" class="<?php if($sel === 'usuarios'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VUsuarios_ab.php'" title="Usuarios"><img src="img/usuarios.png">Usuarios</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'clientes'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VClienteab.php'" title="Clientes"><img src="img/clientes.png">Clientes</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'negocios'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VNegociosab.php'" title="Negocios"><img src="img/negocios.png">Negocios</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a id="orange" class="<?php if($sel === 'suscripciones'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VSuscripcion.php'" title="Suscripciones"><img src="img/agenda.png">Suscripciones</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a id="nav-salir" class="nav-link font-weight-bold" href="index.php?cerrar_sesion" title="Salir"><img src="img/salir.png">Salir</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
