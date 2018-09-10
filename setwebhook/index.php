<?php
include ("handler.php");
//------------------------------------------------------------------------------
	//Add Member
    $user = json_decode(file_get_contents("data/user.json"),true);
    if(!in_array($from_id, $user["userlist"])) {
    @mkdir("data/$from_id");
    $user["userlist"][]="$from_id";
    $user = json_encode($user,true);
    file_put_contents("data/user.json",$user);
	//Config Json
	$users[$from_id]['step'] = "none";
	$users[$from_id]['ban'] = "false";
	$users[$from_id]['url'] = "";
	$users[$from_id]['token'] = "";
	file_put_contents("data/data.json",json_encode($users));
	//Put Text File
	file_put_contents("data/$from_id/text.txt",'');
}
//------------------------------------------------------------------------------
 if($ban == 'true'){return;}
//--------[Start and Back]--------//
if($text == "/start"){
	$users[$from_id]['step'] = "none";
	$users[$from_id]['url'] = "";
	$users[$from_id]['token'] = "";
	file_put_contents("data/data.json",json_encode($users));
	SendMessage($chat_id,"
🖲 ربات عملیات های وبهوک

🎫 به ربات خوش آمدید.
🌐 برای استفاده از ربات از منوی زیر استفاده کنید :
➖➖➖➖➖➖
@$Channel", 'MarkDown',null, $home);
return;
}
//--------[Bot]--------//
if($data == "back"){
	$users[$fromid]['step'] = "none";
	$users[$fromid]['url'] = "";
	$users[$fromid]['token'] = "";
	file_put_contents("data/data.json",json_encode($users));
	EditMsg($chatid, $messageid, "🖲 ربات عملیات های وبهوک
	
🎫 به ربات خوش آمدید.
🌐 برای استفاده از ربات از منوی زیر استفاده کنید :
➖➖➖➖➖➖
@$Channel", $home);
}
if($data == "set"){
    $users[$fromid]['step'] = "token";
	file_put_contents("data/data.json",json_encode($users));
	EditMsg($chatid, $messageid, "🎫 بخش تنظیم وبهوک!
🖲 توکن خود را ارسال کنید :", $back);
}
elseif($step == "token"){
	$token = $text;
    $getme = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));
    $obj = objectToArrays($getme);
    $ok = $obj['ok'];
    if ($ok == 1) {
    $users[$from_id]['step'] = "url";
	$users[$from_id]['token'] = "$token";
	file_put_contents("data/data.json",json_encode($users));
	SendMessage($chat_id, "🌐 لطفا آدرس اینترنتی مورد نظر را با پیشوند `https` ارسال کنید :", 'MarkDown', null, $back);
    }else{
    SendMessage($chat_id, "‼️ توکن صحیح نیست!
🔆 دقت داشته باشید باید عیناَ توکن خالص رو کپی کرده باشید بدون هیچ پیشوند و پسوندی :", null, null);
}
}
elseif($step == "url"){
    $url = $text;
if (!preg_match("/\b(?:(?:https|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$text)){
     SendMessage($chat_id, "‼️ آدرس صحیح نیست!
🔆 دقت داشته باشید باید پسوند `https` باشد.", null, null);
}else{
    $users[$from_id]['url'] = "$url";
	file_put_contents("data/data.json",json_encode($users));
    $url = $users[$from_id]['url'];
    $token = $users[$from_id]['token'];
    SendMessage($chat_id, "🎫 بخش نهایی تنظیم وبهوک!

🌀 توکن ربات شما :
`$token`

🌐 آدرس اینترنتی شما :
$url

✅ درصورت صحیح بودن اطلاعات و تایید تنظیم دکمه زیر را لمس کنید :
❓ در غیر این صورت جهت انصراف بر روی /start بزنید.", 'MarkDown', null, $endset);
}
}
elseif($data == "doneset"){
	$url = $users[$fromid]['url'];
    $token = $users[$fromid]['token'];
if($token != null and $url != null){
	$url = $users[$fromid]['url'];
    $token = $users[$fromid]['token'];
    $get = json_decode(file_get_contents("https://api.telegram.org/bot$token/setwebhook?url=$url")); 
    $ok = $get->ok;
	if($ok == ok){
    EditMsg($chatid, $messageid, "وبهوک با موفقیت تنظیم گردید 😃☄️", $back);
	}else{
	EditMsg($chatid, $messageid, "وبهوک به هر دلیلی تنظیم نشد. 🌚", $back);
	}
    $users[$fromid]['step'] = "none";
	$users[$fromid]['url'] = "";
	$users[$fromid]['token'] = "";
	file_put_contents("data/data.json",json_encode($users));
}
}
if($data == "del"){
	$users[$fromid]['step'] = "del";
	file_put_contents("data/data.json",json_encode($users));
	EditMsg($chatid, $messageid, "🎫 بخش حذف وبهوک!
🖲 توکن خود را ارسال کنید :", $back);
}
elseif($step == "del"){
	$token = $text;
	$getme = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));
    $obj = objectToArrays($getme);
    $ok = $obj['ok'];
    if ($ok == 1) {
	$users[$from_id]['token'] = "$token";
	file_put_contents("data/data.json",json_encode($users));
	SendMessage($chat_id, "🎫 بخش نهایی حذف وبهوک!

🌀 توکن ربات شما :
`$token`

✅ درصورت صحیح بودن اطلاعات و تایید برای حذف دکمه زیر را لمس کنید :
❓ در غیر این صورت جهت انصراف بر روی /start بزنید.", 'MarkDown', null, $enddel);
	}else{
	SendMessage($chat_id, "‼️ توکن صحیح نیست!
🔆 دقت داشته باشید باید عیناَ توکن خالص رو کپی کرده باشید بدون هیچ پیشوند و پسوندی :", null, null);
	}
}
elseif($data == "donedel"){
    $token = $users[$fromid]['token'];
if($token != null){
file_get_contents("https://api.telegram.org/bot$token/deletewebhook");
    EditMsg($chatid, $messageid, "وبهوک با موفقیت حذف گردید 😃🔥", $back);
    $users[$fromid]['step'] = "none";
	$users[$fromid]['token'] = "";
	file_put_contents("data/data.json",json_encode($users));
}
}
if($data == "info"){
	$users[$fromid]['step'] = "info";
	file_put_contents("data/data.json",json_encode($users));
	EditMsg($chatid, $messageid, "🎫 بخش اطلاعات توکن!
🖲 توکن خود را ارسال کنید :", $back);
}
elseif($step == "info"){
	$token = $text;
	
	$inf = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getwebhookinfo"));
	$obj = objectToArrays($inf);
    $url = $obj['result']['url'];
    $ok = $obj['ok'];
	
    $getme = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));
    $obj2 = objectToArrays($getme);
	$un = $obj2['result']['username'];
    $na = $obj2['result']['first_name'];
    $id = $obj2['result']['id'];
	$ok2 = $obj2['ok'];
    if ($ok == 1 and $ok2 == 1) {
	if($url != ''){
	//Url True
	SendMessage($chat_id, "🎫 اطلاعات توکن ارسالی شما!

🌐 آدرس وبهوک :
$url

🤖 ربات : @$un

🎟 نام ربات : $na

📯 آیدی عددی ربات : $id", 'Html', null, $back);
	}else{
	//Url Not True
	SendMessage($chat_id, "🎫 اطلاعات توکن ارسالی شما!

🌐 آدرس وبهوک : تنظیم نشده!

🤖 ربات : @$un

🎟 نام ربات : $na

📯 آیدی عددی ربات : $id", 'Html', null, $back);
	}
	$users[$from_id]['step'] = "none";
	file_put_contents("data/data.json",json_encode($users));
	}else{
	SendMessage($chat_id, "‼️ توکن صحیح نیست!
🔆 دقت داشته باشید باید عیناَ توکن خالص رو کپی کرده باشید بدون هیچ پیشوند و پسوندی :", null, null);
	}
}
//--------[Panel Dev]--------//
if($text == '/panel' or $text == 'بازگشت'){
	if($from_id == $Dev){
	$users[$from_id]['step'] = "none";
	file_put_contents("data/data.json",json_encode($users));
SendMessage($chat_id," به پنل مدیریت خوش آمدید
➖➖➖➖➖➖
🔻 انتخاب کنید 🔻", 'MarkDown' ,$message_id, $panel);
return;
	}
}
elseif($text == 'آمار' and $from_id == $Dev){
	$mmemcount = count($user['userlist'])-1;
SendMessage($chat_id,"■ تعداد کل اعضای ربات : *$mmemcount*", 'MarkDown', $message_id);
}
//------------------------------------------------------------------------------Send and For
elseif($text == 'ارسال همگانی' and $from_id == $Dev){
    $users[$from_id]['step'] = "s2all";
	file_put_contents("data/data.json",json_encode($users));
    SendMessage($chat_id,"■ پیام مورد نظر را ارسال کنید", 'MarkDown', $message_id, $back_panel);
}
elseif($step == "s2all"){
    $users[$from_id]['step'] = "none";
	file_put_contents("data/data.json",json_encode($users));
while($z <= count($All)){  
$z++;
SendMessage($All[$z-1], $text, null, null);
}
SendMessage($chat_id,"■ پیام به تمامی اعضا ارسال شد", 'MarkDown', $message_id, $panel);
}
elseif($text == 'فروارد همگانی' and $from_id == $Dev){
    $users[$from_id]['step'] = "f2all";
	file_put_contents("data/data.json",json_encode($users));
	SendMessage($chat_id,"■ پیام مورد نظر را فروارد کنید", 'MarkDown', $message_id, $back_panel);
}
elseif($step == "f2all"){
    $users[$from_id]['step'] = "none";
	file_put_contents("data/data.json",json_encode($users));
while($z <= count($All)){  
$z++;
Forward($All[$z-1],$chat_id,$message_id);
}
SendMessage($chat_id,"■ پیام به تمامی اعضا فروارد شد", 'MarkDown', $message_id, $panel);
}
//------------------------------------------------------------------------------Ban and UnBan
elseif($text == 'مسدود کاربر' and $from_id == $Dev){
    $users[$from_id]['step'] = "ban";
	file_put_contents("data/data.json",json_encode($users));
SendMessage($chat_id,"■ آیدی کاربر جهت محروم شدن از ربات را ارسال کنید", 'MarkDown', $message_id, $back_panel);
}
elseif($step == "ban"){
    $users[$from_id]['step'] = "none";
    $users[$text]['ban'] = "true";
	file_put_contents("data/data.json",json_encode($users));
SendMessage($chat_id,"■ کاربر `$text` از ربات مسدود شد!", 'MarkDown', $message_id, $panel);
}
elseif($text == 'حذف مسدود کاربر' and $from_id == $Dev){
    $users[$from_id]['step'] = "unban";
	file_put_contents("data/data.json",json_encode($users));
SendMessage($chat_id,"■ آیدی کاربر جهت خارج کردن از محرومیت ربات را ارسال کنید", 'MarkDown', $message_id, $back_panel);
}
elseif($step == "unban"){
    $users[$from_id]['step'] = "none";
    $users[$text]['ban'] = "false";
	file_put_contents("data/data.json",json_encode($users));
SendMessage($chat_id,"■ کاربر `$text` از مسدودیت خارج گردید", 'MarkDown', $message_id, $panel);
}
//------------------------------------------------------------------------------
unlink('error_log');
?>