<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title> Cart </title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "site/header.php" ?>

    <div class="container space-header mb-5">
        <div class="row g-5">

        
            <div class="col-12 col-md-12 col-lg-8">
                


                <!-- PRODUCTOS EN EL CARRITO -->

                <?php 
            if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                $totalProductos = 0; // Inicializar el contador de productos
                $precioTotal = 0; // Inicializar el total del precio

            foreach ($_SESSION['carrito'] as $inventario_id => $detalle){ 

                $totalProductos += $detalle['cant_prend']; // Incrementar el contador de productos
                $precioTotal += $detalle['cant_prend'] * $detalle['prec_pren']; // Calcular el total del precio
                ?>   
            
                
                <div class="bg-light mb-3">
                    <div class="row">

                        <!-- Imagen del Producto -->
                        <div class="col-3 col-md-3 col-lg-3 d-flex align-items-center">
                            <div class="container-cart-img overflow-hidden">
                                <a href="producto.php?cve_inv=<?php echo $inventario_id; ?>"> <img src="<?php echo $detalle['img_pren']; ?>" alt=""> </a>
                            </div>
                        </div>

                        <!-- Información del Producto -->
                        <div class="container-cart-prod col-8 col-md-8 col-lg-8 d-flex flex-column py-3">
                            <!-- Nombre de Prenda -->
                            <a href="producto.php?cve_inv=<?php echo $inventario_id; ?>"> <?php echo $detalle['nom_pren']; ?> </a>
                            <!-- Talla -->
                            <span class="text-muted">Talla: <?php echo $detalle['tall_pren']; ?></span>

                            
                            <div class="row mt-auto">
                                <div class="col-4 col-md-5 col-lg-7 float-end d-flex align-items-center">
                                    <span class="precio-cart">$<?php echo $detalle['prec_pren']; ?></span>
                                </div>

                                <div class="col-8 col-md-7 col-lg-5 d-flex flex-row">
                                    <a href="php/deleteCart.php?cve_inv=<?php echo $inventario_id; ?>" class="btn border-0"> <i class="bi bi-trash"></i> </a>


                                <!-- Selector de cantidad -->
                                <div class="input-group input-group-sm">
                                    <form action="php/editCart.php" method="POST">
                                        <input type="hidden" name="cve_inv" value="<?php echo $inventario_id; ?>">
                                        <input type="hidden" name="increment" value="-1"> <!-- Valor por defecto, decremento -->
                                        <button type="submit" class="btn btn-outline-dark" id="decrementBtn">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                    </form>
                                            
                                    <input type="number" class="form-control text-center" id="quantityInput" value="<?php echo $detalle['cant_prend']; ?>" readonly>
                                            
                                    <form action="php/editCart.php" method="POST">
                                        <input type="hidden" name="cve_inv" value="<?php echo $inventario_id; ?>">
                                        <input type="hidden" name="increment" value="1"> <!-- Incremento -->
                                        <button type="submit" class="btn btn-outline-dark" id="incrementBtn">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </form>
                                </div>

                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>
                <?php } ?>

            </div>

            <?php

            ?>
                <!-- Resumen de Pedido -->
                <div class="resumen-pedido col-12 col-md-12 col-lg-4">
                    <div class="bg-light p-3">
                        <h4> Resumen del pedido </h4>
                        <p>Total de productos <span> (<?php echo $totalProductos; ?>) </span> </p>
                        <span class="text-end fs-6"> $MXN <?php echo number_format($precioTotal, 2); ?> </span>
                        <?php
                        // Verificar si las variables de dirección del cliente están definidas
                        if (isset($_SESSION['cliente']) && !empty($_SESSION['cliente']['cve_mun'])) {
                            // Verificar si las variables de facturación electrónica están definidas
                            if (isset($_SESSION['cliente']['razs_clie']) && isset($_SESSION['cliente']['rfc_clie']) && isset($_SESSION['cliente']['regf_clie']) && isset($_SESSION['cliente']['cfdi_clie'])) {
                        ?>
                                <button type="button" class="btn btn-dark w-100 rounded-0 mt-4" data-bs-toggle="modal" data-bs-target="#modalPago">
                                    PAGAR AHORA
                                </button>
                        <?php
                            } else {
                                echo '<div class="alert alert-danger rounded-0 mt-3" role="alert">Debes configurar la <a href="account.php?page=factura_electronica" style="color: red; text-decoration: underline;">facturación electrónica.</a></div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger rounded-0 mt-3" role="alert">Debes agregar una <a href="account.php?page=mi_direccion" style="color: red; text-decoration: underline;">dirección.</a></div>';
                        }
                        ?>
                    </div>
                </div>
            <?php


        } else {
    ?>

            

        </div>
    </div>
    
    


    <div class="container text-center mt-5">
        <i class="bi bi-cart-x" style="font-size: 100px; color: #999;"></i>
        <h4 class="mt-3">Tu carrito de compras está vacío</h4>
        <p>¡Agrega productos a tu carrito para comenzar a comprar!</p>
    </div>

    <?php
        }
    ?>

    <!-- Modal de Pago -->
    <div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 ">
                <div class="modal-header">
                    <h5 class="modal-title  mx-4" id="modalPagoLabel">Pagar Ahora</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  mx-4">

                    <div id="smart-button-container">
                          <div style="text-align: center;">
                            <div id="paypal-button-container"></div>
                          </div>
                        </div>
                      <script src="https://www.paypal.com/sdk/js?client-id=AQReDOrCDtDsD5DHo_V_hqENxgj5NqOj_X1xsV0V8Vxw6zvJOQgLieBQn3QA3yOUcRJukv-SVcNAy8Na&currency=MXN" data-sdk-integration-source="button-factory"></script>
                      <script>
                        function initPayPalButton() {
                          paypal.Buttons({
                            style: {
                              shape: 'rect',
                              color: 'gold',
                              layout: 'vertical',
                              label: 'pay',
                            
                            },
                        
                            createOrder: function(data, actions) {
                              return actions.order.create({
                                purchase_units: [{"description":"LA DESCRIPCION DE TU PRODUCTO","amount":{"currency_code":"MXN","value":<?php echo $precioTotal ?>}}]
                              });
                            },
                        
                            onApprove: function(data, actions) {
                              return actions.order.capture().then(function(orderData) {

                                // Full available details
                                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                            
                    actions.redirect('http://localhost/yasui/php/pago.php?imp_pago=' + encodeURIComponent('<?php echo $precioTotal ?>'));

                              });
                            },
                        
                            onError: function(err) {
                              console.log(err);
                            }
                          }).render('#paypal-button-container');
                        }
                        initPayPalButton();
                      </script>

                </div>

            </div>
        </div>
    </div>


    <!-- Modal de Confirmación de Compra -->
    <div class="modal fade" id="modalConfirmacionCompra" tabindex="-1" aria-labelledby="modalConfirmacionCompraLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 ">
                <div class="modal-header">
                    <h5 class="modal-title  mx-4" id="modalConfirmacionCompraLabel">Confirmación de Compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  mx-4">
                    
                ¡Compra realizada con éxito!
                ¿Deseas generar una factura electrónica?

                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <div class="mx-4">
                        <a href="php/generar_factura.php" class="btn btn-dark rounded-0 px-5" target="_blank" onclick="cerrarModal()">GENERAR FACTURA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrarOcultarCampoTarjeta() {
            var metodoPago = document.getElementById("metodoPagoModal").value;
            var campoTarjeta = document.getElementById("campoTarjeta");
        
            // Si la opción seleccionada es "paypal", oculta el campo de número de tarjeta y lo marca como no requerido
            if (metodoPago === "paypal") {
                campoTarjeta.style.display = "none";
                document.getElementById("tar_clie").removeAttribute("required");
            } else {
                // Si la opción seleccionada es otra, muestra el campo de número de tarjeta y lo marca como requerido
                campoTarjeta.style.display = "block";
                document.getElementById("tar_clie").setAttribute("required", "required");
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php
            // Verifica si se ha realizado la compra (variable de sesión)
            if (isset($_SESSION['compra_realizada']) && $_SESSION['compra_realizada']) {
                unset($_SESSION['compra_realizada']); // Limpia la variable de sesión
            ?>
                // Muestra el modal de confirmación de compra
                $('#modalConfirmacionCompra').modal('show');
            <?php
            }
            ?>
        });
    </script>
    
    <!-- Script para cerrar el modal al hacer clic en el enlace -->
    <script>
        function cerrarModal() {
            $('#modalConfirmacionCompra').modal('hide');
        }
    </script>

</body>

</html>