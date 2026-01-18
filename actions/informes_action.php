<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

//TOTAL VENTAS 30 DIAS

$sql_ventas_30dias = "SELECT 
                        SUM(total) AS total_ventas
                    FROM pedidos
                    WHERE (estado = 'creado' OR estado = 'preparado' OR estado = 'enviado')
                    AND fecha >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
$stmt_ventas_30dias = $con->prepare($sql_ventas_30dias);
$stmt_ventas_30dias->execute();
$resultado = $stmt_ventas_30dias->fetch(PDO::FETCH_ASSOC);
$total_ventas_30dias = $resultado['total_ventas'] ?? 0;

//VENTAS ULTIMOS 7 DIAS

$sql_ventas_7dias = "SELECT SUM(total) AS total_ventas
                    FROM pedidos
                    WHERE (estado = 'creado' OR estado = 'preparado' OR estado = 'enviado')
                    AND fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
$stmt_ventas_7dias = $con->prepare($sql_ventas_7dias);
$stmt_ventas_7dias->execute();
$resultado = $stmt_ventas_7dias->fetch(PDO::FETCH_ASSOC);
$total_ventas_7dias = $resultado['total_ventas'] ?? 0;

//TOTAL VENTAS ULTIMOS 12 MESES
$sql_ventas_mensuales = "SELECT 
                            SUM(total) AS total_ventas
                        FROM pedidos
                        WHERE (estado = 'creado' OR estado = 'preparado' OR estado = 'enviado')
                        AND fecha >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)";
$stmt_ventas_12meses = $con->prepare($sql_ventas_mensuales);
$stmt_ventas_12meses->execute();
$resultado = $stmt_ventas_12meses->fetch(PDO::FETCH_ASSOC);
$total_ventas_12meses = $resultado['total_ventas'] ?? 0;

                        

//PRODUCTOS MAS VENDIDOS
$sql_productos_mas_vendidos = "SELECT 
                                    a.codigo,
                                    a.nombre,
                                    SUM(lp.cantidad) AS total_vendido
                                FROM lineapedido lp
                                JOIN articulos a ON lp.codArticulo= a.codigo
                                JOIN pedidos p ON lp.numPedido = p.idPedido
                                WHERE p.estado = 'creado' OR p.estado = 'preparado' OR p.estado = 'enviado'
                                GROUP BY a.codigo, a.nombre
                                ORDER BY total_vendido DESC
                                LIMIT 5";
$stmt_productos_mas_vendidos = $con->prepare($sql_productos_mas_vendidos);
$stmt_productos_mas_vendidos->execute();
$productos_mas_vendidos = $stmt_productos_mas_vendidos->fetchAll(PDO::FETCH_ASSOC);