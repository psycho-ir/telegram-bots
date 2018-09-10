<?php
flush();
ob_start();
error_reporting(0);
date_default_timezone_set('Asia/Tehran');
//--------[Your Config]--------//
$Dev = 627662818;
$Channel = 'fandoghtest'; //--Input Channel ID
$Token = '627662818:AAEKPxW3fVmci11fJ_OIuOUTshY6n4nYZF0'; //--Input Token in ' '
//-----------------------------//
define('API_KEY',$Token);
//------------------------------------------------------------------------------
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
    }
//------------------------------------------------------------------------------
function SendMessage($chat_id, $text, $mode, $reply, $keyboard = null){
	bot('SendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'parse_mode'=>$mode,
	'reply_to_message_id'=>$reply,
	'reply_markup'=>$keyboard
	]);
}
function EditMsg($chatid, $msgid, $text, $keyboard = null){
    bot('EditMessageText', [
    'chat_id'=>$chatid,
    'message_id'=>$msgid,
    'text'=>$text,
    'reply_markup'=>$keyboard
    ]);
}
function Forward($chat_id,$from_id,$massege_id){
    bot('ForwardMessage',[
    'chat_id'=>$chat_id,
    'from_chat_id'=>$from_id,
    'message_id'=>$massege_id
    ]);
}
function objectToArrays($object){
    if (!is_object($object) && !is_array($object)) {
        return $object;
    }
    if (is_object($object)) {
    $object = get_object_vars($object);
    }
    return array_map("objectToArrays", $object);
}
//------------------------------------------------------------------------------
$update = json_decode(file_get_contents('php://input'));
$message = $update->message; 
$chat_id = $message->chat->id;
$text = $message->text;
$message_id = $update->message->message_id;
$from_id = $message->from->id;
$name = $message->from->first_name;
$lastname = $message->from->last_name;
$username = $message->from->username;
$data = $update->callback_query->data;
$chatid = $update->callback_query->message->chat->id;
$fromid = $update->callback_query->from->id;
$messageid = $update->callback_query->message->message_id;
$now = date('h:i:s');
//--------[Auto Configer]--------//
if(!is_dir("data")){mkdir("data");}
//--------[Json]--------//
$user = json_decode(file_get_contents("data/user.json"),true);
$All = $user['userlist'];
$users = json_decode(file_get_contents("data/data.json"),true);
$ban = $users[$from_id]['ban'];
$step = $users[$from_id]['step'];
//--------[Rank in Channel]--------//
@$forchaneel = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@$Channel&user_id=".$from_id)); 
@$tch = $forchaneel->result->status;
//--------[Buttons]--------//
$home = json_encode(['resize_keyboard' => true,
'inline_keyboard'=>[
[['text' => "تنظیم وب هوک", 'callback_data' => "set"]],
[['text' => "اطلاعات توکن", 'callback_data' => "info"],['text' => "حذف وبهوک", 'callback_data' => "del"]],
]]);
$endset = json_encode(['resize_keyboard' => true,
'inline_keyboard'=>[
[['text' => "تنظیم کردن", 'callback_data' => "doneset"]],
]]);
$enddel = json_encode(['resize_keyboard' => true,
'inline_keyboard'=>[
[['text' => "حذف وبهوک", 'callback_data' => "donedel"]],
]]);
$back = json_encode(['resize_keyboard' => true,
'inline_keyboard'=>[
[['text' => "بازگشت", 'callback_data' => "back"]],
]]);
$panel = json_encode(['keyboard'=>[
[['text'=>"آمار"]],
[['text'=>"فروارد همگانی"],['text'=>"ارسال همگانی"]],
[['text'=>"حذف مسدود کاربر"],['text'=>"مسدود کاربر"]],
[['text'=>"▫️ برگشت ▫️"]]
],'resize_keyboard'=>true]);
$back_panel = json_encode(['keyboard'=>[
[['text'=>"بازگشت"]]
],'resize_keyboard'=>true]);
//----------------//
?>
