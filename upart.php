<?php
session_start();
require 'conf.php';
if(!isset($_SESSION['akses'])){
header("Location: ".$base_url."akses/masuk/".trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'='));
exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Data - Upload</title>
<meta name="viewport" content="width=device=width,initial-scale=1,user-scalable=no"/>
<meta name="robots" content="noindex"/>
<style>
* {
box-sizing: border-box;
margin: 0;
}
body {
color: #333;
height: 100%;
font-family: sans-serif;
position: relative;
user-select: none;
-webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
}
.wrapper {
padding: 2.5%;
width: 100%;
}
form {
background-color: white;
border-radius: 3px;
margin: 20px auto;
max-width: 728px;
padding: 20px 5%;
position: relative;
width: 90%;
}
form h5 {
border-bottom: 1px solid rgba(0,0,0,.2);
font-size: 1.3em;
margin-bottom: 15px;
padding-bottom: 10px;
text-align: center;
}
form .row {
margin-bottom: 15px;
position: relative;
}
form label {
display: inline-block;
font-size: .9em;
}
form input, form textarea {
border: 0;
border-radius: 3px;
box-shadow: 0 0 0 1px #aaa;
dispaly: block;
margin: 4px 0;
padding: 10px;
width: 100%;
}
form input:focus, form textarea:focus {
box-shadow: 0 0 0 2px gray;
outline: none;
}
form textarea {
min-height: 200px;
}
form textarea.copy {
background-color: #fafafa;
font-family: Times new roman;
font-style: italic;
letter-spacing: .05em;
line-height: 1.7em;
text-shadow: 1px 1px 1px white, 1px 1px 1px #aaa;
}
form textarea.copy:focus {
box-shadow: 0 0 0 1px #aaa;
}
form textarea.copy h6 {
font-size: .8em;
}
form button {
background-color: #aaa;
border: 0;
border-radius: 3px;
box-shadow: 0 0 0 1px rgba(0,0,0,.5);
margin: 0 10px;
padding: 10px 20px;
transition: all .15s ease-in-out;
}
form button:focus {
box-shadow: none;
color: white;
transform: scale(.9);
}
form button[type=submit] {
background-color: #555;
color: white;
}
form .error {
color: brown;
font-size: .8em;
height: 15px;
line-height: 15px;
}
form .view img {
height: 100%;
width: 100%;
}
.lida {
background-color: #fafafa;
border-radius: 5px;
box-shadow: 0 0 0 1px #eee;
font-size: 90%;
margin: 0 auto;
max-width: 480px;
padding: 30px 2%;
text-align: center;
width: 90%;
}
.lida a {
text-decoration: none;
}
.boxgam {
height: 100%;
margin: 0 auto;
max-width: 728px;
position: relative;
width: 100%
}
.boxgam h1 {
font-size: 1.5em;
margin-bottom: 15px;
}
.boxgam p {
color: #444;
font-size: .85em;
margin-bottom: 20px;
}
.box-gam {
height: 70vh;
overflow: auto;
padding: 0;
position: relative;
text-align: center;
width: 100%;
}
.box-gam .box {
display: inline-block;
height: 100px;
margin: 0 .5% 2%;
max-width: 120px;
overflow: hidden;
position: relative;
width: 31.5%;
}
.box-gam .box .delti {
background-color: rgba(222,222,222,.75);
border-radius: 50%;
box-shadow: 0 0 0 1px maroon;
color: red;
height: 20px;
left: 50%;
line-height: 20px;
position: absolute;
top: 50%;
transform: translate(-50%,-50%);
width: 20px;
}
.box-gam .box .delti:hover {
background-color: brown;
color: white;
}
.box-gam .box img {
height: 100%;
width: 100%;
}
.notpho {
margin-top: 45%;
padding: 0 5%;
text-align: center;
}
.notpho p {
color: #666;
}
</style>
</head>
<body>
<div class="wrapper">

