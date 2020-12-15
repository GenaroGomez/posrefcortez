<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "codigo";
$valorVenta = $this->codigo;

$respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

$fecha = substr($respuestaVenta["fecha"],0,-8);
$productos = json_decode($respuestaVenta["productos"], true);
$neto = number_format($respuestaVenta["neto"],2);
$impuesto = number_format($respuestaVenta["impuesto"],2);
$total = number_format($respuestaVenta["total"],2);

//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id";
$valorCliente = $respuestaVenta["id_cliente"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_vendedor"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:150px"><img src="images/logo_grand.png"></td>

			<td style="background-color:white; width:140px">
				
				<div style="font-size:8.5px; text-align:right; line-height:15px;">

					<br>
					<b>Dirección:</b> Nicolás Romero

				</div>

			</td>

			<td style="background-color:white; width:140px">

				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					<br>
					<br>
					<br>
					<br>
					<b>Teléfono:</b> 55 76 12 12 23
					
					<br>
					<b>Email:</b> refaccionaria_cortes@gmail.com

				</div>
				
			</td>

			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br><b>Nota de Remisión</b><br>$valorVenta</td>

		</tr>

	</table>

	<hr style="color: #3447F2;" size="10" width="75%"/>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$bloque2 = <<<EOF
	
	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border-top-style:solid;
						border-top-color:#a5b8c9;
						border-top-width:3px;
						border-left-color:#FFFFFF;
						border-left-width:1px;
						border-left-style:solid;
						border-right-color:#FFFFFF;
						border-right-width:1px;border-right-style:solid;
						border-bottom-color:#a5b8c9;
						border-bottom-width:3px;
						border-bottom-style:solid;
						background-color:white;
						width:390px"><b>

				Cliente:</b> $respuestaCliente[nombre]
				
			</td>

			<td style="border-top-style:solid;
						border-top-color:#a5b8c9;
						border-top-width:3px;
						border-left-color:#FFFFFF;
						border-left-width:1px;
						border-left-style:solid;
						border-right-color:#FFFFFF;
						border-right-width:1px;border-right-style:solid;
						border-bottom-color:#a5b8c9;
						border-bottom-width:3px;
						border-bottom-style:solid;
						background-color:white;
						width:150px;
						text-align:right">
			
				<b>Fecha:</b> $fecha
				
			</td>

		</tr>

		<tr>
		
			<td style="border-top-style:solid;
						border-top-color:#a5b8c9;
						border-top-width:3px;
						border-left-color:#FFFFFF;
						border-left-width:1px;
						border-left-style:solid;
						border-right-color:#FFFFFF;
						border-right-width:1px;border-right-style:solid;
						border-bottom-color:#a5b8c9;
						border-bottom-width:3px;
						border-bottom-style:solid;
				background-color:white;
				width:540px">
				<b>Vendedor:</b> $respuestaVendedor[nombre]</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF
	<br>
	<br>
	<br>
	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border-top-style:solid;
					border-top-color:#a5b8c9;
					border-top-width:3px;
					border-left-color:#FFFFFF;
					border-left-width:1px;
					border-left-style:solid;
					border-right-color:#FFFFFF;
					border-right-width:1px;border-right-style:solid;
					border-bottom-color:#a5b8c9;
					border-bottom-width:3px;
					border-bottom-style:solid;
					background-color:white;
					width:260px;
					text-align:center">
			<b>Producto</b></td>
		<td style="border-top-style:solid;
					border-top-color:#a5b8c9;
					border-top-width:3px;
					border-left-color:#FFFFFF;
					border-left-width:1px;
					border-left-style:solid;
					border-right-color:#FFFFFF;
					border-right-width:1px;border-right-style:solid;
					border-bottom-color:#a5b8c9;
					border-bottom-width:3px;
					border-bottom-style:solid;
				background-color:white;
				width:80px;
				text-align:center">
					<b>Cantidad</b></td>
		<td style="border-top-style:solid;
					border-top-color:#a5b8c9;
					border-top-width:3px;
					border-left-color:#FFFFFF;
					border-left-width:1px;
					border-left-style:solid;
					border-right-color:#FFFFFF;
					border-right-width:1px;border-right-style:solid;
					border-bottom-color:#a5b8c9;
					border-bottom-width:3px;
					border-bottom-style:solid;
				background-color:white;
				width:100px;
				text-align:center">
				<b>Valor Unit.</b></td>
		<td style="border-top-style:solid;
					border-top-color:#a5b8c9;
					border-top-width:3px;
					border-left-color:#FFFFFF;
					border-left-width:1px;
					border-left-style:solid;
					border-right-color:#FFFFFF;
					border-right-width:1px;border-right-style:solid;
					border-bottom-color:#a5b8c9;
					border-bottom-width:3px;
					border-bottom-style:solid;
				background-color:white;
				width:100px;
				text-align:center">
				<b>Valor Total</b></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {

$itemProducto = "descripcion";
$valorProducto = $item["descripcion"];
$orden = null;

$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

$valorUnitario = number_format($respuestaProducto["precio_venta"], 2);

$precioTotal = number_format($item["total"], 2);

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			<td style="border: none; color:#333; background-color:white; width:260px; text-align:center">
				$item[descripcion]
			</td>

			<td style="border: none; color:#333; background-color:white; width:80px; text-align:center">
				$item[cantidad]
			</td>

			<td style="border: none; color:#333; background-color:white; width:100px; text-align:center">$ 
				$valorUnitario
			</td>

			<td style="border: none; color:#333; background-color:white; width:100px; text-align:center">$ 
				$precioTotal
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

// ---------------------------------------------------------

$bloque5 = <<<EOF
	
	<br>
	<br>
	<table style="font-size:10px; padding:5px 10px;">
		
		<tr>
		
			<td style="border-right: none; background-color:white; width:340px; text-align:center"></td>

			<td style="border-top-style:solid;
						border-top-color:#a5b8c9;
						border-top-width:3px;
						border-left-color:#FFFFFF;
						border-left-width:1px;
						border-left-style:solid;
						border-right-color:#FFFFFF;
						border-right-width:1px;border-right-style:solid;
						border-bottom-color:#a5b8c9;
						border-bottom-width:3px;
						border-bottom-style:solid;
						background-color:white;
						width:100px;
						text-align:center">
						<b>Neto:</b></td>

			<td style="border-top-style:solid;
					border-top-color:#a5b8c9;
					border-top-width:3px;
					border-left-color:#FFFFFF;
					border-left-width:1px;
					border-left-style:solid;
					border-right-color:#FFFFFF;
					border-right-width:1px;border-right-style:solid;
					border-bottom-color:#a5b8c9;
					border-bottom-width:3px;
					border-bottom-style:solid;
					background-color:white;
					width:100px;
					text-align:center">
				$ $neto
			</td>

		</tr>

		<tr>

			<td style="border-right: none; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: none; background-color:white; width:100px; text-align:center"><b>
				Impuesto:
				</b>
			</td>
		
			<td style="border: none; color:#333; background-color:white; width:100px; text-align:center">
				$ $impuesto
			</td>

		</tr>
		<br>
		<tr>

			<td style="border-top-style:solid;
				border-top-color:#a5b8c9;
				border-top-width:3px;
				border-left-color:#FFFFFF;
				border-left-width:1px;
				border-left-style:solid;
				border-right-color:#FFFFFF;
				border-right-width:1px;border-right-style:solid;
				border-bottom-color:#a5b8c9;
				border-bottom-width:2px;
				border-bottom-style:solid;
			    background-color:white; width:340px;
			    text-align:center"></td>

			<td style="border-top-style:solid;
				border-top-color:#a5b8c9;
				border-top-width:3px;
				border-left-color:#FFFFFF;
				border-left-width:1px;
				border-left-style:solid;
				border-right-color:#FFFFFF;
				border-right-width:1px;border-right-style:solid;
				border-bottom-color:#a5b8c9;
				border-bottom-width:2px;
				border-bottom-style:solid;
				background-color:white; width:100px;
				text-align:center"><b>
				Total:</b>
			</td>
			
			<td style="border-top-style:solid;
				border-top-color:#a5b8c9;
				border-top-width:3px;
				border-left-color:#FFFFFF;
				border-left-width:1px;
				border-left-style:solid;
				border-right-color:#FFFFFF;
				border-right-width:3px;
				border-right-style:solid;
				border-bottom-color:#a5b8c9;
				border-bottom-width:2px;
				border-bottom-style:solid;
				background-color:white;
				width:100px;
				text-align:center">
				$ $total
			</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');


// ---------------------------------------------------------

$bloque6 = <<<EOF
	
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
		<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border-top-style:solid;
						border-top-color:#a5b8c9;
						border-top-width:1px;
						border-left-color:#FFFFFF;
						border-left-width:1px;
						border-left-style:solid;
						border-right-color:#FFFFFF;
						border-right-width:1px;border-right-style:solid;
						border-bottom-color:#a5b8c9;
						border-bottom-width:1px;
						border-bottom-style:solid;
						background-color:white;
						width:230px"><i>* No se aceptan cambios ni devoluciones</i> 
				
			</td>
        </tr>

        <tr>

			<td style="border-top-style:solid;
						border-top-color:#a5b8c9;
						border-top-width:1px;
						border-left-color:#FFFFFF;
						border-left-width:1px;
						border-left-style:solid;
						border-right-color:#FFFFFF;
						border-right-width:1px;border-right-style:solid;
						border-bottom-color:#a5b8c9;
						border-bottom-width:1px;
						border-bottom-style:solid;
						background-color:white;
						width:230px;
						text-align:right">
				<i>*La garantía solo aplica por defecto de fábrica</i>
				
			</td>

        </tr>

		<tr>
		
			<td style="border-top-style:solid;
						border-top-color:#a5b8c9;
						border-top-width:1px;
						border-left-color:#FFFFFF;
						border-left-width:1px;
						border-left-style:solid;
						border-right-color:#FFFFFF;
						border-right-width:1px;border-right-style:solid;
						border-bottom-color:#a5b8c9;
						border-bottom-width:1px;
						border-bottom-style:solid;
				background-color:white;
				width:230px">
				<i>*Favor de revisar su cambio antes de salir</i></td>
		</tr>
	
    </table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');


// ---------------------------------------------------------
//SALIDA DEL ARCHIVO

$pdf->Output('factura.pdf', 'D');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();

?>