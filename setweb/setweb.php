<?php 
ini_set("log_errors" , "off");
flush();
$API_KEY = 'توکن ربات'; 
define('API_KEY',$API_KEY);
##------------------------------##

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
function sendmessage($chat_id, $text, $model){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$text,
'parse_mode'=>$mode]);
}
function sendaction($chat_id, $action){
bot('sendchataction',[
'chat_id'=>$chat_id,
'action'=>$action]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG){
bot('ForwardMessage',[
'chat_id'=>$KojaShe,
'from_chat_id'=>$AzKoja,
'message_id'=>$KodomMSG]);
}
function sendphoto($chat_id, $photo, $action){
bot('sendphoto',[
'chat_id'=>$chat_id,
'photo'=>$photo,
'action'=>$action]);
}
function getChat($idchat){
$json=file_get_contents('https://api.telegram.org/bot'.API_KEY."/getChat?chat_id=".$idchat);
$data=json_decode($json,true);
return $data["result"]["first_name"];
}
function GetChatMember($chatid,$userid){
$truechannel = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=".$chatid."&user_id=".$userid));
$tch = $truechannel->result->status;
return $tch;
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

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
mkdir("data/$from_id");
$message_id = $message->message_id;
$from_id = $message->from->id;
$text = $message->text;
$candotm = file_get_contents("data/$from_id/candotm.txt");
$ADMIN = "466513623"; // شناسه ادمین را جاگذاری کنید
$kanal = "@php_sources";  // آیدی کانالتان را همراه با @ جاگذاری کنید
$to =  file_get_contents("data/$from_id/token.txt");
$url =  file_get_contents("data/$from_id/url.txt");
$tch = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=$kanal&user_id=".$from_id))->result->status;

if($tch != 'member' && $tch != 'creator' && $tch != 'administrator'){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"برای حمایت و استفاده از ربات عضو کانال ما بشید ♦️

🆔 $kanal

حالا روی
/start

کلیک کنید ❗️",
 'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['KeyboardRemove'=>[
],'remove_keyboard'=>true])
]);
}
	
elseif($text == "/start"){
if (!file_exists("data/$from_id/candotm.txt")) {
@mkdir("data/$from_id");
file_put_contents("data/$from_id/candotm.txt","none");
$myfile2 = fopen("Member.txt", "a") or die("Unable to open file!");
fwrite($myfile2, "$from_id\n");
fclose($myfile2);
}
sendAction($chat_id, 'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"سلام من یه ربات کاربردی هستم میتونم کار های زیرو انجام بدم🙃",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"ست وب هوک"],['text'=>"اطلاعات توکن"]],
[['text'=>"دلیت وب هوک"]],
],])
]);
}
elseif($text == "منوی اصلی🔁"){
file_put_contents("data/$from_id/candotm.txt","no");
file_put_contents("data/$from_id/token.txt","no");
file_put_contents("data/$from_id/url.txt","no");
sendAction($chat_id, 'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"به منوی اصلی برگشتید🙃",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"ست وب هوک"],['text'=>"اطلاعات توکن"]],
[['text'=>"دلیت وب هوک"]],
],])
]);
}

elseif($text == "ست وب هوک"){
sendAction($chat_id, 'typing');
file_put_contents("data/$from_id/candotm.txt","to");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"خوب کاربر عزیز ابتدا توکن ربات خودتون را بفرستید",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"منوی اصلی🔁"]],
],])
]);
}
elseif($candotm == "to"){
$token = $text;
$candotm1 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getwebhookinfo"));
$candotm2 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));

$tik2 = objectToArrays($candotm1);
$ur = $tik2["result"]["url"];
$ok2 = $tik2["ok"];
$tik1 = objectToArrays($candotm2);
$un = $tik1["result"]["username"];
$fr = $tik1["result"]["first_name"];
$id = $tik1["result"]["id"];
$ok = $tik1["ok"];
if ($ok != 1) {
//Token Not True
SendMessage($chat_id, "عه توکن را اشتباه وارد کردید😐\n لطفا توکن را بدرستی وارد کنید😉");
} else{
file_put_contents("data/$from_id/candotm.txt","url");
file_put_contents("data/$from_id/token.txt",$text);
SendAction($chat_id,'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"خوب حالا ادرس جای که سورستون قرار داره را بفرستید 
مثلا:

https://yoursite.ir/index.php

حتما ابتدا با https://  شروع شود",]);
}}

elseif($candotm == "url"){
if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$text)){
SendAction($chat_id,'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>" سایتتون اشتباهه"]);
} else {
file_put_contents("data/$from_id/candotm.txt","no");
file_put_contents("data/$from_id/url.txt",$text);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"کمی صبر کنید "]);
sleep(1);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id + 1,
'text'=>"کمی صبر کنید .."]);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id + 1,
'text'=>"ست وب هوک را انجام بدم
توکن ربات شما :
$to
ادرس سورس شما 
$text 
پس دستور زیر را بزن🙃
/setwebhook"]);
}}

elseif($text == "/setwebhook" ){
if($to != "no"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"کمی صبر کنید "]);
sleep(1);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id + 1,
'text'=>"در حال ست کردن وب هوک "]);
file_get_contents("https://api.telegram.org/bot$to/setwebhook?url=$url");
sleep(1);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id + 1,
'text'=>"وب هوک ست شد  موفق  و موید باشید "]);
sleep(1);
file_put_contents("data/$from_id/candotm.txt","no");
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id + 1,
'text'=>"به منوی اصلی برگشتید🙃",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"ست وب هوک"],['text'=>"اطلاعات توکن"]],
[['text'=>"دلیت وب هوک"]],
],])
]);
}}

