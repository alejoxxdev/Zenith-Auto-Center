<?php
header('Content-Type: application/json');
error_reporting(E_ALL);

error_log("Inicio PHP");

$data = json_decode(file_get_contents('php://input'), true);
error_log("Datos decodificados: " . print_r($data, true));

$errores = [];

include 'conexion.php';
error_log("Conexión incluida");

$sql = "INSERT INTO vehiculo (placa_vehiculo, marca, nombre_vehiculo, modelo, color, categoria, detalles_vehiculo, imagen, precio_venta_vehiculo, codigo_vendedor1, RUT_proveedor1) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
error_log("SQL preparado");

foreach ($data as $vehiculo) {
    error_log("Procesando vehículo: " . print_r($vehiculo, true));

    // Validación de campos obligatorios
    if (
        empty($vehiculo['marca']) ||
        empty($vehiculo['vehiculo']) ||
        empty($vehiculo['modelo']) ||
        empty($vehiculo['color']) ||
        empty($vehiculo['categoria']['id']) ||
        empty($vehiculo['detalles']) ||
        empty($vehiculo['imagen']) ||
        !isset($vehiculo['precio'])
    ) {
        $errores[] = "Faltan datos en el vehículo: " . print_r($vehiculo, true);
        continue;
    }

    $placa_vehiculo = "VEH-" . random_int(100, 999);

    // Obtén cualquier vendedor y proveedor válidos
    $codigo_vendedor = $conexion->query("SELECT codigo_vendedor FROM vendedor LIMIT 1")->fetch_assoc()['codigo_vendedor'] ?? 'VEND-001';
    $rut_proveedor = $conexion->query("SELECT RUT_proveedor FROM proveedor LIMIT 1")->fetch_assoc()['RUT_proveedor'] ?? 'PROV-001';

    $stmt->bind_param(
        "ssssssssdss",
        $placa_vehiculo,
        $vehiculo['marca'],
        $vehiculo['vehiculo'],
        $vehiculo['modelo'],
        $vehiculo['color'],
        $vehiculo['categoria']['id'],
        $vehiculo['detalles'],
        $vehiculo['imagen'],
        $vehiculo['precio'],
        $codigo_vendedor,
        $rut_proveedor
    );
    if (!$stmt->execute()) {
        $errores[] = $stmt->error;
        error_log("Error al ejecutar: " . $stmt->error);
    }
}

error_log("Finalizando PHP");

echo json_encode([
    'status' => empty($errores) ? 'ok' : 'error',
    'recibidos' => count($data),
    'errores' => $errores
]);
exit;
?>