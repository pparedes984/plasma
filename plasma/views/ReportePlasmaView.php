<table>
<tr>
    <td align="right"><img src="../servidor/img/logopuce.jpg" alt="Logo CISEAL" style = "height:60px;"></td>
    <td></td>
    <td align="left"><img src="../servidor/img/urbs_logo.png" alt="Logo URBS" style = "height:60px;"></td>
</tr>
</table>
<br>
<br>
<div>
<table >
    <tr>
        <th rowspan = "2" COLSPAN="2"><h3 style="text-align:center">Formato técnico</h3></th>
        <td><b>Código: </b>GLA_R25</td>
    </tr>
    <tr>
        <td><b>Versión: </b>01</td>
    </tr>
    <tr>
        <th rowspan = "2" COLSPAN="2"><h3 style="text-align:center">Informe de Resultados Simplificado</h3></th>
        <td><b>Fecha de Edición: </b><?php echo $fecha;?></td>
    </tr>
</table>
</div>

<hr>
<table >
<tr>
    <td>
        <div>
            <b>Informe: </b>
            <?php echo $informe;?>
        </div>
    </td>
    <td>
        <div>
            <b>Responsable:</b>
            <?php echo $usuario;?>

        </div>
    </td>

</tr>
<tr>
    <td >
        <div>
            <b>Laboratorio: </b>
            <?php echo $laboratorio;?>

        </div>
    </td>

    <td>
        <div>
            <b>Fecha Emisión Informe: </b>
            <?php echo $fecha;?>

            <br>
        </div>
    </td>

</tr>
<tr>
    <td colspan="3" align="center">

        <b>1. DATOS PROVEEDOR </b>
    </td>
</tr>
<tr>
    <td>
        <div>
            <br>
            <b>Fecha de Recepción: </b>
            <?php echo $resultados['fecha_recepcion'][0]['fecha_recepcion'];?>

        </div>
    </td>
    <td>
        <div>
            <br>
            <b>Referencia: </b>
            <?php echo $referencia;?>

            <br>
        </div>
    </td>
</tr>
<tr>
    <td colspan="3" align="center">
        <b>3. RESULTADO DEL ENSAYO </b>
    </td>
</tr>
<tr>
    <td>
        <div>
            <b>Item de Ensayo: </b>
            <?php echo $id;?>
            <br>
        </div>

    </td>
</tr>
</table>

        <table border="1">
            <tr>
                <td>
                    <b>Marcador </b>
                </td>
                <td>
                    <b>Interpretacion </b>
                </td>
                <td>
                    <b>Resultado </b>
                </td>
            </tr>
            <?php //if(($resultados[0] != null)) :?>
            <?php foreach($resultados['aux'] as $aux):?>
                <tr>
                    <td>
                        <?php echo $aux['nombre'];?>
                    </td>
                    <td>
                        <?php echo $aux['descripcion'];?>
                    </td>
                    <td>
                        <?php echo $aux['valor'];?>
                    </td>
                </tr>
            <?php endforeach?>
            <?//php endif;?>
        </table>
<div>
<br>
</div>

<table>
<tr>
    <td colspan="3" align="center">
        <b>4. OBSERVACIONES Y COMENTARIOS </b>
    </td>
</tr>
<tr>
    <td colspan="3" align="center">
        <div>
            <?php echo $comentario;?>
            <br>
        </div>

        <br>
    </td>
</tr>
</table>

<table >
<tr >
    <th colspan="4" align="center">
        <b>REVISIÓN</b>
    </th>

    <th colspan="4" align="center">
        <b>APROBACIÓN</b>

    </th>

</tr>
<tr><th></th></tr>
<tr>
    <td>
        <b>Nombre:</b>
    </td>
    <td colspan="3" style="border: 0.8px solid black;">
    </td>
    <td>
        <b>Nombre:</b>
    </td>
    <td colspan="3" style="border: 0.8px solid black;">
    </td>
</tr>
<tr><th></th></tr>
<tr>
    <td>
        <b>Cargo:</b>
    </td>
    <td colspan="3" style="border: 0.8px solid black;">
    </td>
    <td>
        <b>Cargo:</b>
    </td>
    <td colspan="3" style="border: 0.8px solid black;">
    </td>
</tr>
<tr><th></th></tr>
<tr>
    <td>
        <b>Firma:</b>
    </td>
    <td colspan="3" style="border: 0.8px solid black;">
    </td>
    <td>
        <b>Firma:</b>
    </td>
    <td colspan="3" style="border: 0.8px solid black;">
    </td>
</tr>
<tr><th></th></tr>
<tr>
    <td>
        <b>Fecha:</b>
    </td>
    <td colspan="3" style="border: 0.8px solid black;">
    </td>
    <td>
        <b>Fecha:</b>
    </td>
    <td colspan="3" style="border: 0.8px solid black;">
    </td>
</tr>
</table>
