<?php
// views/verFacturacion.php
?>
<h3>Detalles de la Factura</h3>
<table class="table">
    <thead>
        <tr>
            <th>ID Factura</th>
            <th>ID Pago</th>
            <th>Fecha de Emisión</th>
            <th>Monto Total</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $factura['id_factura']; ?></td>
            <td><?php echo $factura['id_pago']; ?></td>
            <td><?php echo $factura['fecha_emision']; ?></td>
            <td><?php echo $factura['monto_total']; ?></td>
            <td><?php echo $factura['estado_factura']; ?></td>
        </tr>
    </tbody>
</table>

<a href="/facturacion" class="btn btn-primary">Volver a la lista de facturas</a>
