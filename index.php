<?php

// Asegúrate de que Telegram envíe las solicitudes al archivo PHP correctamente

echo "Hola";

// Tu token de Telegram
$token = '8024202425:AAHZU-uiizGkjfUweisefXFMx4QSd7G-ENs';
$api_url = "https://api.telegram.org/bot$token/";

// Diccionario de pasillos
$pasillos = [
    "pasillo 1" => ["Carne", "Queso", "Jamón"],
    "pasillo 2" => ["Leche", "Yogurth", "Cereal"],
    "pasillo 3" => ["Bebidas", "Jugos"],
    "pasillo 4" => ["Pan", "Pasteles", "Tortas"],
    "pasillo 5" => ["Detergente", "Lavaloza"]
];

// Recibir los datos de Telegram en formato JSON
$input = file_get_contents('php://input');
$update = json_decode($input, true);

// Verifica si recibimos una actualización con un mensaje
if (isset($update['message'])) {
    $message = $update['message'];
    $chat_id = $message['chat']['id'];
    $text = strtolower(trim($message['text'] ?? ""));

    // Respuesta predeterminada
    $respuesta = "Lo siento, no encontré ese producto.";

    // Buscar el producto en los pasillos
    foreach ($pasillos as $pasillo => $productos) {
        foreach ($productos as $producto) {
            if (strpos(strtolower($text), strtolower($producto)) !== false) {
                $respuesta = "El producto '$producto' se encuentra en el $pasillo.";
                break 2; // Rompe ambos bucles cuando se encuentra el producto
            }
        }
    }

    // Si el texto es "hola"
    if ($text == "hola") {
        $respuesta = "¡Hola! ¿En qué te puedo ayudar?";
    }

    // Enviar la respuesta al usuario de Telegram
    $url = $api_url . "sendMessage?chat_id=$chat_id&text=" . urlencode($respuesta);
    file_get_contents($url);
}

?>
