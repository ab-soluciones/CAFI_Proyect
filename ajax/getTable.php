<?php
require_once "config.php";

echo '<table class="mt-0 table table-bordered table-hover table-sm shadow-sm p-3 bg-white rounded">';
echo '<thead class="thead-dark">';
echo     '<tr>';
echo         '<th class="text-center">Solicitud</th>';
echo         '<th class="text-center">Cuenta</th>';
echo         '<th class="text-center">Nombre</th>';
echo         '<th class="text-center">Cantidad</th>';
echo         '<th class="text-center"></th>';
echo     '</tr>';
echo '</thead>';
echo '<tbody>';

         $con=mysqli_connect("localhost","root","","finanzas_3");
         // Check connection
         if (mysqli_connect_errno())
         {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
         }
         
        $tablaProyectos = mysqli_query($con, "SELECT cp.Num, cp.Solicitud, cp.Cuenta, cp.Cantidad, c.Nombre, c.Cuenta FROM cpp cp, cuentas c WHERE Solicitud =".$_GET['id']." AND c.Cuenta = cp.Cuenta");
        while($row = mysqli_fetch_array($tablaProyectos)){
            echo "<tr>";
            echo "<td class='text-center text-info'>" . $row['Solicitud'] . "</td>";
            echo "<td class='text-center'>" . $row['Cuenta'] . "</td>";
            echo "<td class='text-center'>" . utf8_encode($row['Nombre']) . "</td>";
            echo "<td class='text-center'>$" . $row['Cantidad'] . "</td>";
            echo '<td class="text-center"><button type="button" class="btn btn-danger submitBtn" onclick="submitContactForm(\'eliminar\',\''.$row["Num"].'\',\''.$row["Solicitud"].'\')">Eliminar</button>';
            echo "</tr>";
        }

        mysqli_close($con);
    
echo '</tbody>';
echo '</table>';
?>