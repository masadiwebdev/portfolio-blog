<?php
if(isset($_GET['add']) || isset($_GET['key']) || isset($_GET['val'])){
session_start();
require 'conf.php';
if($_GET['key']){
$titleBar = ucwords(str_replace('-',' ',$_GET['key']));
}else{
$titleBar = "Not Found!";
}
?>
<!DOCTYPE html>
<html>
<title><?=$titleBar;?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no"/>
<style>
* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}
html {
	scroll-behavior: smoot;
}
body {
	
}
form {
	border-radius: 3px;
	box-shadow: 0 0 0 1px rgba(0,0,30,.1), 2px 4px 10px rgba(0,0,30,.1);
	margin: 10% auto;
	max-width: 557px;
	padding: 20px;
	width: 95%;
}
form h5 {
	border-bottom: 1px solid rgba(0,0,30,.1);
	font-size: 1em;
	margin: 0 0 15px;
	padding: 0 0 15px;
}
form .row {
	margin: 10px 0;
}
form .row label {
	color: #555;
	display: block;
	font-family: sans-serif;
	font-size: .85em;
	font-weight: 500;
}
form .row select, form .row input, form .row textarea {
	background-color: white;
	border: 0;
	border-radius: 2px;
	box-shadow: 0 0 0 1px rgba(0,0,30,.1), 0 0 0 3px rgba(0,0,30,.05);
	margin: 5px 0;
	padding: 10px;
	width: 100%;
}
form .row textarea {
	min-height: 250px;
}
form .row select:focus, form .row input:focus, form .row textarea:focus {
	box-shadow: 0 0 0 1px rgba(30,144,255,.15), 0 0 0 4px rgba(30,144,255,.15);
	outline-style: none;
}
form .row button {
	border: 0;
	border-radius: 2px;
	box-shadow: 0 0 0 1px rgba(0,0,30,.1);
	letter-spacing: .035em;
	margin: 0 10px;
	padding: 10px 13px;
}
form .row button[type=submit] {
	background-color: dodgerblue;
	color: white;
	transition: all .25s ease-in-out;
}
form .row button:hover {
	transform: scale(.9);
}
form .row .error {
	color: brown;
	font-size: .8em;
	height: 18px;
	line-height: 18px;
}
</style>
</head>
<body>
<?php
if($_GET['add'] == "add"){
if($_GET['key'] == "new-project"){
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<form id="form_add_new_project" autocomplete="off" enctype="multipart/form-data">
<h5>Add New Project</h5>
<div class="row">
<label for="url_project">Url Project</label>
<input type="url" name="url_project" id="url_project" placeholder="Masukkan url project"/>
<div class="error"></div>
</div>
<div class="row">
<label for="nama_project">Nama Project</label>
<input type="text" name="nama_project" id="nama_project" placeholder="Masukkan nama project"/>
<div class="error"></div>
</div>
<div class="row">
<label for="screenshot_project">Screenshot Project</label>
<input type="file" name="screenshot_project" id="screenshot_project"/>
<div class="error"></div>
</div>
<div class="row">
<button type="button" id="bth">Kembali</button>
<button type="submit" name="add_new_project" id="btn_add_new_project">Proses Data</button>
</div>
</form>
<script>
let form = document.querySelector("#form_add_new_project");
form.addEventListener("submit", addNewProject);
function addNewProject(e) {
e.preventDefault();
let url = document.querySelector("#url_project"),
nama = document.querySelector("#nama_project"),
screenshot = document.querySelector("#screenshot_project"),
err = document.querySelectorAll(".error"),
submit = document.querySelector("#btn_add_new_project");
for(let i = 0; i < err.length; i++){
err[i].innerText = "";
}
if(url.value == ""){
url.focus();
err[0].innerText = "Masukkan url utama project!";
return false;
}else if(nama.value == ""){
nama.focus();
err[1].innerText = "Masukkan nama halaman project!";
return false;
}else if(screenshot.value == ""){
screenshot.focus();
err[2].innerText = "Pilih screenshot halaman project!";
return false;
}else{
let data = new FormData();
data.append("url", url.value);
data.append("nama", nama.value);
data.append("screenshot", screenshot.files[0]);
data.append("add_new_project", submit.value);
let http = new XMLHttpRequest();
http.open("POST", "../../../proses", true);
http.onloadstart = function(){
submit.innerText = "Data Diproses...";
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
let rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
setTimeout(function(){
submit.innerText = "Selesai";
},500);
setTimeout(function(){
submit.innerText = "Proses Data";
},2000);
setTimeout(function(){
window.location.href = rsp.drc;
},3000);
}else if(rsp.no == true){
submit.innerText = "Coba Kembali";
alert(rsp.msg);
}
}
};
http.send(data);
}
}
document.querySelector("#bth").addEventListener("click",function(){
window.location.href = "/#project";
});
</script>
<?php
}
}else{
echo 'Not Found!';
}
}else if($_GET['key'] == "new-page"){
if(isset($_GET['val'])){
if($_GET['val'] == "about"){
$selected = "selected";
}else{
$selected = "";
}
}else{
$selected = "";
}
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<form id="form_add_new_page" autocomplete="off">
<h5>Add New Page</h5>
<div class="row">
<label fot="target">Target Halaman</label>
<select name="target" id="target">
<option disabled selected value="">Pilih Satu</option>
<option <?=$selected;?> value="about">About</option>
<option value="aturan_iklan">Aturan Iklan</option>
<option value="disclaimer">Disclaimer</option>
<option value="tentang">Tentang</option>
<option value="privacy">Privacy</option>
</select>
<div class="error"></div>
</div>
<div class="row">
<label for="judul">Judul Halaman</label>
<input type="text" name="judul" id="judul" placeholder="Masukkan judul"/>
<div class="error"></div>
</div>
<div class="row">
<label for="deskripsi">Deskripsi Halaman</label>
<textarea name="deskripsi" id="deskripsi" placeholder="Masukkan deskripsi"></textarea>
<div class="error"></div>
</div>
<div class="row">
<button type="button" id="bth">Kembali</button>
<button type="submit" name="add_newp_page" id="btn_add_new_page">Proses</button>
</div>
</form>
<script>
let form = document.querySelector("#form_add_new_page");
form.addEventListener("submit", addNewPage);
function addNewPage(e){
e.preventDefault();
let target = document.querySelector("#target"),
judul = document.querySelector("#judul"),
dedkripsi = document.querySelector("#deskripsi"),
err = document.querySelectorAll(".error"),
submit = document.querySelector("#btn_add_new_page");
for(let i = 0; i < err.length; i++){
err[i].innerText = "";
}
if(target.value == ""){
target.focus();
err[0].innerText ="Pilih salah satu!";
return false;
}else if(judul.value == ""){
judul.focus();
err[1].innerText = "Masukkan judul!";
return false;
}else if(deskripsi.value == ""){
deskripsi.focus();
err[2].innerText = "Masukkan deskripsi!";
return false;
}else{
let data = new FormData();
data.append("target", target.value);
data.append("judul", judul.value);
data.append("deskripsi", deskripsi.value);
data.append("add_new_page", submit.value);
let http = new XMLHttpRequest();
http.open("POST", "../../../proses", true);
http.onloadstart = function(){
submit.innerText = "Data Diproses...";
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
let rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
setTimeout(function(){
submit.innerText = "Selesai";
},500);
setTimeout(function(){
submit.innerText = "Proses Data";
},2000);
setTimeout(function(){
window.location.href = rsp.drc;
},3000);
}else if(rsp.no == true){
submit.innerText = "Coba Kembali";
alert(rsp.msg);
}
}
};
http.send(data);
}
}
document.querySelector("#bth").addEventListener("click",function(){
window.location.href = "/#about";
});
</script>
<?php
}
}else{
echo 'Not Found!';
}
}
}
?>
<?php
if($_GET['add'] == "edit"){
if($_GET['key'] == "project"){
$data_project = mysqli_query($con,"SELECT * FROM tb_project WHERE id='".$_GET['val']."' ");
if(mysqli_num_rows($data_project) == 1){
$dp = mysqli_fetch_assoc($data_project);
?>
<form id="form_edit_project" autocomplete="off" enctype="multipart/form-data">
<h5>Edit Data Project</h5>
<div class="row">
<label for="url">Url Project</label>
<input type="url" name="url" id="url" value="<?=$dp['url'];?>" placeholder="Masukkan url halaman project"/>
<div class="error"></div>
</div>
<div class="row">
<label for="nama">Nama Project</label>
<input type="text" name="nama" id="nama" value="<?=$dp['nama'];?>" placeholder="Masukkan nama project"/>
<div class="error"></div>
</div>
<div class="row">
<label for="screenshot">Screenshot Project</label>
<input type="file" name="screenshot" id="screenshot"/>
<div class="error"></div>
</div>
<div class="row">
<input type="hidden" name="target" id="target" value="ed_<?=trim(base64_encode($dp['id']),'=');?>_pro"/>
<button type="button" id="bth">Kembali</button>
<button type="submit" name="edit_data_project" id="btn_edit_project">Simpan</button>
</div>
</form>
<script>
document.querySelector("#form_edit_project").addEventListener("submit", editProject);
function editProject(e){
e.preventDefault();
let target = document.querySelector("#target"),
url = document.querySelector("#url"),
nama = document.querySelector("#nama"),
screenshot = document.querySelector("#screenshot"),
err = document.querySelectorAll(".error"),
submit = document.querySelector("#btn_edit_project");
for(let i = 0; i < err.length; i++){
err[i].innerText = "";
}
if(url.value == ""){
url.focus();
err[0].innerText = "Masukkan url halaman project!";
return false;
}else if(nama.value == ""){
nama.focus();
err[1].innerText = "Masukkan nama project!";
return false;
}else{
let data = new FormData();
data.append("target", target.value);
data.append("url", url.value);
data.append("nama", nama.value);
data.append("screenshot", screenshot.files[0]);
data.append("edit_data_project","");
let http = new XMLHttpRequest();
http.open("POST", "../../../proses", true);
http.onloadstart = function(){
submit.innerText = "Menyimpan...";
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
let rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
setTimeout(function(){
submit.innerText = "Selesai";
},500);
setTimeout(function(){
submit.innerText = "Simpan";
},2000);
setTimeout(function(){
window.location.href = rsp.drc;
},3000);
}else if(rsp.no == true){
alert(rsp.msg);
}
}
};
http.send(data);
}
}
document.querySelector("#bth").addEventListener("click", function(){
window.location.href = "/#project";
});
</script>
<?php
}else{
echo 'Not Found!';
}
}
}
?>
<?php
if($_GET['add'] == "view"){
if($_GET['key'] == "project"){
$data_project = mysqli_query($con,"SELECT * FROM tb_project WHERE id='".$_GET['val']."' ");
if(mysqli_num_rows($data_project) == 1){
$dp = mysqli_fetch_assoc($data_project);
?>
<style>
div {
	margin: 0 0 20px;
	padding: 5%;
}
div p {
	margin-bottom: 20px;
}
div p img {
	box-shadow: 0 0 0 2px rgba(0,0,30,.1);
}
div#button {
	text-align: center;
}
div#button button {
	border: 0;
	border-radius: 2px;
	box-shadow: 0 0 0 1px rgba(0,0,30,.1);
	height: 30px;
	line-height: 30px;
	margin: 0 10px;
	padding: 0 10px;
}
div#button button#delpro {
	background-color: brown;
	color: white;
}
</style>
<div>
<p><img src="<?=$base_url.'data/file/project/img/'.$dp['screenshot'];?>" style="width:100%"/></p>
<p>Nama: <?=$dp['nama'];?></p>
<p>Alamat: <?=$dp['url'];?></p>
</div>
<div id="button">
<button type="button" id="bth">Kembali</button>
<button type="button" id="delpro" data-project="<?=trim(base64_encode($dp['id']),'=');?>">Hapus</button>
</div>
<script>
document.querySelector("#delpro").addEventListener("click",function(){
if(confirm("Hapus project ini?") == true){
let data = new FormData();
data.append("target", document.querySelector("#delpro").getAttribute("data-project"));
data.append("delete_data_project", "by_target");
let http = new XMLHttpRequest();
http.open("POST", "../../../proses", true);
http.onloadstart = function(){
document.querySelector("#delpro").innerText = "Menghapus...";
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
let rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
setTimeout(function(){
document.querySelector("#delpro").innerText = "Selesai";
},500);
setTimeout(function(){
document.querySelector("#delpro").innerText = "Hapus";
},2000);
setTimeout(function(){
window.location.href = rsp.drc;
},3000);
}else if(rsp.no == true){
document.querySelector("#delpro").innerText = "Hapus";
alert(rsp.msg);
}
}
};
http.send(data);
}
});
document.querySelector("#bth").addEventListener("click",function(){
window.location.href = "/#project";
});
</script>
<?php
}else{
echo 'Not Found!';
}
}
}
?>
<?php
if($_GET['add'] == "edit"){
if($_GET['key'] == "page"){
$page = $_GET['val'];
$data_page = mysqli_query($con,"SELECT * FROM tb_statis WHERE page='$page' ");
if(mysqli_num_rows($data_page) == 1){
$dp = mysqli_fetch_assoc($data_page);
$judul = $dp['judul'];
$deskripsi = $dp['deskripsi'];
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<form id="form_edit_page" data-page="<?=$page;?>" autocomplete="off">
<h5>Edit Page</h5>
<div class="row">
<label for="judul">Judul</label>
<input type="text" name="judul" id="judul" placelholder="Masukkan judul" value="<?=$judul;?>"/>
<div class="error"></div>
</div>
<div class="row">
<label for="deskripsi">Deskripsi</label>
<textarea name="deskripsi" id="deskripsi" placeholder="Masukkan deskripsi"><?=$deskripsi;?></textarea>
<div class="error"></div>
</div>
</div>
<div class="row">
<button type="button" id="bth">Kembali</button>
<button type="submit" name="edit_data_page" id="btn_edit_page">Simpan</button>
</div>
</form>
<script>
let form = document.querySelector("#form_edit_page");
form.addEventListener("submit", editPage);
function editPage(e){
e.preventDefault();
let page = form.getAttribute("data-page"),
judul = document.querySelector("#judul"),
deskripsi = document.querySelector("#deskripsi"),
err = document.querySelectorAll(".error"),
submit = document.querySelector("#btn_edit_page");
for(let i = 0; i < err.length; i++){
err[i].innerText = "";
}
if(page == ""){
alert("Maaf sepertinya ada yang salah, halaman yang dimaksud tidak dapat diedit. Silakan refresh halaman ini dan coba kembali.");
return false;
}else if(judul.value == ""){
judul.focus();
err[0].innerText = "Masukkan judul!";
return false;
}else if(deskripsi.value == ""){
deskripsi.focus();
err[1].innerText = "Masukkan deskripsi!";
return false;
}else{
let data = new FormData();
data.append("page", page);
data.append("judul", judul.value);
data.append("deskripsi", deskripsi.value);
data.append("edit_data_page", submit.value);
let http = new XMLHttpRequest();
http.open("POST", "../../../proses", true);
http.onloadstart = function(){
submit.innerText = "Menyimpan Data...";
}
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
let rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
setTimeout(function(){
submit.innerText = "Selesai";
},500);
setTimeout(function(){
submit.innerText = "Simpan";
},2000);
setTimeout(function(){
window.location.href = rsp.drc;
},3000);
}else if(rsp.no == true){
submit.innerText = "Coba Kembali";
alert(rsp.msg);
}
}
};
http.send(data);
}
}
document.querySelector("#bth").addEventListener("click",function(){
window.location.href = "/";
});
</script>
<?php
}
}else{
echo 'Not Found!';
}
}else{
echo 'Not Found!';
}
}
}
?>
<?php
if($_GET['add'] != "add" && $_GET['add'] != "edit" && $_GET['add'] != "view" || $_GET['key'] != "project" && $_GET['key'] != "new-page" && $_GET['key'] != "new-project" && $_GET['key'] != "page"){
echo 'Not Found!';
}
?>
</body>
</html>
<?php
}else{
?>
<section id="jumbotron">
<figure>
<img src="data/file/img/jumbotron.jpg"/>
<figcaption><span class="txt">I'm Arnadi, i'm a junior web developer, and work as a freelance</span><i class="under">_</i></figcaption>
</figure>
</section>
<section id="about" class="center">
<?php
$data_page = mysqli_query($con,"SELECT * FROM tb_statis WHERE page='about' ");
if(mysqli_num_rows($data_page) == 1){
$dp = mysqli_fetch_assoc($data_page);
if($dp['edit'] != ""){
$edit = " | Terakhir diperbarui: ".$dp['edit'];
}else{
$edit = "";
}
?>
<h2><?=$dp['judul'];?></h2>
<?=html_entity_decode($dp['deskripsi']);?>
<p><small>Diterbitkan pada: <?=$dp['terbit'];?><?=$edit;?></small></p>
<?php
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<p><a href="<?=$base_url.'pg/edit/page/'.$dp['page'];?>" id="btn_update_page">Edit</a> | <a href="#" id="btn_delete_page" data-page="<?=$dp['page'];?>">Hapus</a></p>
<?php
}
}
?>
<script>
document.querySelector("#btn_delete_page").addEventListener("click", deletePage);
function deletePage(e){
e.preventDefault();
if(confirm("Yakin ingin dihapus?") == true){
let data = new FormData();
data.append("data_page", document.querySelector("#btn_delete_page").getAttribute("data-page"));
data.append("delete_data_page", "statis_page");
let http = new XMLHttpRequest();
http.open("POST", "../../proses", true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
let rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
alert(rsp.msg);
window.location.href = rsp.drc;
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
<p style="color:black;font-size:1em;font-style:normal;word-spacing:.03em;text-shadow:none">Not Found!</p>
<?php
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<p><a href="<?=$base_url.'pg/add/new-page/about';?>" style="font-size:1em;font-style:normal;word-spacing:.03em;text-shadow:none">&plus; Add</a></p>
<?php
}
}
}
?>
</section>
<hr>
<section id="project" class="center">
<?php
$data_project = mysqli_query($con,"SELECT * FROM tb_project ORDER BY id DESC");
if(mysqli_num_rows($data_project) > 0){
?>
<h2>Project</h2>
<?php
while($dp = mysqli_fetch_assoc($data_project)){
?>
<figure>
<?php
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<button type="button" id="uppro" data-uppro="up_<?=trim(base64_encode($dp['id']),'=');?>_pro">Edit</button>
<button type="button" id="delpro" data-delpro="del_<?=trim(base64_encode($dp['id']),'=');?>_pro">&times;</button>
<?php
}
}
?>
<img alt="<?=$dp['nama'];?>" data-img="<?=$base_url.'data/file/project/img/'.$dp['screenshot'];?>" src="<?=$base_url.'data/file/project/img/'.$dp['screenshot']?>"/>
<figcaption data-page="<?=$dp['url'];?>"><?=$dp['nama'];?></figcaption>
</figure>
<?php
}
}else{
?>
<p>Not Found!</p>
<?php
}
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<figure id="anp">
<img alt="#" data-img="null" src="#"/>
<figcaption data-page="null">Add New Project</figcaption>
</figure>
<?php
}
}
?>
</section>
<hr>
<section id="contact">
<h2 class="center">Contact</h2>
<form id="kontak" autocomplete="off">
<h5>Hubungi Admin</h5>
<p>Kirim pesan Anda ke admin Atakana.Com</p>
<div class="row">
<label for="email">Email Anda</label>
<input id="email" type="email" name="email" placeholder="Masukkan email Anda"/>
<div class="error"></div>
</div>
<div class="row">
<label for="pesan">Pesan Anda</label>
<textarea id="pesan" name="pesan" placeholder="Tulis pesan Anda"></textarea>
<div class="error"></div>
</div>
<div class="row right">
<button type="reset">Reset</button>
<button id="submit" type="submit" name="submit" value="contact_admin">Kirim</button>
</div>
</form>
</section>
<?php
}
?>