elseif($text == "اطلاعات توکن" ){
file_put_contents("data/$from_id/candotm.txt","token");
sendaction($chat_id,'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"خوب دوست عزیز توکن خودتون را بفرستید:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>'منوی اصلی🔁']],
],'resize_keyboard'=>true])
]);
}
elseif($candotm == "token"){
$token = $text;
$candotm1 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getwebhookinfo"));
$candotm2 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));

$tik2 = objectToArrays($candotm1);
$ur = $tik2["result"]["url"];
$ok2 = $tik2["ok"];
$tik1 = objectToArrays($candotm2);
$un = $tik1["result"]["username"];
$fr = $tik1["result"]["first_name"];
$id = $tik1["result"]["id"];
$ok = $tik1["ok"];
if ($ok != 1) {
//Token Not True
SendMessage($chat_id, "عه توکن را اشتباه وارد کردید😐\n لطفا توکن را بدرستی وارد کنید😉");
} else {
file_put_contents("data/$from_id/candotm.txt","no");
SendAction($chat_id,'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"کمی صبر کنید "]);
sleep(1);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id + 1,
'text'=>"وضعیت توکن : True
خوب اطلاعات ربات شما😉👇
username: @$un
Id : $id
name : $fr
ادرس ست شده سورس:
$ur
"]);
}}

elseif($text == "دلیت وب هوک" ){
file_put_contents("data/$from_id/candotm.txt","del");
sendaction($chat_id,'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"خوب دوست عزیز توکن خودتون را بفرستید:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>'منوی اصلی🔁']],
],'resize_keyboard'=>true])
]);
}
elseif($candotm == "del"){
$token = $text;
$candotm1 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getwebhookinfo"));
$candotm2 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));

$tik2 = objectToArrays($candotm1);
$ur = $tik2["result"]["url"];
$ok2 = $tik2["ok"];
$tik1 = objectToArrays($candotm2);
$un = $tik1["result"]["username"];
$fr = $tik1["result"]["first_name"];
$id = $tik1["result"]["id"];
$ok = $tik1["ok"];
if ($ok != 1) {
//Token Not True
SendMessage($chat_id, "عه توکن را اشتباه وارد کردید😐\n لطفا توکن را بدرستی وارد کنید😉");
} else {
file_put_contents("data/$from_id/candotm.txt","no");
SendAction($chat_id,'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"کمی صبر کنید "]);
sleep(1);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id + 1,
'text'=>"در حال دلیت وب هوک."]);
}
file_get_contents("https://api.telegram.org/bot$text/deletewebhook");
sleep(1);
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id + 1,
'text'=>"دلیت وب هوک با موفقیت انجام شد."]);
sleep(1);
file_put_contents("data/$from_id/candotm.txt","no");
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id + 1,
'text'=>"به منوی اصلی برگشتید🙃",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"ست وب هوک"],['text'=>"اطلاعات توکن"]],
[['text'=>"دلیت وب هوک"]],
],])
]);
}

elseif($text == "/panel" && $chat_id == $ADMIN){
sendaction($chat_id, typing);
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' =>"ادمین عزیز به پنل مدیریتی ربات خودش امدید",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"آمار"],['text'=>"پیام همگانی"]],
[['text'=>"فروارد همگانی"]],
],'resize_keyboard'=>true])
]);
}

elseif($text == "آمار" && $chat_id == $ADMIN){
sendaction($chat_id,'typing');
$user = file_get_contents("Member.txt");
$member_id = explode("\n",$user);
$member_count = count($member_id) -1;
sendmessage($chat_id , " آمار کاربران : $member_count" , "html");
}

elseif($text == "پیام همگانی" && $chat_id == $ADMIN){
file_put_contents("data/$from_id/candotm.txt","send");
sendaction($chat_id,'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>" پیام مورد نظر رو در قالب متن بفرستید:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>'/panel']],
],'resize_keyboard'=>true])
]);
}
elseif($candotm == "send" && $chat_id == $ADMIN){
file_put_contents("data/$from_id/candotm.txt","no");
SendAction($chat_id,'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>" پیام همگانی فرستاده شد.",]);
$all_member = fopen( "Member.txt", "r");
while( !feof( $all_member)) {
$user = fgets( $all_member);
SendMessage($user,$text,"html");
}}

elseif($text == "فروارد همگانی" && $chat_id == $ADMIN){
file_put_contents("data/$from_id/candotm.txt","fwd");
sendaction($chat_id,'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"پیام خودتون را فروراد کنید:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>'/panel']],
],'resize_keyboard'=>true])
]);
}
elseif($candotm == "fwd" && $chat_id == $ADMIN){
file_put_contents("data/$from_id/candotm.txt","no");
SendAction($chat_id,'typing');
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"درحال فروارد",
]);
$forp = fopen( "Member.txt", 'r'); 
while( !feof( $forp)) { 
$fakar = fgets( $forp); 
Forward($fakar, $chat_id,$message_id); 
} 
bot('sendMessage',[ 
'chat_id'=>$chat_id, 
'text'=>"با موفقیت فروارد شد.", 
]);
}

elseif($text == '/creator'){
SendMessage($chat_id,"Created By: ","html","true");
}

?>