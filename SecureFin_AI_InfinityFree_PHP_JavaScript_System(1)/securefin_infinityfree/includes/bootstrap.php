<?php
declare(strict_types=1);
$configFile=dirname(__DIR__).'/config.php';
if(!is_file($configFile)){http_response_code(503);exit('Copy config.example.php to config.php and enter your hosting details.');}
$config=require $configFile;
header("X-Content-Type-Options: nosniff"); header("X-Frame-Options: DENY"); header("Referrer-Policy: no-referrer");
header("Permissions-Policy: camera=(self)");
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com; style-src 'self'; img-src 'self' data:; form-action 'self'; frame-ancestors 'none'");
session_name('securefin'); session_set_cookie_params(['secure'=>true,'httponly'=>true,'samesite'=>'Strict','path'=>'/']); session_start();
if(isset($_SESSION['last']) && time()-$_SESSION['last']>1800){session_unset();session_destroy();session_start();} $_SESSION['last']=time();
try{$pdo=new PDO("mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4",$config['db_user'],$config['db_pass'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);}catch(Throwable $e){http_response_code(503);exit('Database connection unavailable. Check config.php.');}
require __DIR__.'/functions.php';
