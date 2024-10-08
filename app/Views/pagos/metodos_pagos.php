<style>
    h2,
    h3,
    label {
        color: #2e7d32;
        /* Dark Green for headings */
    }

    .form-control,
    select {
        border: 1px solid #4caf50;
        /* Green border */
        box-shadow: none;
    }

    button {
        background-color: #4caf50;
        /* Green button */
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #388e3c;
    }

    #informacion_pago {
        margin-top: 20px;
        border: 1px solid #e0e0e0;
        padding: 15px;
        border-radius: 5px;
    }

    #informacion_pago h3 {
        margin-bottom: 10px;
    }

    #informacion_pago img {
        max-width: 200px;
        margin: 10px 0;
    }
</style>

<body>
    <div class="container mt-5">
        <h2>Seleccionar Método de Pago</h2>

        <form action="<?= site_url('pago/procesar') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="metodo_pago">Método de Pago:</label>
                <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                    <option value="TARJETA">Tarjeta</option>
                    <option value="TRANSFERENCIA">Transferencia Bancaria</option>
                    <!-- <option value="EFECTIVO">Efectivo</option> -->
                    <option value="QR">QR</option>
                </select>
            </div>

            <!-- Display payment info (transfer or QR) based on method selected -->
            <div id="informacion_pago" style="display:none;">
                <!-- Transferencia Bancaria -->
                <div id="info_transferencia" style="display:none;">
                    <h3>Datos para Transferencia Bancaria</h3>
                    <?php if ($transferencia): ?>
                        <?= $transferencia['Contenido']; ?>
                    <?php else: ?>
                        <p>No se encontraron datos de transferencia bancaria.</p>
                    <?php endif; ?>
                </div>

                <!-- QR Code -->
                <div id="info_qr" style="display:none;">
                    <h3>Código QR</h3>
                    <?php if ($qr): ?>
                        <img src="<?=  $qr['Imagen']; ?>" alt="Código QR">
                        <p>Escanea este código con tu app bancaria.</p>
                    <?php else: ?>
                        <p>No se encontró el código QR.</p>
                    <?php endif; ?>
                </div>

                <div id="comprobante" style="display:none;">
                    <label for="comprobante">Subir Comprobante:</label>
                    <input type="file" name="comprobante" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf">
                </div>
            </div>

            <input type="hidden" name="id_compra" value="<?php echo ($ID);?>">
            <button type="submit" class="mt-3">Procesar Pago</button>
        </form>

    </div>

    <script>
        document.querySelector('#metodo_pago').addEventListener('change', function () {
            var metodo = this.value;
            var informacionPago = document.getElementById('informacion_pago');
            var transferencia = document.getElementById('info_transferencia');
            var qr = document.getElementById('info_qr');
            var comprobante = document.getElementById('comprobante');

            informacionPago.style.display = 'block';

            if (metodo === 'TRANSFERENCIA') {
                transferencia.style.display = 'block';
                qr.style.display = 'none';
                comprobante.style.display = 'block';
            } else if (metodo === 'QR') {
                transferencia.style.display = 'none';
                qr.style.display = 'block';
                comprobante.style.display = 'block';
            } else {
                transferencia.style.display = 'none';
                qr.style.display = 'none';
                comprobante.style.display = (metodo !== 'EFECTIVO') ? 'block' : 'none';
            }
        });
    </script>
</body>
<br>
<br><br><br>