<?php
declare(strict_types=1);
session_start();
const DB_HOST='localhost'; const DB_NAME='smartmart'; const DB_USER='root'; const DB_PASS='';
const DEMO_VERIFICATION=true;
try { $pdo=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
catch(Throwable $e){ http_response_code(500); exit('Database unavailable. Import install.sql and check config.php.'); }
function json_out(array $v,int $s=200):never{http_response_code($s);header('Content-Type: application/json');echo json_encode($v);exit;}
function body():array{return json_decode(file_get_contents('php://input'),true)??$_POST;}
function user():?array{return $_SESSION['user']??null;}
function need_login():array{$u=user();if(!$u)json_out(['ok'=>false,'message'=>'Please sign in.'],401);return $u;}
function csrf():string{if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(24));return $_SESSION['csrf'];}
function verify_csrf(array $d):void{if(!hash_equals($_SESSION['csrf']??'',(string)($d['csrf']??'')))json_out(['ok'=>false,'message'=>'Security token expired. Refresh the page.'],419);}
function clean_phone(string $p):string{return preg_replace('/[^0-9+]/','',$p);}
function save_photo(string $data):string{if(!preg_match('#^data:image/(jpeg|png);base64,#',$data,$m))throw new RuntimeException('Capture a valid live picture.');$raw=base64_decode(substr($data,strpos($data,',')+1),true);if($raw===false||strlen($raw)>2500000)throw new RuntimeException('Picture is invalid or too large.');$name='uploads/'.bin2hex(random_bytes(16)).'.'.$m[1];file_put_contents(__DIR__.'/'.$name,$raw,LOCK_EX);return $name;}
