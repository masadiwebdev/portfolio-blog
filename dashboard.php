<?php
session_start();
require 'conf.php';
if(!isset($_SESSION['akses'])){
header("Location: ".$base_url."akses/masuk/".trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'='));
exit;
}
$selweb = mysqli_query($con,"SELECT * FROM tb_web_bas");
if(mysqli_num_rows($selweb) == 1){
$sw = mysqli_fetch_assoc($selweb);
$title = $sw['nama_web']." - Dashboard";
$deskripsi = "Halaman dashboard ".$sw['nama_web'];
$nama_web = $title;
$deskripsi_web = $sw['deskripsi_web'];
$value_nama = $sw['nama_web'];
$value_deskripsi = $sw['deskripsi_web'];
}else{
$title = "Dashboard";
$deskripsi = "Halaman dashboard";
$nama_web = "";
$deskripsi_web = "";
$value_nama = "";
$value_deskripsi = "";
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$title;?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=none"/>
<meta name="robots" content="noindex"/>
<style>
* {
box-sizing: border-box;
margin: 0;
}
body {
color: #555;
font-family: sans-serif;
font-size: 14px;
min-height: 100%;
height: 100vh;
text-size-adjust: none;
user-select: none;
-webkit-text-size-adjust: none;
-webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
width: 100%;
}
body.actldr{
overflow: hidden;
}
body.actldr .wrapper {
filter: blur(1px);
}
.wrapper {
min-height: 100%;
margin: 0 auto;
max-width: 1024px;
overflow: hidden;
position: relative;
width: 100%;
z-index: 1;
}
.header {
background-color: #f1f1f1;
box-shadow: 0 1px 2px #aaa;
height: 50px;
line-height: 50px;
padding: 0 10px;
position: relative;
width: 100%;
z-index: 98;
}
.header h1 {
color: #555;
font-size: 130%;
letter-spacing: .035em;
margin: 0;
}
.header .menu {
background-color: rgba(0,0,0,.5);
border-radius: 2px;
color: white;
font-size: 200%;
height: 36px;
line-height: 36px;
position: absolute;
right: 8px;
text-align: center;
top: 8px;
transition: all .15s ease-in-out;
width: 36px;
z-index: 100;
}
.header .menu.hvr {
background-color: maroon;
}
.menu-box {
background-color: rgba(0,0,0,.15);
height: 100%;
max-width: 100%;
position: absolute;
right: -100%;
top: 50px;
transition: all .5s ease-in-out;
width: 100%;
z-index: 90;
}
.menu-box.open {
right: 0;
}
.list-box {
background-color: #f1f1f1;
box-shadow: -1px 1px 2px #aaa;
height: 100%;
max-width: 180px;
position: absolute;
right: 0;
width: 100%;
}
.list-box ul {
list-style: none;
padding: 0;
}
.list-box ul li {
background-color: #;
border-bottom: 1px solid white;
color: #555;
height: 40px;
line-height: 40px;
padding: 0 15px;
transition: all .15s ease-in-out;
}
.list-box ul li:hover {
background-color: gray;
color: white;
}
.das {
margin: 20px auto;
max-width: 728px;
padding: 20px 10px;
position: relative;
width: 100%;
}
.das h1, .das h2, .das h3, .das h4, .das h5, .das h6, .das p {
margin-bottom: 15px;
}
.das .btn {
background-color: #eee;
border-radius: 3px;
margin: 10px 5px;
padding: 5px 10px;
}
.das .btn.btn-hps{
background-color: brown;
color: #eee;
}
.das .btn.btn-edit{
background-color: darkorange;
}
.das .btn-ganti {
background-color: green;
border-radius: 3px;
color: white;
display: inline-block;
font-size: 75%;
height: 15px;
line-height: 15px;
margin-left: 5px;
padding: 0 5px;
}
.das .btn-ganti:hover {
background-color: maroon;
}
.das .table {
overflow-x: scroll;
position: relative;
width: 100%;
}
.das .table table {
width: 708px;
}
.das table {
width: 100%;
}
.das table tr th {
text-align: left;
}
.das table tr.trAcc th {
padding: 7px;
}
.das table tr td {
padding: 5px;
}
.das h2 {
border-bottom: 1px solid #ddd;
font-size: 100%;
margin-bottom: 15px;
padding-bottom: 10px;
text-align: center;
}
.das form {
background-color: white;
margin: 20px auto;
max-width: 728px;
padding: 5px;
width: 100%;
}
.das form .hpdr {
background-color: maroon;
border-radius: 3px 3px 0 0;
color: #eee;
cursor: pointer;
display: inline-block;
font-size: .85em;
padding: 2px 5px;
position: absolute;
right: 10px;
top: 29px;
}
.das form .hpdr:hover {
background-color: red;
}
.das form .row {
margin-bottom: 15px;
position: relative;
}
.das form label {
color: #222;
display: inline-block;
font-size: 95%;
position: relative;
width: 50%;
}
.das form .upImgArt {
background-color: #ccc;
border-radius: 0 0 3px 3px;
color: #666;
cursor: pointer;
font-size: .8em;
height: 15px;
line-height: 15px;
padding: 0 5px;
position: absolute;
right: 41px;
top: 20px;
}
.das form .upImgArt:hover {
background-color: rgba(0,0,0,.5);
color: white;
}
.das form .parcod {
background-color: #ccc;
border-radius: 0 3px 0 3px;
cursor: pointer;
font-size: .8em;
height: 15px;
line-height: 15px;
padding: 0 5px;
position: absolute;
right: 0;
top: 20px;
}
.das form .parcod:hover {
background-color: rgba(0,0,0,.5);
color: white;
}
.das form .parse {
background-color: #333;
caret-color: red;
color: lightyellow;
padding: 15px 10px;
position: absolute;
transform: scale(0);
transition: all .5s ease-in-out;
z-index: -1;
}
.das form .parse.show {
transform: scale(1);
z-index: 100;
}
.das form .cls {
background-color: transparent;
border-radius: 0 2px 0 50%;
color: maroon;
height: 15px;
line-height: 15px;
opacity: 0;
position: absolute;
right: 50.5%;
text-align: center;
transform: scale(0);
transition: all .5s ease-in-out;
top: 50%;
width: 15px;
z-index: -1;
}
.das form .cls.show {
background-color: white;
opacity: 1;
right: 2px;
top: 22px;
transform: scale(1);
z-index: 100;
}
.das form .buttons {
background-color: transparent;
bottom: 50%;
height: 25px;
line-height: 25px;
opacity: 0;
position: absolute;
right: 50.5%;
transform: scale(0);
transition: all .5s ease-in-out;
text-align: center;
z-index: -1;
}
.das form .buttons.show {
bottom: 20px;
opacity: 1;
right: 3px;
transform: scale(1);
z-index: 100;
}
.das form .buttons .copy, .das form .buttons .reset, .das form .buttons .procod {
background-color: white;
border-radius: 3px 0 3px 0;
cursor: pointer;
display: inline-block;
font-size: .8em;
height: 20px;
line-height: 20px;
padding: 0 8px;
}
.das form .cls:hover, .das form .copy:hover, .das form .reset:hover, .das form .procod:hover {
opacity: .5;
}
.das form input.uerel {
box-shadow: none;
color: #888;
margin: 0 0 3px;
padding: 0;
}
.das form input.uerel:focus {
box-shadow: none;
}
.das form .hiruf {
background-color: rgba(0,0,0,.05);
border-radius: 2px;
color: maroon;
font-size: 80%;
padding: 1px 5px;
position: absolute;
right: 0;
top: 0;
}
.das form select.pilkat {
background-color: white;
box-shadow: none;
font-size: 90%;
left: 59px;
margin: 0;
padding: 0;
position: absolute;
width: auto;
z-index: 1;
}
.das form select:focus.pilkat {
box-shadow: none;
}
.das form input, .das form select, .das form textarea {
background-color: white;
border: 0;
border-radius: 2px;
box-shadow: 0 0 1px 1px #ccc;
font-family: sans-serif;
margin: 4px 0 2px;
padding: 10px;
transition: all .15s ease-in-out;
width: 100%;
}
.das form textarea {
display: block;
padding: 10px;
}
.das form textarea.isa {
padding-top: 20px;
}
.das form input:focus, .das form select:focus, .das form textarea:focus {
box-shadow: 0 0 1px 1px #888;
outline-style: none;
}
.das form .view {
background-color: white;
border-left: 1px solid #ccc;
border-radius: 0 3px 3px 0;
color: black;
font-size: 85%;
height: 35.5px;
line-height: 35.5px;
position: absolute;
right: 0;
text-align: center;
top: 20.5px;
width: 45px;
}
.das form .view.clicked {
color: red;
}
.das form .error {
color: brown;
font-size: 85%;
height: 16px;
line-height: 16px;
}
.das form button {
background-color: #555;
border: 0;
border-radius: 2px;
box-shadow: 0 0 0 1px gray, 1px 1px 2px 0 gray;
color: white;
display: inline-block;
font-size: .9em;
margin: 0 10px;
padding: 10px 15px;
transition: all .15s ease-in-out;
}
.das form button.btn-green {
background-color: green;
}
.das form button.btn-blue {
background-color: #3b5998;
}
.das form button.btn-orange {
background-color: darkorange;
}
.das form button:focus {
background-color: #222;
box-shadow: none;
color: #ccc;
}
.das .notf {
height: 200px;
left: 50%;
position: absolute;
text-align: center;
top: 50%;
transform: translate(-50%, 50%);
width: 200px;
}
.das .notf h3 {
color: brown;
margin-bottom: 20px;
}
.das .notf p {
line-height: 1.35em;
margin-bottom: 15px;
}
.das .left {
text-align: left;
}
.das .center {
text-align: center;
}
.das .right {
text-align: right;
}
.loadani
	{
	background-color: transparent;
	bottom: 0;
	left: 0;
	opacity: 0;
	position: fixed;
	right: 0;
	top: 0;
	transition: all .5s ease-in-out;
	z-index: -1;
	}
.loadani.show
	{
	opacity: 1;
	z-index: 998;
	}
.loadani .loader
	{
	animation: spin 1s linear infinite;
	background-color: rgba(0,0,0,.25);
	border-radius: 50%;
	height: 70px;
	margin: auto;
	position: relative;
	top: 200px;
	width: 70px;
	z-index: 999;
	}
.loadani .loader:before
	{
	animation: spin 5s ease-in-out infinite;
	border: 5px solid transparent;
	border-right-color: #f1f1f1;
	border-radius: 50%;
	bottom: 3px;
	content: "";
	left: 3px;
	position: absolute;
	right: 3px;
	top: 3px;
	zindex: 1000;
	}
@keyframes spin
	{
	0%
		{
		transform: rotate(0deg);
		}
	100%
		{
		transform: rotate(360deg);
		}
	}
</style>
</head>
<body>
<div class="loadani"><div class="loader"></div></div>
<div class="wrapper">
<div class="header">
<h1>Dashboard</h1>
<!--<p>Halaman dashboard pengguna</p>-->
<div class="menu">=</div>
</div>
<div class="menu-box">
<div class="list-box">
<ul>
<?php
if($_SESSION['levad'] != "penulis"){
?>
<li ref="<?=$base_url;?>">Beranda</li>
<?php
}
?>
<li ref="<?=$base_url.'artikel/beranda';?>"><?php if($_SESSION['levad'] == "penulis"){?>Beranda<?php }else{?>Artikel<?php }?></li>
<?php
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<li ref="<?=$base_url.'kelola/'.trim(base64_encode('data-akun'),'=');?>" class="akn">Akun Pengguna</li>
<li ref="<?=$base_url.'kelola/'.trim(base64_encode('nama-deskripsi'),'=');?>" class="nad">Nama Website</li>
<?php
}else{
?>
<li ref="<?=$base_url.'kelola/'.trim(base64_encode('detail-akun'),'=').'/'.trim(base64_encode($_SESSION['email']),'=');?>" class="akn">Akun Anda</li>
<?php
}
}
?>
<?php
if($_GET['set'] != trim(base64_encode("tambah-artikel-baru"),'=')){
?>
<li ref="<?=$base_url.'kelola/'.trim(base64_encode('tambah-artikel-baru'),'=');?>" class="tah">Artikel Baru</li>
<?php
}
?>
<li ref="<?=$base_url.'kelola/'.trim(base64_encode('data-draft'),'=');?>">Buka Draft</li>
<?php
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<li ref="<?=$base_url.'kelola/'.trim(base64_encode('pasang-iklan'),'=');?>">Pasang Iklan</li>
<?php
}
}
?>
<li ref="<?=$base_url.'tutup/akses/'.trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=');?>" class="klr">Logout</li>
</ul>
</div>
</div>

