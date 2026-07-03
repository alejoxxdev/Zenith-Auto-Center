 <h2>Vehículo en Factura</h2>

            <form action="formulario.php?tabla=v_factura" method="post">
                <input type="hidden" name="tabla" value="vehiculo_factura" class="form-group">
                <input type="hidden" name="accion" value="crear">

                <div class="form-group">
                    <label for="id_factura1">Factura:</label>
                    <select name="id_factura1" id="id_factura1" class="form-control">
                        <option value="">Selecciona una factura</option>
                        <?php
                        $query = "SELECT * FROM factura";
                        $resultado = $conexion->query($query);
                        while ($factura = $resultado->fetch_assoc()):
                        ?>
                            <option value="<?php echo $factura['id_factura']; ?>"><?php echo $factura['id_factura']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_vehiculo1">Vehículo:</label>
                    <select name="id_vehiculo1" id="id_vehiculo1" class="form-control">
                        <option value="">Selecciona un vehículo</option>
                        <?php
                        $query = "SELECT * FROM vehiculo";
                        $resultado = $conexion->query($query);
                        while ($vehiculo = $resultado->fetch_assoc()):
                        ?>
                            <option value="<?php echo $vehiculo['id_vehiculo']; ?>"><?php echo $vehiculo['id_vehiculo']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="precio_unitario">Precio Unitario:</label>
                    <input class="form-control" type="number" id="precio_unitario" name="precio_unitario" placeholder="Ingresa el precio unitario" required>
                </div>
                
                <div class="form-group">
                    <label for="cantidad">Cantidad:</label>
                    <input class="form-control" type="number" id="cantidad" name="cantidad" placeholder="Ingresa la cantidad" required>
                </div>

                <div class="form-group">
                    <label for="subtotal">Subtotal:</label>
                    <input class="form-control" type="number" id="subtotal" name="subtotal" placeholder="Ingresa el subtotal" required>
                </div>

                <div class="form-group">
                    <button class="btn" type="submit">Agregar vehículo en factura</button>
                </div>
            </form>


            <form action="formulario.php" method="get">
                <div class="form-group">
                    <input type="hidden" name="tabla" value="v_factura">
                    <label for="buscar">Buscar vehículo en factura:</label>
                    <input class="form-control" type="text" name="buscar" placeholder="Buscar vehículo en factura">
                    <button class="btn" type="submit">Buscar</button>
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vehiculo</th>
                        <th>Factura</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
                    $query = "SELECT * FROM vehiculo_factura WHERE id_vehiculo1 LIKE '%$buscar%' OR id_factura1 LIKE '%$buscar%' OR precio_unitario LIKE '%$buscar%' OR cantidad LIKE '%$buscar%' OR subtotal LIKE '%$buscar%'";
                    $resultado = $conexion->query($query);
                    while ($v_factura = $resultado->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $v_factura['id_vehiculo_factura']; ?></td>
                            <td><?php echo $conexion->query("SELECT nombre_vehiculo FROM vehiculo WHERE id_vehiculo = " . $v_factura['id_vehiculo1'])->fetch_assoc()['nombre_vehiculo']; ?></td>
                            <td><?php echo $v_factura['id_factura1']; ?></td>
                            <td><?php echo $v_factura['precio_unitario']; ?></td>
                            <td><?php echo $v_factura['cantidad']; ?></td>
                            <td><?php echo $v_factura['subtotal']; ?></td>
                            <td class="acciones">
                                <div class="botones-contenedor">
                                    <form action="formulario.php" method="get" style="display: inline;">
                                        <input type="hidden" name="id_v_factura" value="<?php echo $v_factura['id_vehiculo_factura']; ?>">
                                        <input type="hidden" name="tabla" value="v_factura">
                                        <input type="hidden" name="t_formulario" value="formularios_editar">
                                        <button type="submit" class="btn btn-editar">Editar</button>
                                    </form>
                                    <form action="formulario.php?tabla=v_factura" method="post" style="display: inline;">
                                        <input type="hidden" name="id_v_factura" value="<?php echo $v_factura['id_vehiculo_factura']; ?>">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="tabla" value="v_factura">
                                        <div class="form-group">
                                            <button class="btn" type="submit" class="btn-eliminar">Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>