<?php
if(isset($_GET['pegim'])){
if($_GET['pegim'] == strtolower(trim(base64_encode("upload_gambar_artikel"),'='))){

?>
<form autocomplete="off" entype="multipart/form-data" class="form-upload">
<h5>Upload Gambar</h5>
<div class="row">
<label for="nama">Nama Gambar</label>
<input type="text" name="nama" id="nama" placeholder="Masukkan nama gambar" class="nama"/>
<div class="error"></div>
</div>
<div class="row">
<label for="gambar">Pilih Gambar</label>
<input type="file" name="gambar" id="gambar" class="gambar"/>
<div class="error"></div>
</div>
<div class="row" style="margin-top:30px;text-align:center">
<button type="button" class="tutup">Tutup</button>
<button type="submit" name="upload_gambar_artikel" class="upload">Upload</button>
</div>
</form>
<div class="lida">
<p>Gambar yang sudah diupload <a href="<?=$base_url.'files/'.trim(base64_encode('lihat_data_gambar_yang_tersedia'),'=');?>" class="liga">lihat disini</a>.</p>
</div>
<script>
const
form = document.querySelector(".form-upload"),
nama = document.querySelector(".nama"),
gambar = document.querySelector(".gambar"),
error = document.querySelectorAll(".error"),
upload = document.querySelector(".upload");
gambar.addEventListener("change",function(){
const
file = gambar.files[0],
tipe = "\.jpg|\.jpeg|\.png";
if(!file.type.match(tipe)){
error[1].innerText = "Format file yang didukung .jpg/.jpeg/.png";
return false;
}else{
error[1].innerText = "";
}
});
form.addEventListener("submit",function(e){
e.preventDefault();
const
file = gambar.files[0],
tipe = "\.jpg|\.jpeg|\.png";
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(nama.value == ""){
nama.focus();
error[0].innerText = "Masukkan nama gambar!";
return false;
}else if(gambar.value == ""){
gambar.focus();
error[1].innerText = "Harap pilih gambar!";
return false;
}else if(!file.type.match(tipe)){
gambar.focus();
error[1].innerText = "Format file yang didukung .jpg/.jpeg/.png";
return false;
}else{
const data = new FormData();
data.append("nama", nama.value);
data.append("gambar", gambar.files[0]);
data.append("upload_gambar_artikel", upload.value);
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
alert(rsp.msg);
window.open(rsp.drc);
window.close();
}else if(rsp.no == true){
alert(rsp.msg);
}
}
};
http.send(data);
}
});
document.querySelector(".tutup").addEventListener("click",function(){
window.close();
});
const liga = document.querySelector("a.liga");
liga.addEventListener("click",function(){
const target = liga.getAttribute("href");
window.open(target);
window.close();
});
</script>
<?php
}else if($_GET['pegim'] == trim(base64_encode("copas_data_gambar"),'=')){
$getFile = base64_decode($_GET['file']);
$dataim = mysqli_query($con,"SELECT * FROM tb_gam_art WHERE gambar='$getFile' ");
if(mysqli_num_rows($dataim) == 1){
$dt = mysqli_fetch_assoc($dataim);
$nama = $dt['nama'];
$gambar = $dt['gambar'];
?>
<form class="kkg">
<h5>Salin Kode</h5>
<div class="row">
<label for="codaim">Klik area kode untuk menyalin</label>
<textarea readonly id="codaim" class="copy codaim">
<img alt="<?=$nama;?>" loading="lazy" src="<?=$base_url.'data/file/img/'.$gambar;?>" title="<?=$nama;?>"/>
</textarea>
</div>
<div class="view"></div>
</form>
<script>
const
selco = document.querySelector("form.kkg .codaim"),
view = document.querySelector(".view");
view.innerHTML = selco.value;
selco.addEventListener("click",function(){
selco.select();
document.execCommand('copy');
if(window.getSelection){
window.getSelection().removeAllRanges();
}else if(document.selection){
document.selection.empty();
}
alert('TERSALIN\n\nKode gambar berhasil disalin, silakan tempel dibagian area isi posting yang diinginkan.\nTerima kasih.\n\n'+selco.value);
window.close();
});
</script>
<?php
}else{
?>

<?php
}
}else if($_GET['pegim'] == trim(base64_encode("lihat_data_gambar_yang_tersedia"),'=')){
$selAi = mysqli_query($con,"SELECT * FROM tb_gam_art ORDER BY id_gam DESC");
if(mysqli_num_rows($selAi) > 0){
?>
<div class="boxgam">
<h1>Data Gambar</h1>
<p>Silakan klik gambar untuk salin kode, dan tempelkan di area isi posting yang diinginkan.</p>
<div class="box-gam">
<?php
while($sai = mysqli_fetch_assoc($selAi)){
?>
<div class="box">
<span class="delti">&times;</span>
<img title="<?=$sai['nama'];?>" data-ci="<?=trim(base64_encode($sai['gambar']),'=');?>" loading="lazy" src="<?=$base_url.'data/file/img/'.$sai['gambar'];?>" title="<?=$sai['nama'];?>"/>
</div>
<?php
}
?>
</div>
</div>
<script>
const ci = document.querySelectorAll(".box img");
for(let i = 0; i < ci.length; i++){
ci[i].addEventListener("click",function(){
const target = ci[i].getAttribute("data-ci");
const data = new FormData();
data.append("data_ci", target);
data.append("view_ci", "");
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
window.open(rsp.drc);
}
}
};
http.send(data);
});
}
const delti = document.querySelectorAll(".box .delti");
for(let i = 0; i < delti.length; i++){
delti[i].addEventListener("click",function(){
const
confr = confirm("Hapus?"),
img = document.querySelectorAll(".box img"),
target = img[i].getAttribute("data-ci");
if(confr == false){
return false;
}else{
data = new FormData();
data.append("data_ci", target);
data.append("hapus_gambar_target", "");
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
alert(rsp.msg);
window.location.reload();
}else if(rsp.no == true){
alert(rsp.msg);
}
}
};
http.send(data);
}
});
}
</script>
<?php
}else{
?>
<div class="notpho">
<p>Sampai saat ini belum ada satupun gambar yang diupload!</p>
</div>
<?php
}
}
}
?>

</div>
</body>
</html>
