<?php
if(session_status()===PHP_SESSION_NONE){session_set_cookie_params(['httponly'=>true,'secure'=>isset($_SERVER['HTTPS']),'samesite'=>'Lax']);session_start();}
function esc($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function csrf(){if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function verify_csrf(){if($_SERVER['REQUEST_METHOD']==='POST'&&!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'')){http_response_code(419);exit('CSRF invalid');}}
function upimg($f,$dir){if(empty($_FILES[$f]['name'])||$_FILES[$f]['error']!==UPLOAD_ERR_OK)return null;$ext=strtolower(pathinfo($_FILES[$f]['name'],PATHINFO_EXTENSION));if(!in_array($ext,ALLOW_EXT,true)||$_FILES[$f]['size']>MAX_UPLOAD)return null;$raw=file_get_contents($_FILES[$f]['tmp_name']);$img=@imagecreatefromstring($raw);if(!$img)return null;$name=bin2hex(random_bytes(8)).'.webp';$dest=__DIR__.'/../../public/uploads/'.$dir.'/'.$name;imagewebp($img,$dest,76);imagedestroy($img);return 'uploads/'.$dir.'/'.$name;}
