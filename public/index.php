<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Electrodomésticos</title>
    <link rel="stylesheet" href="./css/tailwind.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Formulario de  Electrodoméstico</h2>
        <form id="electrodomesticoForm" action="index.php" method="post">
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre del Electrodoméstico:</label>
                <input type="text" id="nombre" name="nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <p id="nombreError" class="text-red-500 text-xs italic mt-2 hidden">El nombre debe contener solo letras.</p>
            </div>
            <div class="mb-4">
                <label for="color" class="block text-gray-700 font-semibold mb-2">Color:</label>
                <input type="text" id="color" name="color" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="consumo" class="block text-gray-700 font-semibold mb-2">Consumo Energético (A-C):</label>
                <select id="consumo" name="consumo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Seleccionar</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="peso" class="block text-gray-700 font-semibold mb-2">Peso (kg):</label>
                <input type="number" id="peso" name="peso" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <p id="pesoError" class="text-red-500 text-xs italic mt-2 hidden">El peso debe contener solo números.</p>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Enviar</button>
            </div>
        </form>

        <?php

// Función para calcular el precio del producto
function calcularPrecio($consumo, $peso)
{
    $preciosConsumo = array(
        'A' => 100,
        'B' => 80,
        'C' => 60
    );

    // Obtener precio del consumo energético
    $precioConsumo = isset($preciosConsumo[$consumo]) ? $preciosConsumo[$consumo] : $preciosConsumo['C'];

    // Obtener precio del peso
    $precioPeso = ($peso >= 0 && $peso <= 19) ? 10 : 50;

    // Calcular precio final
    return $precioConsumo * $precioPeso;
}

// Función para calcular el descuento del producto
function calcularDescuento($precio, $color)
{
    $descuentosColor = array(
        'blanco' => 5,
        'gris' => 7,
        'negro' => 10
    );

    // Convertir el color a minúsculas para hacer coincidir con las claves del array
    $color = strtolower($color);

    // Obtener el porcentaje de descuento según el color
    $porcentajeDescuento = isset($descuentosColor[$color]) ? $descuentosColor[$color] : $descuentosColor['blanco'];

    // Calcular el valor del descuento
    return ($precio * $porcentajeDescuento) / 100;
}

// Función para almacenar la información del producto en un array asociativo
function almacenarInformacion($nombre, $color, $consumo, $peso, $precioProducto, $descuento)
{
    return array(
        "nombre" => $nombre,
        "color" => $color,
        "consumo" => $consumo,
        "peso" => $peso,
        "precioProducto" => $precioProducto,
        "descuento" => $descuento
    );
}

// Función para mostrar la información del producto
function mostrarInformacionProducto($producto)
{
    echo "<div class='mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded'>
            <p><strong>Nombre del Electrodoméstico:</strong> {$producto['nombre']}</p>
            <p><strong>Color:</strong> {$producto['color']}</p>
            <p><strong>Consumo Energético:</strong> {$producto['consumo']}</p>
            <p><strong>Peso:</strong> {$producto['peso']} kg</p>
            <p><strong>Precio del Producto:</strong> {$producto['precioProducto']} $</p>
            <p><strong>Valor del Descuento:</strong> {$producto['descuento']} $</p>
          </div>";
}

// Función para procesar el formulario y mostrar la información del producto
function procesarFormulario()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $color = htmlspecialchars($_POST["color"]);
        $consumo = htmlspecialchars($_POST["consumo"]);
        $peso = htmlspecialchars($_POST["peso"]);

        if (!in_array($consumo, ['A', 'B', 'C'])) {
            $consumo = 'C';
        }

        if ($peso < 0 || $peso > 49) {
            $peso = 1;
        }

        $coloresValidos = ['blanco', 'gris', 'negro'];
        if (!in_array(strtolower($color), $coloresValidos)) {
            $color = 'blanco';
        }

        $precioProducto = calcularPrecio($consumo, $peso);
        $descuento = calcularDescuento($precioProducto, $color);
        $precioFinal = $precioProducto - $descuento;

        // Almacenar la información del producto en un array asociativo
        $producto = almacenarInformacion($nombre, $color, $consumo, $peso, $precioProducto, $descuento);

        // Mostrar la información del producto
        mostrarInformacionProducto($producto);
    }
}

// Llama a la función para procesar el formulario
procesarFormulario();

?>
    </div>
    <script src="main.js"></script>
</body>
</html>