<div class="das">

<?php
if(isset($_GET['set'])){
if($_GET['set'] == trim(base64_encode("nama-deskripsi"),'=')){
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<h2><?=ucwords(str_replace('-',' & ',base64_decode($_GET['set'])));?></h2>
<form autocomplete="off" class="nades">
<div class="row">
<label for="nama">Nama Website</label>
<input type="text" id="nama" name="nama" value="<?=$value_nama;?>" placeholder="Nama website" class="nama"/>
<div class="error"></div>
</div>
<div class="row">
<label for="deskripsi">Deskripsi Website</label>
<input type="text" id="deskripsi" name="deskripsi" value="<?=$value_deskripsi;?>" placeholder="Deskripsi website" class="deskripsi"/>
<div class="error"></div>
</div>
<div class="row center" style="margin:20px 0">
<button type="submit" name="simpan_pembaruan_web" class="simpan">Simpan</button>
</div>
</form>
<script>
const
loader = document.querySelector(".loadani"),
form = document.querySelector(".nades");
form.addEventListener("submit",function(e){
e.preventDefault();
const nama = document.querySelector(".nama");
const deskripsi = document.querySelector(".deskripsi");
const error = document.querySelectorAll(".error");
const simpan = document.querySelector(".simpan");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(nama.value == ""){
nama.focus();
error[0].innerText = "Masukkan nama website!";
return false;
}else if(deskripsi.value == ""){
deskripsi.focus();
error[1].innerText = "Masukkan deskripsi website!";
return false;
}else{
const data = new FormData();
data.append("nama", nama.value);
data.append("deskripsi", deskripsi.value);
data.append("simpan_pembaruan_web", simpan.value);
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
alert(rsp.msg);
window.location.reload();
},500);
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
}
});
</script>
<?php
}
}
}else if($_GET['set'] == trim(base64_encode("data-akun"),'=')){
?>
<h2><?=ucwords(str_replace('-',' ',base64_decode($_GET['set'])));?></h2>

<?php
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<div class="table">
<table>
<thead>
<tr>
<th>#</th>
<th>Nama</th>
<th>Email</th>
<th>Akses</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
<?php
$selAkun= mysqli_query($con,"SELECT * FROM tb_akun_bas ORDER BY id_akun DESC");
if(mysqli_num_rows($selAkun)){
$no = 1;
while($sa = mysqli_fetch_assoc($selAkun)){
?>
<tr>
<td><?=$no;?></td>
<td><?=$sa['nama'];?></td>
<td><?=$sa['email'];?></td>
<td><?=$sa['levad'];?></td>
<td data-target="<?=trim(base64_encode('detail-akun'),'=').'/'.trim(base64_encode($sa['email']),'=');?>" class="target">Detail</td>
</tr>
<?php
$no++;
}
}
?>
</tbody>
</table>
</div>
<?php
}else{
?>
<script>
window.location.href = "<?=$base_url.'kelola/'.trim(base64_encode('detail-akun'),'=').'/'.trim(base64_encode($_SESSION['email']),'=');?>";
</script>
<?php
}
}
?>
<script>
const tdTarget = document.querySelectorAll(".target");
for(let i = 0; i < tdTarget.length; i++){
tdTarget[i].addEventListener("click",function(){
const target = tdTarget[i].getAttribute("data-target");
window.location.href = target;
});
}
</script>
<?php
}else if($_GET['set'] == trim(base64_encode("detail-akun"),'=')){
$getEmail = base64_decode($_GET['slug']);
$dataAkun = mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE email='$getEmail' ");
if(mysqli_num_rows($dataAkun) == 1){
$dt = mysqli_fetch_assoc($dataAkun);
?>
<h4>Detai akun</h4>
<p>Nama : <?=$dt['nama'];?></p>
<p>Email : <?=$dt['email'];?></p>
<p>Sandi : (tidak ditampilkan)</p>
<?php
if(isset($_SESSION['levad'])){
?>
<p>Akses : <?=ucwords($dt['levad']);?> <?php if($_SESSION['levad'] == "master admin"){?><select name="level" data-level="<?=trim(base64_encode($dt['email']),'=');?>" class="btn-ganti ganti-level">
<option disabled selected value="">Ubah</option>
<option value="<?=trim(base64_encode('admin'),'=');?>">Admin</option>
<option value="<?=trim(base64_encode('user'),'=');?>">User</option>
<option value="<?=trim(base64_encode('penulis'),'=');?>">Penulis</option></select><?php } ?></p>
<p>Akun : <?=ucwords($dt['aktif']);?> <?php if($_SESSION['levad'] == "master admin"){?><span data-status="<?=trim(base64_encode($dt['email']),'=');?>" target-status="<?=trim(base64_encode($dt['aktif']),'=');?>" class="btn-ganti ganti-status">Ubah</span><?php } ?></p>
<?php
}
?>
<p>Terdaftar : <?=str_replace('-','/',str_replace(' ',' | ',$dt['registrasi']));?></p>
<button type="button" data-back="<?=trim(base64_encode('data-akun'),'=');?>" class="btn btn-back">Kembali</button>
<button type="button" data-hps="<?=trim(base64_encode($dt['email']),'=');?>" class="btn btn-hps">Hapus Akun</button>
<?php
if($_SESSION['levad'] == $dt['levad']){
?>
<button type="button" data-edit="<?=trim(base64_encode('edit-akun'),'=').'/'.trim(base64_encode($dt['email']),'=');?>" class="btn btn-edit">Edit Akun</button>
<?php
}
?>
<script>
const loader = document.querySelector(".loadani");
<?php
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
const edLe = document.querySelector(".btn-ganti.ganti-level");
edLe.addEventListener("change",function(){
const
lvl = edLe.getAttribute("data-level"),
tgt = edLe.value;
const data = new FormData();
data.append("data_level", lvl);
data.append("data_target", tgt);
data.append("set_level_admin","");
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
alert(rsp.msg);
window.location.reload();
},500);
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
});
const edSta = document.querySelector(".btn-ganti.ganti-status");
edSta.addEventListener("click",function(){
const
sts = edSta.getAttribute("data-status"),
tgt = edSta.getAttribute("target-status");
const data = new FormData();
data.append("data_status", sts);
data.append("data_target", tgt);
data.append("set_status_admin","");
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
alert(rsp.msg);
window.location.reload();
},500);
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
});
<?php
}
}
?>
const btnBack = document.querySelector(".btn.btn-back");
btnBack.addEventListener("click",function(){
const back = btnBack.getAttribute("data-back");
window.location.href = '../'+back;
});
const btnHps = document.querySelector(".btn.btn-hps");
btnHps.addEventListener("click",function(){
const target = btnHps.getAttribute("data-hps");
if(confirm("Hapus akun?") == true){
const data = new FormData();
data.append("target", atob(target));
data.append("hapus_akun", "");
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
alert(rsp.msg);
window.location.href = rsp.drc;
},500);
}else{
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
}
});
const btnEdit = document.querySelector(".btn.btn-edit");
btnEdit.addEventListener("click",function(){
document.body.classList.add("actldr");
loader.classList.add("show");
const edit = btnEdit.getAttribute("data-edit");
window.location.href = '../'+edit;
});
</script>
<?php
}else{
?>
<p style="text-align:center">Maaf data tidak ditemukan!</p>
<?php
}
?>
<?php
}else if($_GET['set'] == trim(base64_encode("edit-akun"),'=')){
$getEmail = base64_decode($_GET['slug']);
$dataAkun = mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE email='$getEmail' ");
if(mysqli_num_rows($dataAkun) == 1){
$dt = mysqli_fetch_assoc($dataAkun);
?>
<form autocomplete="off" enctype="multipart/form-data" class="edit-akun">
<h3>Form Edit Akun</h3>
<div class="row">
<label for="nama">Nama</label>
<input type="text" name="nama" id="nama" value="<?=$dt['nama'];?>" placeholder="Masukkan nama Anda" class="nama"/>
<div class="error"></div>
</div>
<div class="row">
<label for="email">Email</label>
<input type="email" name="email" id="email" value="<?=$dt['email'];?>" placeholder="Masukkan email Anda" class="email"/>
<div class="error"></div>
</div>
<div class="row">
<label for="sandi">Sandi</label>
<input type="password" name="sandi" id="sandi" placeholder="Masukkan sandi Anda" class="sandi"/>
<div class="view">√</div>
<div class="error"></div>
</div>
<div class="row">
<label for="konfir">Konfirmasi</label>
<input type="password" name="konfir" id="konfir" placeholder="Masukkan konfirmasi sandi" class="konfir"/>
<div class="view">√</div>
<div class="error"></div>
</div>
<div class="row">
<label for="profil">Profil</label>
<input type="file" name="profil" id="profil" class="profil"/>
<div class="error"></div>
</div>
<div class="row center" style="margin-top:20px">
<button type="button" data-back="<?=trim(base64_encode('detail-akun'),'=').'/'.trim(base64_encode($dt['email']),'=');?>" class="btn-cancel" style="margin-right:20px;width: 100px">Batal</button>
<button type="submit" name="simpan_perubahan_akun" class="simpan" style="width:100px">Simpan</button>
</div>
</form>
<script>
const btnCan = document.querySelector(".btn-cancel");
btnCan.addEventListener("click",function(){
const back = btnCan.getAttribute("data-back");
window.location.href = '../'+back;
});
const
form = document.querySelector("form.edit-akun"),
visan = document.querySelectorAll("form.edit-akun .view"),
profil = document.querySelector(".profil");
visan[0].addEventListener("click",function(){
const kon = document.querySelector(".sandi");
if(kon.getAttribute("type") == "password"){
kon.setAttribute("type","text");
visan[0].classList.add("clicked");
visan[0].innerText = "×";
}else if(kon.getAttribute("type") == "text"){
kon.setAttribute("type","password");
visan[0].classList.remove("clicked");
visan[0].innerText = "√";
}
});
visan[1].addEventListener("click",function(){
const kon = document.querySelector(".konfir");
if(kon.getAttribute("type") == "password"){
kon.setAttribute("type","text");
visan[1].classList.add("clicked");
visan[1].innerText = "×";
}else if(kon.getAttribute("type") == "text"){
kon.setAttribute("type","password");
visan[1].classList.remove("clicked");
visan[1].innerText = "√";
}
});
profil.onchange = function(){
const
err = document.querySelectorAll(".error"),
mt = /image\/jpg|image\/jpeg|image\/png/,
fl = profil.files[0];
err[4].innerText = "";
if(!fl.type.match(mt)){
profil.focus();
err[4].innerText = "Format yang didukung .jpg, .jpeg dan .png!";
return false;
}else if(fl.size > 500000){
profil.focus();
err[4].innerText = "Ukuran gambar terlalu besar, maks 500Kb!";
return false;
}
}
form.addEventListener("submit",function(e){
e.preventDefault();
const
loader = document.querySelector(".loadani"),
nama = document.querySelector(".nama"),
email = document.querySelector(".email"),
sandi = document.querySelector(".sandi"),
konfir = document.querySelector(".konfir"),
error = document.querySelectorAll(".error"),
simpan = document.querySelector(".simpan");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(nama.value == ""){
nama.focus();
error[0].innerText = "Masukkan nama Anda!";
return false;
}else if(email.value == ""){
email.focus();
error[1].innerText = "Masukkan email Anda!";
return false;
}else if(sandi.value != "" && sandi.value.length < 6){
sandi.focus();
error[2].innerText = "Minimal 6 karakter!";
return false;
}else if(sandi.value != "" && !sandi.value.match("[A-Z]")){
sandi.focus();
error[2].innerText = "Minimal terdapat 1 huruf besar!";
return false;
}else if(sandi.value != "" && !sandi.value.match("[0-9]")){
sandi.focus();
error[2].innerText = "Minimal terdapat 1 angka!";
return false;
}else if(sandi.value != "" && konfir.value == ""){
konfir.focus();
error[3].innerText = "Masukkan konfirmasi sandi!";
return false;
}else if(sandi.value != konfir.value){
konfir.focus();
error[3].innerText = "Konfirmasi sandi tidak cocok!";
return false;
}else{
const data = new FormData();
data.append("nama", nama.value);
data.append("email", email.value);
data.append("sandi", sandi.value);
data.append("profil", profil.files[0]);
data.append("simpan_perubahan_akun", simpan.value);
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
alert(rsp.msg);
window.location.href = rsp.drc;
},500);
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
}
});
</script>
<?php
}else{
?>
<p style="text-align:center">Maaf data tidak ditemukan!</p>
<?php
}
?>
<?php
}else if($_GET['set'] == trim(base64_encode("tambah-artikel-baru"),'=')){
if(isset($_SESSION['id'])){
$id = $_SESSION['id'];
}else{
$id = "";
}
$selDataArtDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE id_art='$id' ");
if(mysqli_num_rows($selDataArtDraft) == 1){
$sdad = mysqli_fetch_assoc($selDataArtDraft);
$slug = $sdad['slug_art'];
$judul = $sdad['judul_art'];
$isi = htmlentities($sdad['isi_art']);
$deskripsi = $sdad['deskripsi_art'];
$kategori = $sdad['kategori_art'];
}else{
$slug = "";
$judul = "";
$isi = "";
$deskripsi = "";
$kategori = "";
}
?>
<h2>Tulis Posting Baru</h2>
<form autocomplete="off" ecntype="multipart/form-data" class="arba">
<div class="row" style="margin:0">
<input type="text" name="uerel" value="<?=$slug;?>" readonly class="uerel"/>
</div>
<div class="row">
<label for="judul">Judul</label>
<span class="hiruf">Maksimal 70 karakter</span>
<input type="text" name="judul" id="judul" value="<?=$judul;?>" placeholder="Masukkan judul" class="judul"/>
<div class="error"></div>
</div>
<div class="row">
<label for="sampul">Sampul</label>
<input type="file" name="sampul" id="sampul" class="sampul"/>
<div class="error"></div>
</div>
<div class="row">
<label for="isi">Posting</label>
<span class="hiruf">Minimal 1000 karakter</span>
<span target-uri="<?=$base_url.'files/'.strtolower(trim(base64_encode('upload_gambar_artikel'),'='));?>" class="upImgArt">Upload Gambar</span>
<span class="parcod">Parse</span>
<textarea name="#" rows="15" placeholder="Ketik atau tempel kode disini..." class="parse"></textarea>
<span class="cls">&times;</span>
<div class="buttons">
<span onclick="copyCode()" class="copy">Copy</span>
<span class="reset">Clear</span>
<span class="procod">Parse</span>
</div>
<textarea rows="15" name="isi" id="isi" placeholder="Masukkan posting" class="isi isa"><?=$isi;?></textarea>
<div class="error"></div>
</div>
<div class="row">
<label for="deskripsi">Deskripsi</label>
<span class="hiruf">Maksimal 150 karakter</span>
<textarea rows="3" name="deskripsi" id="deskripsi" placeholder="Masukkan deskripsi" class="deskripsi"><?=$deskripsi;?></textarea>
<div class="error"></div>
</div>
<div class="row">
<label for="kategori">Kategori /</label>
<select name="pilkat[]" multiple="multiple" class="pilkat">
<option disabled value="">Umum</option>
<option value="Berita">Berita</option>
<option value="Budaya">Budaya</option>
<option value="Kuliner">Kuliner</option>
<option value="Sosial">Sosial</option>
<option value="Teknologi">Teknologi</option>
<option value="Travel">Travel</option>
<option value="Unik">Unik</option>
<option disabled value="">Review</option>
<option value="Smartphone">Smartphone</option>
<option value="Tablet">Tablet</option>
<option value="Desktop">Desktop</option>
<option value="Permainan">Permainan</option>
<option disabled value="">Tutorial</option>
<option value="Website">Website</option>
<option value="Html">Html</option>
<option value="Css">Css</option>
<option value="Javascript">Javascript</option>
<option value="Php">Php</option>
</select>
<input type="text" name="kategori" id="kategori" value="<?=$kategori;?>" placeholder="Pilih kategori" readonly class="kategori"/>
<div class="error"></div>
</div>
<div class="row center" style="margin:20px 0">
<button type="submit" name="terbitkan_artikel_baru" class="btn-blue terbitkan-artikel-baru">Terbitkan</button>
<button type="button" name="simpan_ke_draft" class="btn-green simpan-ke-draft">Simpan</button>
<button type="button" class="btn-orange preview-post">Preview</button>
</div>
</form>
<script>
const parcod = document.querySelector(".parcod"),
pars = document.querySelector(".parse"),
cls = document.querySelector(".cls"),
buts = document.querySelector(".buttons"),
cpy = document.querySelector(".copy"),
rest = document.querySelector(".reset"),
proc = document.querySelector(".procod");
parcod.addEventListener("click",function(){
pars.classList.add("show");
cls.classList.add("show");
buts.classList.add("show");
cls.addEventListener("click",function(){
pars.classList.remove("show");
cls.classList.remove("show");
buts.classList.remove("show");
});
cpy.addEventListener("click",function(){
pars.classList.remove("show");
cls.classList.remove("show");
buts.classList.remove("show");
pars.blur();
});
rest.addEventListener("click",function(){
pars.value = "";
pars.focus();
});
proc.addEventListener("click",function(){
if(pars.value == ""){
pars.setAttribute("placeholder","Harap masukkan kode!");
pars.focus();
}else{
let cd = pars.value;
cd = cd.replace(/</g, '&lt;');
cd = cd.replace(/>/g, '&gt;');
cd = cd.replace(/"/g, '&quot;');/*"*/
cd = cd.replace(/'/g, '&apos;');
pars.value = cd;
}
});
});
function copyCode(){
pars.select();
document.execCommand("copy");
alert("Berhasil disalin ke papan klip");
pars.selection.empty();
}
const
loader = document.querySelector(".loadani"),
upImgArt = document.querySelector(".upImgArt");
upImgArt.addEventListener("click",function(){
window.open(upImgArt.getAttribute("target-uri"));
});
const form = document.querySelector(".arba");
const jdl = document.querySelector(".judul");
jdl.addEventListener("keyup",function(){
const
hiruf = document.querySelectorAll(".hiruf"),
uerel = document.querySelector(".uerel");
if(jdl.value == ""){
hiruf[0].innerText = "Maksimal 70 karakter";
}else if(jdl.value.length > 70){
jdl.value = jdl.value.substr(0,jdl.value.length-1);
hiruf[0].innerText = '70/70';
jdl.blur();
}else{
hiruf[0].innerText = jdl.value.length+'/70';
}
uerel.value = jdl.value.toLowerCase().replace(/\ /g,'-').replace(/([^a-z0-9-])+/g,'').replace(/--/g,'');
});
const isat = document.querySelector(".isi");
isat.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(isat.value == ""){
hiruf[1].innerText = "Minimal 1000 karakter";
}else if(isat.value.length < 1000){
hiruf[1].innerText = isat.value.length+'/1000';
}else{
hiruf[1].innerText = '('+isat.value.length+')';
}
});
const dsc = document.querySelector(".deskripsi");
dsc.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(dsc.value == ""){
hiruf[2].innerText = "Maksimal 150 karakter";
}else if(dsc.value.length > 150){
dsc.value = dsc.value.substr(0,dsc.value.length-1);
hiruf[2].innerText = '150/150';
dsc.blur();
}else{
hiruf[2].innerText = dsc.value.length+'/150';
}
});
const ktr = document.querySelector(".kategori");
ktr.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(ktr.value == ""){
hiruf[3].innerText = "Maksimal 20 karakter";
}else if(ktr.value.length > 20){
ktr.value = ktr.value.substr(0,ktr.value.length-1);
hiruf[3].innerText = '20/20';
ktr.blur();
}else{
hiruf[3].innerText = ktr.value.length+'/20';
}
});
document.querySelector(".sampul").addEventListener("change",function(){
const
sampul = document.querySelector(".sampul"),
error = document.querySelectorAll(".error");
error[1].innerText = "";
const file = sampul.files[0];
const tipe = file.type;
if(!tipe.match(['image/jpg|image/jpeg|image/png'])){
sampul.focus();
error[1].innerText = "Harus berekstensi .jpg/.jpeg/.png";
return false;
}
});
const pilkat = document.querySelector(".pilkat");
pilkat.addEventListener("change",function(){
const kat = document.querySelector(".kategori");
const pil = pilkat.selectedOptions;
const a = Array.from(pil).map(({value})=>value);
kat.value = a.slice(",").join(", ");
});
form.addEventListener("submit",function(e){
e.preventDefault();
const
uerel = document.querySelector(".uerel"),
judul = document.querySelector(".judul"),
sampul = document.querySelector(".sampul"),
isi = document.querySelector(".isi"),
deskripsi = document.querySelector(".deskripsi"),
katergori = document.querySelector(".kategori"),
error = document.querySelectorAll(".error"),
simpan = document.querySelector(".simpan-ke-draft"),
terbitkan = document.querySelector(".terbitkan-artikel-baru");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(uerel.value == ""){
alert('Maaf terjadi sedikit kendala dibagian URL belum terisi otomatis, silakan coba lagi klik terbitkan.\n\nTerima kasih.');
uerel.value = jdl.value.toLowerCase().replace(/\ /g,'-').replace(/([^a-z0-9-])+/g,'').replace(/--/g,'');
return false;
}else if(judul.value == ""){
judul.focus();
error[0].innerText = "Masukkan judul!";
return false;
}else if(judul.value.length > 70){
judul.focus();
error[0].innerText = "Terlalu panjang, maksimal 70 karakter!";
return false;
}else if(isi.value == ""){
isi.focus();
error[2].innerText = "Masukkan posting!";
return false;
}else if(isi.value.length < 1000){//1000
isi.focus();
error[2].innerText = "Terlalu pendek, minimal 1000 karakter!";
return false;
}else if(deskripsi.value == ""){
deskripsi.focus();
error[3].innerText = "Masukkan deskripsi!";
return false;
}else if(deskripsi.value.length > 150){
deskripsi.focus();
error[3].innerText = "Terlalu panjang, maksimal 150 karakter!";
return false;
}else if(kategori.value == ""){
kategori.focus();
error[4].innerText = "Pilih kategori!";
return false;
}else if(kategori.value.length > 100){
kategori.focus();
error[4].innerText = "Terlalu panjang, maksimal 50 karakter!";
return false;
}else{
const data = new FormData();
data.append("uerel", uerel.value);
data.append("judul", judul.value);
data.append("sampul", sampul.files[0]);
data.append("isi", isi.value);
data.append("deskripsi", deskripsi.value);
data.append("kategori", kategori.value);
data.append("terbitkan_artikel_baru", terbitkan.value);
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
window.location.href = rsp.href;
},500);
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
}
});
// simpan ke draft
const simpan = document.querySelector(".simpan-ke-draft"); 
simpan.addEventListener("click",function(e){
e.preventDefault();
const
uerel = document.querySelector(".uerel"),
judul = document.querySelector(".judul"),
sampul = document.querySelector(".sampul"),
isi = document.querySelector(".isi"),
deskripsi = document.querySelector(".deskripsi"),
katergori = document.querySelector(".kategori"),
error = document.querySelectorAll(".error");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(uerel.value == ""){
alert('Maaf terjadi sedikit kendala dibagian URL belum terisi otomatis, silakan coba lagi klik simpan.\n\nTerima kasih.');
uerel.focus();
uerel.value = jdl.value.toLowerCase().replace(/\ /g,'-').replace(/([^a-z0-9-])+/g,'').replace(/--/g,'');
return false;
}else if(judul.value == ""){
judul.focus();
error[0].innerText = "Masukkan judul!";
return false;
}else if(judul.value.length > 70){
judul.focus();
error[0].innerText = "Terlalu panjang, maksimal 70 karakter!";
return false;
}else if(isi.value == ""){
isi.focus();
error[2].innerText = "Masukkan posting!";
return false;
}else if(deskripsi.value == ""){
deskripsi.focus();
error[3].innerText = "Masukkan deskripsi!";
return false;
}else if(deskripsi.value.length > 150){
deskripsi.focus();
error[3].innerText = "Terlalu panjang, maksimal 150 karakter!";
return false;
}else if(kategori.value == ""){
kategori.focus();
error[4].innerText = "Pilih kategori!";
return false;
}else if(kategori.value.length > 100){
kategori.focus();
error[4].innerText = "Terlalu panjang, maksimal 50 karakter!";
return false;
}else{
const data = new FormData();
data.append("uerel", uerel.value);
data.append("judul", judul.value);
data.append("sampul", sampul.files[0]);
data.append("isi", isi.value);
data.append("deskripsi", deskripsi.value);
data.append("kategori", kategori.value);
data.append("simpan_ke_draft", simpan.value);
const http = new XMLHttpRequest();
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.open("POST","../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
setTimeout(function(){
document.body.classList.remove("actldr");
loader.classList.remove("show");
},500);
sampul.value = "";
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
}
});
// preview baru
document.querySelector(".preview-post").addEventListener("click",function(e){
e.preventDefault();
const
uerel = document.querySelector(".uerel"),
preview = document.querySelector(".preview-post");
const data = new FormData();
data.append("uerel", uerel.value);
data.append("preview_post", preview.value);
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
window.open(rsp.drc,"_blank");
},500);
}else{
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
});
</script>
<?php
}else if($_GET['set'] == trim(base64_encode("edit-artikel"),'=')){
if(isset($_GET['slug'])){
$getSlug = base64_decode($_GET['slug']);
$selArtikel = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$getSlug' ");
?>
<h2>Perbarui Posting</h2>
<?php
if(mysqli_num_rows($selArtikel) == 1){
$sa = mysqli_fetch_assoc($selArtikel);
$isiArtikel = htmlentities($sa['isi_art']);
?>
<form autocomplete="off" ecntype="multipart/form-data" class="edar">
<div class="row" style="margin:0">
<input type="text" name="uerel" value="<?=$sa['slug_art'];?>" readonly class="uerel"/>
</div>
<div class="row">
<label for="judul">Judul</label>
<span class="hiruf">Maksimal 70 karakter</span>
<input type="text" name="judul" id="judul" value="<?=$sa['judul_art'];?>" placeholder="Masukkan judul" class="judul"/>
<div class="error"></div>
</div>
<div class="row">
<label for="sampul">Sampul</label>
<input type="file" name="sampul" id="sampul" class="sampul"/>
<div class="error"></div>
</div>
<div class="row">
<label for="isi">Posting</label>
<span class="hiruf">Minimal 1000 karakter</span>
<span target-uri="<?=$base_url.'files/'.strtolower(trim(base64_encode('upload_gambar_artikel'),'='));?>" class="upImgArt">Upload Gambar</span>
<span class="parcod">Parse</span>
<textarea name="#" rows="15" placeholder="Ketik atau tempel kode disini..." class="parse"></textarea>
<span class="cls">&times;</span>
<div class="buttons">
<span onclick="copyCode()" class="copy">Copy</span>
<span class="reset">Clear</span>
<span class="procod">Parse</span>
</div>
<textarea rows="15" name="isi" id="isi" placeholder="Masukkan posting" class="isi isa"><?=$isiArtikel;?></textarea>
<div class="error"></div>
</div>
<div class="row">
<label for="deskripsi">Deskripsi</label>
<span class="hiruf">Maksimal 150 karakter</span>
<textarea rows="3" name="deskripsi" id="deskripsi" placeholder="Masukkan deskripsi" class="deskripsi"><?=$sa['deskripsi_art'];?></textarea>
<div class="error"></div>
</div>
<div class="row">
<label for="kategori">Kategori /</label>
<select name="pilkat[]" multiple="multiple" class="pilkat">
<option disabled value="">Umum</option>
<option value="Berita">Berita</option>
<option value="Budaya">Budaya</option>
<option value="Kuliner">Kuliner</option>
<option value="Sosial">Sosial</option>
<option value="Teknologi">Teknologi</option>
<option value="Travel">Travel</option>
<option value="Unik">Unik</option>
<option disabled value="">Review</option>
<option value="Smartphone">Smartphone</option>
<option value="Tablet">Tablet</option>
<option value="Desktop">Desktop</option>
<option value="Permainan">Permainan</option>
<option disabled value="">Tutorial</option>
<option value="Website">Website</option>
<option value="Html">Html</option>
<option value="Css">Css</option>
<option value="Javascript">Javascript</option>
<option value="Php">Php</option>
</select>
<input type="text" name="kategori" id="kategori" value="<?=$sa['kategori_art'];?>" placeholder="Pilih kategori" readonly class="kategori"/>
<div class="error"></div>
</div>
<div class="row center" style="margin:20px 0">
<button type="submit" name="edit_artikel" class="btn-blue edit-artikel">Perbarui</button>
<button type="button" name="simpan_edit_ke_draft" class="btn-green simpan-edit-ke-draft">Simpan</button>
</div>
</form>
<script>
const parcod = document.querySelector(".parcod"),
pars = document.querySelector(".parse"),
cls = document.querySelector(".cls"),
buts = document.querySelector(".buttons"),
cpy = document.querySelector(".copy"),
rest = document.querySelector(".reset"),
proc = document.querySelector(".procod");
parcod.addEventListener("click",function(){
pars.classList.add("show");
cls.classList.add("show");
buts.classList.add("show");
cls.addEventListener("click",function(){
pars.classList.remove("show");
cls.classList.remove("show");
buts.classList.remove("show");
});
cpy.addEventListener("click",function(){
pars.classList.remove("show");
cls.classList.remove("show");
buts.classList.remove("show");
pars.blur();
});
rest.addEventListener("click",function(){
pars.value = "";
pars.focus();
});
proc.addEventListener("click",function(){
if(pars.value == ""){
pars.setAttribute("placeholder","Harap masukkan kode!");
pars.focus();
}else{
let cd = pars.value;
cd = cd.replace(/</g, '&lt;');
cd = cd.replace(/>/g, '&gt;');
cd = cd.replace(/"/g, '&quot;');/*"*/
cd = cd.replace(/'/g, '&apos;');
pars.value = cd;
}
});
});
function copyCode(){
pars.select();
document.execCommand("copy");
alert("Berhasil disalin ke papan klip");
pars.selection.empty();
}
const upImgArt = document.querySelector(".upImgArt");
upImgArt.addEventListener("click",function(){
window.open(upImgArt.getAttribute("target-uri"));
});
const
loader = document.querySelector(".loadani"),
edar = document.querySelector(".edar"),
jdl = document.querySelector(".judul");
jdl.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(jdl.value == ""){
hiruf[0].innerText = "Maksimal 70 karakter";
}else if(jdl.value.length > 70){
jdl.value = jdl.value.substr(0,jdl.value.length-1);
hiruf[0].innerText = '70/70';
jdl.blur();
}else{
hiruf[0].innerText = jdl.value.length+'/70';
}
});
const isat = document.querySelector(".isi");
isat.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(isat.value == ""){
hiruf[1].innerText = "Minimal 1000 karakter";
}else if(isat.value.length < 1000){
hiruf[1].innerText = isat.value.length+'/1000';
}else{
hiruf[1].innerText = '('+isat.value.length+')';
}
});
const dsc = document.querySelector(".deskripsi");
dsc.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(dsc.value == ""){
hiruf[2].innerText = "Maksimal 150 karakter";
}else if(dsc.value.length > 150){
dsc.value = dsc.value.substr(0,dsc.value.length-1);
hiruf[2].innerText = '150/150';
dsc.blur();
}else{
hiruf[2].innerText = dsc.value.length+'/150';
}
});
const ktr = document.querySelector(".kategori");
ktr.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(ktr.value == ""){
hiruf[3].innerText = "Maksimal 20 karakter";
}else if(ktr.value.length > 20){
ktr.value = ktr.value.substr(0,ktr.value.length-1);
hiruf[3].innerText = '20/20';
ktr.blur();
}else{
hiruf[3].innerText = ktr.value.length+'/20';
}
});
document.querySelector(".sampul").addEventListener("change",function(){
const sampul = document.querySelector(".sampul");
const error = document.querySelectorAll(".error");
error[1].innerText = "";
const file = sampul.files[0];
const tipe = file.type;
if(!tipe.match(['image/jpg|image/jpeg|image/png'])){
sampul.focus();
error[1].innerText = "Harus berekstensi .jpg/.jpeg/.png";
return false;
}
});
const pilkat = document.querySelector(".pilkat");
pilkat.addEventListener("change",function(){
const kat = document.querySelector(".kategori");
const pil = pilkat.selectedOptions;
const a = Array.from(pil).map(({value})=>value);
kat.value = a.slice(",").join(", ");
});
edar.addEventListener("submit",function(e){
e.preventDefault();
const
uerel = document.querySelector(".uerel"),
judul = document.querySelector(".judul"),
sampul = document.querySelector(".sampul"),
isi = document.querySelector(".isi"),
deskripsi = document.querySelector(".deskripsi"),
kategori = document.querySelector(".kategori"),
error = document.querySelectorAll(".error"),
edit = document.querySelector(".edit-artikel");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(judul.value == ""){
judul.focus();
error[0].innerText = "Masukkan judul!";
return false;
}else if(judul.value.length > 70){
judul.focus();
error[0].innerText = "Terlalu panjang, maksimal 70 karakter!";
return false;
}else if(isi.value == ""){
isi.focus();
error[2].innerText = "Masukkan posting!";
return false;
}else if(isi.value.length < 1000){//1000
isi.focus();
error[2].innerText = "Terlalu pendek, minimal 1000 karakter!";
return false;
}else if(deskripsi.value == ""){
deskripsi.focus();
error[3].innerText = "Masukkan deskripsi!";
return false;
}else if(deskripsi.value.length > 150){
deskripsi.focus();
error[3].innerText = "Terlalu panjang, maksimal 150 karakter!";
return false;
}else if(kategori.value == ""){
kategori.focus();
error[4].innerText = "Pilih kategori!";
return false;
}else if(kategori.value.length > 100){
kategori.focus();
error[4].innerText = "Terlalu panjang, maksimal 50 karakter!";
return false;
}else if(uerel.value == ""){
uerel.focus();
alert('Maaf terjadi kesalah tak terduga, coba kembali kehalaman sebelumnya dan lakukan langkah seperti sebelumnya. Terima kasih.');
return false;
}else{
const data = new FormData();
data.append("uerel", uerel.value);
data.append("judul", judul.value);
data.append("sampul", sampul.files[0]);
data.append("isi", isi.value);
data.append("deskripsi", deskripsi.value);
data.append("kategori", kategori.value);
data.append("edit_artikel", edit.value);
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
window.location.href = rsp.href;
},500);
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
}
});
// simpan ke draft
const simpan = document.querySelector(".simpan-edit-ke-draft"); 
simpan.addEventListener("click",function(e){
e.preventDefault();
const
uerel = document.querySelector(".uerel"),
judul = document.querySelector(".judul"),
sampul = document.querySelector(".sampul"),
isi = document.querySelector(".isi"),
deskripsi = document.querySelector(".deskripsi"),
katergori = document.querySelector(".kategori"),
error = document.querySelectorAll(".error");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(uerel.value == ""){
alert('Maaf terjadi sedikit kendala dibagian URL belum terisi otomatis, silakan coba lagi klik simpan.\n\nTerima kasih.');
uerel.focus();
uerel.value = jdl.value.toLowerCase().replace(/\ /g,'-').replace(/([^a-z0-9-])+/g,'').replace(/--/g,'');
return false;
}else if(judul.value == ""){
judul.focus();
error[0].innerText = "Masukkan judul!";
return false;
}else if(judul.value.length > 70){
judul.focus();
error[0].innerText = "Terlalu panjang, maksimal 70 karakter!";
return false;
}else if(isi.value == ""){
isi.focus();
error[2].innerText = "Masukkan posting!";
return false;
}else if(deskripsi.value == ""){
deskripsi.focus();
error[3].innerText = "Masukkan deskripsi!";
return false;
}else if(deskripsi.value.length > 150){
deskripsi.focus();
error[3].innerText = "Terlalu panjang, maksimal 150 karakter!";
return false;
}else if(kategori.value == ""){
kategori.focus();
error[4].innerText = "Pilih kategori!";
return false;
}else if(kategori.value.length > 100){
kategori.focus();
error[4].innerText = "Terlalu panjang, maksimal 50 karakter!";
return false;
}else{
const data = new FormData();
data.append("uerel", uerel.value);
data.append("judul", judul.value);
data.append("sampul", sampul.files[0]);
data.append("isi", isi.value);
data.append("deskripsi", deskripsi.value);
data.append("kategori", kategori.value);
data.append("simpan_edit_ke_draft", simpan.value);
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
window.location.href = rsp.drc;
},500);
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
}
});
</script>
<?php
}else{
?>
<div class="notf">
<h3>Data Tidak Ditemukan!</h3>
<p>Maaf tidak ada data untuk diperbarui, coba pilih data atau kembali ke halaman utama.</p>
<p><a href="<?=$base_url."artikel/beranda";?>">Beranda</a></p>
</div>
<?php
}
}
}else if($_GET['set'] == trim(base64_encode("data-draft"),'=')){
$data = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE email_art='".$_SESSION['email']."' ");
if(mysqli_num_rows($data) > 0){
?>
<h2><?=ucwords(str_replace('edit','perbarui',str_replace('-',' ',base64_decode($_GET['set']))));?></h2>
<div class="table">
<table>
<tbody>
<?php
$no = 1;
while($dt = mysqli_fetch_assoc($data)){
?>
<tr>
<td><?=$no.".";?></td>
<td><?=$dt['judul_art'];?></td>
<td><?=$dt['terbit_art']." / ".$dt['update_art'];?></td>
<td data-target="<?=trim(base64_encode('edit-draft'),'=');?>" data-edit="<?=trim(base64_encode($dt['slug_art']),'=');?>" class="edit-data-draft">Edit</td>
</tr>
<?php
$no++;
}
?>
</tbody>
</table>
</div>
<script>
const edd = document.querySelectorAll(".edit-data-draft");
for(let i = 0; i < edd.length; i++){
edd[i].addEventListener("click",function(){
let
dt = edd[i].getAttribute("data-target"),
de = edd[i].getAttribute("data-edit");
window.location.href = dt+"/"+de;
});
}
</script>
<?php
}else{
?>
<div class="notf">
<h3>Draft Kosong!</h3>
<p>Maaf Anda belum menyimpan artikel apapun di draft. Tulis artikel baru, atau kembali ke beranda.</p>
<p><a href="<?=$base_url."kelola/".trim(base64_encode('tambah-artikel-baru'),'=');?>">Artikel Baru</a></p>
<p><a href="<?=$base_url."artikel/beranda";?>">Beranda</p>
</div>
<?php
}
}else if($_GET['set'] == trim(base64_encode("edit-draft"),'=')){
?>
<h2><?=ucwords(str_replace('edit','perbarui',str_replace('-',' ',base64_decode($_GET['set']))));?></h2>
<?php
$slg = base64_decode($_GET['slug']);
$eml = $_SESSION['email'];
$data = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slg' AND email_art='$eml' ");
if(mysqli_num_rows($data) == 1){
$dt = mysqli_fetch_assoc($data);
$slug = $dt['slug_art'];
$judul = $dt['judul_art'];
$isi = htmlentities($dt['isi_art']);
$deskripsi = $dt['deskripsi_art'];
$kategori = $dt['kategori_art'];
}else{
$direct = $base_url."kelola/".trim(base64_encode('data-draft'),'=');
echo '<script>window.location.href="'.$direct.'"</script>';
}
?>
<form autocomplete="off" ecntype="multipart/form-data" class="edraft">
<span data-hpdr="<?=trim(base64_encode($slug),'=');?>" class="hpdr">Hapus</span>
<div class="row" style="margin:0">
<input type="hidden" name="uerel" value="<?=$slug;?>" readonly class="uerel"/>
</div>
<div class="row">
<label for="judul">Judul</label>
<span class="hiruf">Maksimal 70 karakter</span>
<input type="text" name="judul" id="judul" value="<?=$judul;?>" placeholder="Masukkan judul" class="judul"/>
<div class="error"></div>
</div>
<div class="row">
<label for="sampul">Sampul</label>
<input type="file" name="sampul" id="sampul" class="sampul"/>
<div class="error"></div>
</div>
<div class="row">
<label for="isi">Posting</label>
<span class="hiruf">Minimal 1000 karakter</span>
<span target-uri="<?=$base_url.'files/'.strtolower(trim(base64_encode('upload_gambar_artikel'),'='));?>" class="upImgArt">Upload Gambar</span>
<span class="parcod">Parse</span>
<textarea name="#" rows="15" placeholder="Ketik atau tempel kode disini..." class="parse"></textarea>
<span class="cls">&times;</span>
<div class="buttons">
<span onclick="copyCode()" class="copy">Copy</span>
<span class="reset">Clear</span>
<span class="procod">Parse</span>
</div>
<textarea rows="15" name="isi" id="isi" placeholder="Masukkan posting" class="isi isa"><?=$isi;?></textarea>
<div class="error"></div>
</div>
<div class="row">
<label for="deskripsi">Deskripsi</label>
<span class="hiruf">Maksimal 150 karakter</span>
<textarea rows="3" name="deskripsi" id="deskripsi" placeholder="Masukkan deskripsi" class="deskripsi"><?=$deskripsi;?></textarea>
<div class="error"></div>
</div>
<div class="row">
<label for="kategori">Kategori /</label>
<select name="pilkat[]" multiple="multiple" class="pilkat">
<option disabled value="">Umum</option>
<option value="Berita">Berita</option>
<option value="Budaya">Budaya</option>
<option value="Kuliner">Kuliner</option>
<option value="Sosial">Sosial</option>
<option value="Teknologi">Teknologi</option>
<option value="Travel">Travel</option>
<option value="Unik">Unik</option>
<option disabled value="">Review</option>
<option value="Smartphone">Smartphone</option>
<option value="Tablet">Tablet</option>
<option value="Desktop">Desktop</option>
<option value="Permainan">Permainan</option>
<option disabled value="">Tutorial</option>
<option value="Website">Website</option>
<option value="Html">Html</option>
<option value="Css">Css</option>
<option value="Javascript">Javascript</option>
<option value="Php">Php</option>
</select>
<input type="text" name="kategori" id="kategori" value="<?=$kategori;?>" placeholder="Pilih kategori" readonly class="kategori"/>
<div class="error"></div>
</div>
<div class="row center" style="margin:20px 0">
<button type="submit" name="terbitkan_draft" class="btn-blue terbitkan-draft">Terbitkan</button>
<button type="button" name="simpan_pembaruan_draft" class="btn-green simpan-pembaruan-draft">Simpan</button>
<button type="button" class="btn-orange preview-post">Preview</button>
</div>
</form>
<script>
const parcod = document.querySelector(".parcod"),
pars = document.querySelector(".parse"),
cls = document.querySelector(".cls"),
buts = document.querySelector(".buttons"),
cpy = document.querySelector(".copy"),
rest = document.querySelector(".reset"),
proc = document.querySelector(".procod");
parcod.addEventListener("click",function(){
pars.classList.add("show");
cls.classList.add("show");
buts.classList.add("show");
cls.addEventListener("click",function(){
pars.classList.remove("show");
cls.classList.remove("show");
buts.classList.remove("show");
});
cpy.addEventListener("click",function(){
pars.classList.remove("show");
cls.classList.remove("show");
buts.classList.remove("show");
pars.blur();
});
rest.addEventListener("click",function(){
pars.value = "";
pars.focus();
});
proc.addEventListener("click",function(){
if(pars.value == ""){
pars.setAttribute("placeholder","Harap masukkan kode!");
pars.focus();
}else{
let cd = pars.value;
cd = cd.replace(/</g, '&lt;');
cd = cd.replace(/>/g, '&gt;');
cd = cd.replace(/"/g, '&quot;');/*"*/
cd = cd.replace(/'/g, '&apos;');
pars.value = cd;
}
});
});
function copyCode(){
pars.select();
document.execCommand("copy");
alert("Berhasil disalin ke papan klip");
pars.selection.empty();
}
const upImgArt = document.querySelector(".upImgArt");
upImgArt.addEventListener("click",function(){
window.open(upImgArt.getAttribute("target-uri"));
});
const
loader = document.querySelector(".loadani"),
edf = document.querySelector(".edraft"),
jdl = document.querySelector(".judul");
jdl.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(jdl.value == ""){
hiruf[0].innerText = "Maksimal 70 karakter";
}else if(jdl.value.length > 70){
jdl.value = jdl.value.substr(0,jdl.value.length-1);
hiruf[0].innerText = '70/70';
jdl.blur();
}else{
hiruf[0].innerText = jdl.value.length+'/70';
}
});
const isat = document.querySelector(".isi");
isat.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(isat.value == ""){
hiruf[1].innerText = "Minimal 1000 karakter";
}else if(isat.value.length < 1000){
hiruf[1].innerText = isat.value.length+'/1000';
}else{
hiruf[1].innerText = '('+isat.value.length+')';
}
});
const dsc = document.querySelector(".deskripsi");
dsc.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(dsc.value == ""){
hiruf[2].innerText = "Maksimal 150 karakter";
}else if(dsc.value.length > 150){
dsc.value = dsc.value.substr(0,dsc.value.length-1);
hiruf[2].innerText = '150/150';
dsc.blur();
}else{
hiruf[2].innerText = dsc.value.length+'/150';
}
});
const ktr = document.querySelector(".kategori");
ktr.addEventListener("keyup",function(){
const hiruf = document.querySelectorAll(".hiruf");
if(ktr.value == ""){
hiruf[3].innerText = "Maksimal 20 karakter";
}else if(ktr.value.length > 20){
ktr.value = ktr.value.substr(0,ktr.value.length-1);
hiruf[3].innerText = '20/20';
ktr.blur();
}else{
hiruf[3].innerText = ktr.value.length+'/20';
}
});
document.querySelector(".sampul").addEventListener("change",function(){
const sampul = document.querySelector(".sampul");
const error = document.querySelectorAll(".error");
error[1].innerText = "";
const file = sampul.files[0];
const tipe = file.type;
if(!tipe.match(['image/jpg|image/jpeg|image/png'])){
sampul.focus();
error[1].innerText = "Harus berekstensi .jpg/.jpeg/.png";
return false;
}
});
const pilkat = document.querySelector(".pilkat");
pilkat.addEventListener("change",function(){
const kat = document.querySelector(".kategori");
const pil = pilkat.selectedOptions;
const a = Array.from(pil).map(({value})=>value);
kat.value = a.slice(",").join(", ");
});
edf.addEventListener("submit",function(e){
e.preventDefault();
const
slug = document.querySelector(".uerel"),
judul = document.querySelector(".judul"),
sampul = document.querySelector(".sampul"),
isi = document.querySelector(".isi"),
deskripsi = document.querySelector(".deskripsi"),
kategori = document.querySelector(".kategori"),
error = document.querySelectorAll(".error"),
terbitkan = document.querySelector(".terbitkan-draft");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(judul.value == ""){
judul.focus();
error[0].innerText = "Masukkan judul!";
return false;
}else if(judul.value.length > 70){
judul.focus();
error[0].innerText = "Terlalu panjang, maksimal 70 karakter!";
return false;
}else if(isi.value == ""){
isi.focus();
error[2].innerText = "Masukkan posting!";
return false;
}else if(isi.value.length < 1000){//1000
isi.focus();
error[2].innerText = "Terlalu pendek, minimal 1000 karakter!";
return false;
}else if(deskripsi.value == ""){
deskripsi.focus();
error[3].innerText = "Massukan deskripsi!";
return false;
}else if(deskripsi.value.length > 150){
deskripsi.focus();
error[3].innerText = "Terlalu panjang, maksimal 150 karakter!";
return false;
}else if(kategori.value == ""){
kategori.focus();
error[4].innerText = "Pilih kategori!";
return false;
}else if(kategori.value.length > 100){
kategori.focus();
error[4].innerText = "Terlalu panjang, maksimal 100 karakter!";
return false;
}else if(slug.value == ""){
slug.focus();
alert("Maaf terjadi kesalahan tak terduga! Mohon tunggu beberapa saat dan coba kembali.\n\nTerima kasih.");
return false;
}else{
const data = new FormData();
data.append("uerel", slug.value);
data.append("judul", judul.value);
data.append("sampul", sampul.files[0]);
data.append("isi", isi.value);
data.append("deskripsi", deskripsi.value);
data.append("kategori", kategori.value);
data.append("terbitkan_draft", terbitkan.value);
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
window.location.href = rsp.drc;
},500);
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
}
});
// simpan pembaruan draft
document.querySelector(".simpan-pembaruan-draft").addEventListener("click",function(e){
e.preventDefault();
const
slug = document.querySelector(".uerel"),
judul = document.querySelector(".judul"),
sampul = document.querySelector(".sampul"),
isi = document.querySelector(".isi"),
deskripsi = document.querySelector(".deskripsi"),
katergori = document.querySelector(".kategori"),
error = document.querySelectorAll(".error");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(slug.value == ""){
alert("Maaf terjadi kesalahan tak terduga! Mohon tunggu beberapa saat dan coba kembali.\n\nTerima kasih.");
return false;
}else if(judul.value == ""){
judul.focus();
error[0].innerText = "Masukkan judul!";
return false;
}else if(judul.value.length > 70){
judul.focus();
error[0].innerText = "Terlalu panjang, maksimal 70 karakter!";
return false;
}else if(isi.value == ""){
isi.focus();
error[2].innerText = "Masukkan posting!";
return false;
}else if(deskripsi.value == ""){
deskripsi.focus();
error[3].innerText = "Masukkan deskripsi!";
return false;
}else if(deskripsi.value.length > 150){
deskripsi.focus();
error[3].innerText = "Terlalu panjang, maksimal 150 karakter!";
return false;
}else if(kategori.value == ""){
kategori.focus();
error[4].innerText = "Pilih kategori!";
return false;
}else if(kategori.value.length > 100){
kategori.focus();
error[4].innerText = "Terlalu panjang, maksimal 50 karakter!";
return false;
}else{
const data = new FormData();
data.append("uerel", slug.value);
data.append("judul", judul.value);
data.append("sampul", sampul.files[0]);
data.append("isi", isi.value);
data.append("deskripsi", deskripsi.value);
data.append("kategori", kategori.value);
data.append("simpan_pembaruan_draft", "");
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
setTimeout(function(){
document.body.classList.remove("actldr");
loader.classList.remove("show");
},500);
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
}
});
// hapus draft
const hpdr = document.querySelector(".hpdr");
hpdr.addEventListener("click",function(){
if(confirm("Yakin ingin dihapus?") == true){
const data = new FormData();
data.append("uerel", atob(hpdr.getAttribute("data-hpdr")));
data.append("hapus_draft", "");
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
alert(rsp.msg);
window.location.href = rsp.drc;
},500);
}else if(rsp.no == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
}
});
// preview baru
document.querySelector(".preview-post").addEventListener("click",function(e){
e.preventDefault();
const
uerel = document.querySelector(".uerel"),
preview = document.querySelector(".preview-post");
const data = new FormData();
data.append("uerel", uerel.value);
data.append("preview_post", preview.value);
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onloadstart = function(){
document.body.classList.add("actldr");
loader.classList.add("show");
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.body.classList.remove("actldr");
loader.classList.remove("show");
setTimeout(function(){
window.open(rsp.drc);
},500);
}else{
document.body.classList.remove("actldr");
loader.classList.remove("show");
alert(rsp.msg);
}
}
};
http.send(data);
});
</script>
<?php
}else if($_GET['set'] == trim(base64_encode("pasang-iklan"),'=')){
?>
<h2><?=ucwords(str_replace('-',' ',base64_decode($_GET['set'])));?></h2>
<form autocomplete="off" enctype="multipart/form-data" id="form_iklan">
<div class="row">
<label for="email">Email Iklan *</label>
<input type="email" name="email" id="email" placeholder="Masukkan email"/>
<div class="error"></div>
</div>
<div class="row">
<label for="url">Url Iklan *</label>
<input type="url" name="url" id="url" placeholder="Masukkan Url"/>
<div class="error"></div>
</div>
<div class="row">
<label for="judul">Judul Iklan *</label>
<input type="text" name="judul" id="judul" placeholder="Masukkan judul"/>
<div class="error"></div>
</div>
<div class="row">
<label for="deskripsi">Deskripsi Iklan *</label>
<textarea name="deskripsi" id="deskripsi" placeholder="Massukan deskripsi" rows="4"></textarea>
<div class="error"></div>
</div>
<div class="row">
<label for="aktif">Masa Aktif Iklan *</label>
<select name="aktif" id="aktif">
<option disabled selected value="">Pilih Masa aktif</option>
<option value="1">1 Bulan</option>
<option value="2">2 Bulan</option>
<option value="3">3 Bulan</option>
<option value="4">4 Bulan</option>
<option value="5">5 Bulan</option>
<option value="6">6 Bulan</option>
<option value="12">1 Tahun</option>
</select>
<div class="error"></div>
</div>
<div class="row">
<label for="posisi">Posisi Iklan *</label>
<select name="posisi" id="posisi">
<option disabled selected value="">Pilih Posisi</option>
<option value="post1">Posting 1</option>
<option value="post2">Posting 2</option>
<option value="post3">Posting 3</option>
<option value="post4">Posting 4</option>
<option value="sidebar1">Sidebar 1</option>
<option value="sidebar2">Sidebar 2</option>
</select>
<div class="error"></div>
</div>
<div class="row">
<label for="gambar">Gambar Iklan (opsional)</label>
<input type="file" name="gambar" id="gambar"/>
<div class="error"></div>
</div>
<div class="row center" style="margin-top: 30px">
<button type="submit" id="upload_iklan">Upload</div>
</div>
</form>
<script>
document.querySelector("#gambar").addEventListener("change", pilihGambar);
function pilihGambar(){
let file = document.querySelector("#gambar"),
error = document.querySelectorAll(".error"),
tp = file.files[0].type,
sz = file.files[0].size;
if(!tp.match(['image/jpg|image/jpeg|image/png'])){
file.focus();
error[6].innerText = "Hanya mendukung format .jpg, .jpeg, .png!";
return false;
}else if(sz > 3000000){
file.focus();
error[6].innerText = "Maksimal ukuran gambar 3MB!";
return false;
}else{
error[6].innerText = "";
}
}
document.querySelector("#form_iklan").addEventListener("submit", uploadIklan);
function uploadIklan(e){
e.preventDefault();
let email = document.querySelector("#email"),
url = document.querySelector("#url"),
judul = document.querySelector("#judul"),
deskripsi = document.querySelector("#deskripsi"),
aktif = document.querySelector("#aktif"),
posisi = document.querySelector("#posisi"),
gambar = document.querySelector("#gambar"),
error = document.querySelectorAll(".error"),
upload = document.querySelector("#upload_iklan");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(email.value == ""){
email.focus();
error[0].innerText = "Email tidak boleh kosong!";
return false;
}else if(email.value.length > 50){
email.focus();
error[0].innerText = "Tidak boleh lebih dari 50 karakter!";
return false;
}else if(url.value == ""){
url.focus();
error[1].innerText = "Url tidak boleh kosong!";
return false;
}else if(url.value.length > 100){
url.focus();
error[1].innerText = "Tidak boleh lebih dari 100 karakter!";
return false;
}else if(judul.value == ""){
judul.focus();
error[2].innerText = "Judul tidak boleh kosong!";
return false;
}else if(judul.value.length > 50){
judul.focus();
error[2].innerText = "Tidak boleh lebih dari 50 karakter!";
return false;
}else if(deskripsi.value == ""){
deskripsi.focus();
error[3].innerText = "Deskripsi tidak boleh kosong!";
return false;
}else if(deskripsi.value.length > 200){
deskripsi.focus();
error[3].innerText = "Tidak boleh lebih dari 200 karakter!";
return false;
}else if(aktif.value == ""){
aktif.focus();
error[4].innerText = "Pilih masa aktif!";
return false;
}else if(posisi.value == ""){
posisi.focus();
error[5].innerText = "Pilih posisi!";
return false;
}else if(gambar.value.length > 100){
gambar.focus();
error[6].innerText = "Tidak boleh lebih dari 100 karakter!";
return false;
}else{
const data = new FormData();
data.append("email", email.value);
data.append("url", url.value);
data.append("judul", judul.value);
data.append("deskripsi", deskripsi.value);
data.append("aktif", aktif.value);
data.append("posisi", posisi.value);
data.append("gambar", gambar.files[0]);
data.append("upload_iklan", upload.value);
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
document.querySelector("#form_iklan").reset();
email.value = "";
url.value = "";
judul.value = "";
deskripsi.value = "";
gambar.value = "";
alert(rsp.msg);
}else if(rsp.no == true){
alert(rsp.msg);
}
}
};
http.send(data);
}
}
</script>
<?php
}else{
?>
<div class="notf">
<h3>Tidak Ditemukan!</h3>
<p>Maaf halaman yang dimaksud tidak tersedia. Silakan kembali ke halaman utama atau gunakan navigasi dikanan atas.</p>
<p><a href="<?=$base_url;?>">Beranda</p>
</div>
<?php
}
}
?>

</div>

</div>
<script>
const btn = document.querySelector(".header .menu");
btn.addEventListener("click",function(){
btn.classList.toggle("hvr");
if(btn.innerText == "="){
btn.innerText = "×";
}else{
btn.innerText = "=";
}
const menu_box = document.querySelector(".menu-box");
menu_box.classList.toggle("open");
const menu = document.querySelectorAll(".menu-box ul li");
for(let i = 0; i < menu.length; i++){
menu[i].addEventListener("click",function(){
const target = this.getAttribute("ref");
window.location.href = target;
});
}
});
</script>
<?php
if(isset($_GET['set']) && isset($_SESSION['id'])){
if($_GET['set'] != trim(base64_encode("tambah-artikel-baru"),'=')){
$_SESSION['id'] = "";
unset($_SESSION['id']);
}
}
?>
</body>
</html>
