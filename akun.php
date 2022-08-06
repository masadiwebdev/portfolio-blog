<?php
session_start();
require 'conf.php';
if(isset($_SESSION['akses'])){
header("Location: ".$base_url);
exit;
}
$og_title = "";
$og_url = "";
$og_desc = "";
if(isset($_GET['acc'])){
if($_GET['acc'] == "masuk"){
$og_title = "Login Pengguna";
$og_url = $base_url."akses/masuk/";
$og_desc = "Masukkan detail login alamat email dan password Anda.";
}else if($_GET['acc'] == "daftar"){
$og_title = "Registrasi Akun Baru";
$og_url = $base_url."akses/daftar";
$og_desc = "Silakan lengkapi detail formulir registrasi akun baru sesuai petunjuk.";
}else if($_GET['acc'] == "konfirmasi-email"){
$og_title = "Konfirmasi Alamat Email";
$og_url = $base_url."konfirmasi-email";
$og_desc = "Silakan konfirmasi alamat email Anda.";
}else if($_GET['acc'] == trim(strtolower(base64_encode("sandi-baru")),'=')){
$og_title = "Masukkan Password Baru";
$og_url = $base_url."akses/".trim(strtolower(base64_encode("sandi-baru")),'=');
$og_desc = "Silakan masukkan password baru Anda.";
}else{//else get acc
$og_title = "";
$og_url = "";
$og_desc = "";
}
}else{//else isset get acc
$og_title = "";
$og_url = "";
$og_desc = "";
}//tutup isset get acc

?>
<!DOCTYPE html>
<html>
<head>
<title><?=$og_title;?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no"/>
<meta name="theme-color" content="white"/>
<meta name="robots" content="index"/>
<meta property="og:title" content="<?=$og_title;?>"/>
<meta property="og:url" content="<?=$og_url;?>"/>
<meta property="og:description" content="<?=$og_desc;?>"/>
<meta property="og:image" content="<?=$base_url.'f/g/logo.png';?>"/>
<meta property="og:type" content="website"/>
<link rel="icon" type="image/png" href="<?=$base_url.'f/g/icon.png';?>"/>
<style>
* {
box-sizing: border-box;
margin: 0;
}
body {
background-color: white;
color: #555;
font-family: sans-serif;
font-size: 16px;
min-height: 100%;
position: relative;
user-select: none;
-webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
width: 100%;
}
.container {
background-color: transparent;
height: 100%;
margin: 0 auto;
max-width: 480px;
min-height: 92vh;
width: 100%;
}
.inver {
background-color: transparent;
bottom: 0;
left: 0;
opacity: 0;
position: absolute;
right: 0;
top: 0;
transition: all .5s ease-in-out;
z-index: -1;
}
.inver.show {
opacity: 1;
z-index: 100;
}
.inver .btn-close {
background-color: transparent;
height: 25px;
margin: 20px auto 0;
max-width: 480px;
position: relative;
width: 90%;
z-index: 20;
}
.inver .btn-close .close {
color: gray;
cursor: pointer;
font-weight: 400;
height: 25px;
line-height: 25px;
position: absolute;
right: 3px;
text-align: center;
top: 3px;
transition: all .25s ease-in-out;
width: 25px;
}
.inver .btn-close .close:hover {
color: brown;
font-weight: 700;
}
.inver .info {
background-color: white;
border-radius: 3px;
box-shadow: 0 0 1px 2px rgba(0,0,0,.2);
margin: -25px auto 0;
max-width: 480px;
padding: 40px 6.5% 30px;
position: relative;
text-align: justify;
width: 90%;
z-index: 9;
}
.inver .info p {
color: #333;
font-size: .8em;
line-height: 1.35em;
margin-bottom: 15px;
}
.abs-cen {
background-color: white;
border-radius: 3px;
max-height: 90%;
left: 50%;
max-width: 480px;
overflow: scroll;
padding: 20px 10px 0;
position: absolute;
top: 40%;
transform: translate(-50%, -40%);
width: 92.5%;
}
.abs-cen::-webkit-scrollbar {
display: none;
}
.abs-cen form {
background-color: white;
padding: 20px 0;
text-align: center;
width: 100%;
}
.abs-cen .title {
margin-bottom: 50px;
}
.abs-cen form .title h5 {
color: #333;
font-size: 1.1em;
margin-bottom: 10px;
text-transform: uppercase;
}
.abs-cen form .title p {
color: #777;
font-size: .85em;
}
.abs-cen form .row {
margin-bottom: 10px;
position: relative;
}
.abs-cen form label {
color: #333;
display: inline-block;
margin-bottom: 5px;
padding: 0;
text-align: left;
width: 95%;
}
.abs-cen form input {
background-color: white;
border: 0;
border-radius: 3px;
box-shadow: 0 0 0 2px rgba(0,0,0,.25);
margin-bottom: 5px;
padding: 15px 10px;
width: 95%;
}
.abs-cen form input[type=file] {
padding: 13px;
}
.abs-cen form input:focus {
box-shadow: 0 0 0 1px rgba(30,144,255,.8), 0 0 0 5px rgba(30,144,255,.2);
outline: none;
}
.abs-cen form .view {
background-color: white;
border-left: 1px solid #ccc;
border-radius: 0 5px 5px 0;
color: black;
font-size: 85%;
height: 45.75px;
line-height: 45.75px;
position: absolute;
right: 5%;
text-align: center;
top: 24px;
width: 50px;
}
.abs-cen form .view.clicked {
color: red;
}
.abs-cen form .error {
color: brown;
font-size: 80%;
height: 20px;
line-height: 20px;
margin: auto;
text-align: left;
width: 95%;
}
.abs-cen form button {
background-color: rgba(30,144,255,.85);
border: 0;
border-radius: 3px;
box-shadow: 3px 5px 10px #eee;
color: white;
font-size: 1.1em;
font-weight: 500;
height: 45px;
line-height: 45px;
max-width: 200px;
padding: 0;
text-transform: uppercase;
transform: scale(1);
transition: all .25s ease-in-out;
width: 100%;
}
.abs-cen form button:hover {
box-shadow: 1px 1px 1px 1px rgba(0,0,0,.25);
transform: scale(.95);
}
.abs-cen form .row.form-link {
margin: 50px auto;
}
.abs-cen form .row.form-link p {
margin-bottom: 15px;
}
.abs-cen form .row.form-link span.link {
color: darkblue;
font-size: .8em;
}
.abs-cen form .row.form-link span.link:hover {
color: red;
}
</style>
</head>
<body>

<div class="container">

<?php
if(isset($_GET['acc'])){
if($_GET['acc'] == "masuk"){
if(isset($_GET['x'])){
$_SESSION['uri_ref'] = $_GET['x'];
$proses = "../../proses";
}else{
$proses = "../proses";
}
?>
<style>
.abs-cen .nonaktif {
background-color: #ddd;
border-radius: 5px;
box-shadow: 0 0 0 1px gray, 2px 3px 3px gray;
color: maroon;
font-size: .85em;
height: auto;
left: 50%;
max-width: 480px;
opacity: 0;
padding: 50px 5%;
position: absolute;
top: -100%;
transform: translate(-50%,0);
transition: all 1s ease-in-out;
width: 95%;
z-index: 100;
}
.abs-cen .nonaktif.show {
opacity: 1;
top: 30px;
}
.abs-cen .cls {
color: gray;
cursor: pointer;
font-size: 1.1em;
height: 15px;
line-height: 15px;
position: absolute;
right: 7px;
text-align: center;
top: 7px;
width: 15px;
}
.abs-cen .cls:hover {
color: red;
font-weight: 500;
}
.abs-cen .nonaktif .msg {
line-height: 1.5em;
}
.abs-cen .nonaktif .eml {
margin: 15px 0;
}
.abs-cen .nonaktif .eml a {
background-color: dodgerblue;
border-radius: 3px;
box-shadow: 1px 1px 3px gray;
color: white;
display: inline-block;
font-size: .9em;
height: 25px;
line-height: 25px;
padding: 0 10px;
text-decoration: none;
}
.abs-cen .nonaktif .eml a:hover {
box-shadow: none;
}
</style>
<div class="abs-cen">
<form data-target="<?=$proses;?>" autocomplete="off" class="form-masuk">
<div class="nonaktif">
<span class="cls">&times;</span>
<p class="msg">Maaf akun Anda belum aktif!<br>Silakan periksa link aktivasi yang dikirimkan sebelumnya di kotak masuk atau bagian spam email Anda.</p>
<p class="eml"><a href="#">Permintaan Ulang Link Aktivasi</a></p>
<p class="trim">Terima Kasih.</p>
</div>
<div class="title">
<h5>Login Pengguna</h5>
<p>Masukkan Email &amp; Password Anda</p>
</div>
<div class="row">
<label for="email">Alamat Email</label>
<input type="email" name="email" id="email" placeholder="Masukkan alamat email" class="email"/>
<div class="error"></div>
</div>
<div class="row">
<label for="sandi">Password</label>
<input type="password" name="sandi" id="sandi" placeholder="Masukkan password" class="sandi"/>
<div class="view">✓</div>
<div class="error"></div>
</div>
<div class="row" style="margin-top:30px">
<button type="submit" name="akses_masuk" class="akses-masuk">Login</button>
</div>
<div class="row form-link">
<p><span gts="<?=$base_url.'akses/konfirmasi-email';?>" class="link ganti-sandi">Lupa password?</span></p>
<p><span dft="<?=$base_url.'akses/daftar';?>" class="link buat-akun">Belum punya akun? Registrasi sekarang</span></p>
<p><span class="link batal-masuk">Beranda</span></p>
</div>
</form>
</div>
<script>
const masuk = document.querySelector(".form-masuk");
const visan = document.querySelector(".row .view");
visan.addEventListener("click",function(){
const kon = document.querySelector(".sandi");
if(kon.getAttribute("type") == "password"){
kon.setAttribute("type","text");
visan.classList.add("clicked");
visan.innerText = "X";
}else if(kon.getAttribute("type") == "text"){
kon.setAttribute("type","password");
visan.classList.remove("clicked");
visan.innerText = "✓";
}
});
masuk.addEventListener("submit",function(e){
e.preventDefault();
const proses = masuk.getAttribute("data-target");
const email = document.querySelector(".email");
const sandi = document.querySelector(".sandi");
const akses = document.querySelector(".akses-masuk");
const error = document.querySelectorAll(".error");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(email.value == ""){
email.focus();
error[0].innerText = "Harap masukkan alamat email Anda!";
return false;
}else if(sandi.value == ""){
sandi.focus();
error[1].innerText = "Harap massukkan password";
return false;
}else{
const data = new FormData();
data.append("email", email.value);
data.append("sandi", sandi.value);
data.append("akses_masuk", akses.value);
const http = new XMLHttpRequest();
http.open("POST",proses,true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.noem == true){
email.focus();
error[0].innerText = rsp.msg;
}else if(rsp.nosan == true){
sandi.focus();
error[1].innerText = rsp.msg;
}else if(rsp.no == true){
alert(rsp.msg);
}else if(rsp.noact == true){
email.blur();
sandi.blur();
const
nonaktif = document.querySelector(".nonaktif"),
cls = document.querySelector(".cls"),
eml = document.querySelector(".eml a");
nonaktif.classList.add("show");
eml.setAttribute("href",rsp.eml);
eml.onclick = function(e){
e.preventDefault();
if(rsp.eml == ""){
alert("Maaf terjadi kesalah!\nCoba tutup popup dan masuk kembali.\n\nTerima kasih.");
}else{
const data = new FormData();
data.append("target",eml.getAttribute("href"));
data.append("kirim_ulang_aktivasi_akun","");
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
alert(rsp.msg);
nonaktif.classList.remove("show");
}else if(rsp.no == true){
alert(rsp.msg);
}
}
};
http.send(data);
}
}
cls.onclick = function(){
nonaktif.classList.remove("show");
}
}else if(rsp.yes == true){
window.location.href = rsp.drc;
}
}
};
http.send(data);
}
});
const ganti_sandi = document.querySelector(".link.ganti-sandi");
ganti_sandi.addEventListener("click",function(){
const gts = ganti_sandi.getAttribute("gts");
window.location.href = gts;
});
const buat_akun = document.querySelector(".link.buat-akun");
buat_akun.addEventListener("click",function(){
const dft = buat_akun.getAttribute("dft");
window.location.href = dft;
});
document.querySelector(".link.batal-masuk").addEventListener("click",function(){
window.location.href = "<?=$base_url?>artikel/beranda";
});
</script>
<?php
}else if($_GET['acc'] == "daftar"){
?>
<div class="abs-cen">
<form autocomplete="off" enctype="multipart/form-data" class="form-daftar">
<div class="title">
<h5>Registrasi Akun Baru</h5>
<p>Masukkan Detail Data Formulir Pendaftaran</p>
</div>
<div class="row">
<label for="nama">Nama Anda</label>
<input type="text" name="nama" id="nama" placeholder="Masukkan nama Anda" class="nama"/>
<div class="error"></div>
</div>
<div class="row">
<label for="email">Alamat Email</label>
<input type="email" name="email" id="email" placeholder="Masukkan alamat email" class="email"/>
<div class="error"></div>
</div>
<div class="row">
<label for="sandi">Password</label>
<input type="password" name="sandi" id="sandi" placeholder="Masukkan password" class="sandi"/>
<div class="view">✓</div>
<div class="error"></div>
</div>
<div class="row">
<label for="konfirmasi">Konfirmasi Password</label>
<input type="password" name="konfirmasi" id="konfirmasi" placeholder="Masukkan konfirmasi password" class="konfirmasi"/>
<div class="view">✓</div>
<div class="error"></div>
</div>
<div class="row">
<label for="profil">Gambar Profil</label>
<input type="file" name="profil" id="profil" class="profil"/>
<div class="error"></div>
</div>
<div class="row" style="margin-top:30px">
<button type="submit" name="buat_akun" class="buat-akun">Registrasi</button>
</div>
<div class="row form-link">
<p><span msk="<?=$base_url."akses/masuk";?>" class="link masuk-akun">Sudah punya akun? Login sekarang</span></p>
<p><span class="link batal-buat">Beranda</span></p>
</div>
</form>
</div>
<script>
const
form = document.querySelector(".form-daftar"),
visan = document.querySelectorAll(".row .view"),
profil = document.querySelector(".profil");
visan[0].addEventListener("click",function(){
const kon = document.querySelector(".sandi");
if(kon.getAttribute("type") == "password"){
kon.setAttribute("type","text");
visan[0].classList.add("clicked");
visan[0].innerText = "X";
}else if(kon.getAttribute("type") == "text"){
kon.setAttribute("type","password");
visan[0].classList.remove("clicked");
visan[0].innerText = "✓";
}
});
visan[1].addEventListener("click",function(){
const kon = document.querySelector(".konfirmasi");
if(kon.getAttribute("type") == "password"){
kon.setAttribute("type","text");
visan[1].classList.add("clicked");
visan[1].innerText = "X";
}else if(kon.getAttribute("type") == "text"){
kon.setAttribute("type","password");
visan[1].classList.remove("clicked");
visan[1].innerText = "✓";
}
});
profil.addEventListener("change",function(){
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
});
form.addEventListener("submit",function(e){
e.preventDefault();
const
nama = document.querySelector(".nama"),
email = document.querySelector(".email"),
sandi = document.querySelector(".sandi"),
konfirmasi = document.querySelector(".konfirmasi"),
profil = document.querySelector(".profil"),
buat_akun = document.querySelector(".buat-akun"),
error = document.querySelectorAll(".error"),
bsr = /[A-Z]/g,
nmr = /[0-9]/g;
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
if(nama.value == ""){
nama.focus();
error[0].innerText = "Nama Anda tidak boleh kosong!";
return false;
}else if(email.value == ""){
email.focus();
error[1].innerText = "Alamat email tidak boleh kosong!";
return false;
}else if(sandi.value == ""){
sandi.focus();
error[2].innerText = "Password tidak boleh kosong!";
return false;
}else if(!sandi.value.match(bsr)){
sandi.focus();
error[2].innerText = "Minimal terdapat 1 huruf kapital!";
return false;
}else if(!sandi.value.match(nmr)){
sandi.focus();
error[2].innerText = "Minimal terdapat 1 angka!";
return false;
}else if(sandi.value.length < 6){
sandi.focus();
error[2].innerText = "Minimal password 6 karakter!";
return false;
}else if(sandi.value.length > 10){
sandi.focus();
error[2].innerText = "Maksimal password 10 karakter!";
return false;
}else if(konfirmasi.value == ""){
konfirmasi.focus();
error[3].innerText = "Konfirmasi password tidak boleh kosong!";
return false;
}else if(sandi.value != konfirmasi.value){
konfirmasi.focus();
error[3].innerText = "Konfirmasi password tidak cocok!";
return false;
}else if(profil.value == ""){
profil.focus();
error[4].innerText = "Harap pilih gambar profil!";
return false;
}else{
const data = new FormData();
data.append("nama", nama.value);
data.append("email", email.value);
data.append("sandi", sandi.value);
data.append("profil", profil.files[0]);
data.append("buat_akun", buat_akun.value);
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
window.location.href = rsp.drc;
}else if(rsp.no == true){
alert(rsp.msg);
}
}
};
http.send(data);
}
});
const masak = document.querySelector(".link.masuk-akun");
masak.addEventListener("click",function(){
const msk = masak.getAttribute("msk");
window.location.href = msk;
});
document.querySelector(".link.batal-buat").addEventListener("click",function(){
window.location.href = "<?=$base_url?>artikel/beranda";
});
</script>
<?php
}else if($_GET['acc'] == trim(base64_encode("notif-sukses"),'=')){
?>
<div class="inver">
<?php
if(isset($_SESSION['sc'])){
?>
<div style="margin-top:50px" class="info"><?=$_SESSION['sc'];?><p style="margin-top:50px">Halaman ini akan ditutup otomatis dalam hitungan</p><p style="font-size:200%;font-weight:bold;text-align:center" ref="<?=$base_url;?>" class="int">30</p></div>
<?php
}else{
?>
<script>window.location.href = "<?=$base_url;?>artikel/beranda";</script>
<?php
}
?>
</div>
<script>
const
inver = document.querySelector(".inver"),
int = document.querySelector(".int"),
ref = int.getAttribute("ref");
inver.classList.add("show");
let i = 30;
setInterval(function(){
int.innerText = i--;
if(i > 9){
int.innerText = i;
}
if(i < 10 && i >= 0){
int.innerText = "0"+i;
}
if(i <= 0){
int.innerText = "00";
window.location.href = ref;
clearInterval();
}
},1000);
</script>
<?php
}else if($_GET['acc'] == trim(strtolower(base64_encode("aktivasi-akun-baru")),'=')){
$email = base64_decode($_GET['x']);
?>
<div class="inver">
<div class="btn-close"><span class="close">&times;</span></div>
<div class="info"></div>
</div>
<form class="form-aktivasi">
<input type="hidden" name="email" value="<?=$email;?>" class="email"/>
<input type="hidden" name="aktivasi_akun_baru" value="" class="aktivasi-akun-baru"/>
</form>
<script>
const
inver = document.querySelector(".inver"),
inclose = document.querySelector(".btn-close .close"),
notif = document.querySelector(".inver .info"),
email = document.querySelector(".form-aktivasi .email").value;
const aab = document.querySelector(".form-aktivasi .aktivasi-akun-baru").value;
const data = new FormData();
data.append("email", email);
data.append("aktivasi_akun_baru", aab);
const http = new XMLHttpRequest();
http.open("POST","../../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
inver.classList.add("show");
notif.innerHTML = rsp.msg;
inclose.classList.remove("show");
}else if(rsp.aktif == true){
inver.classList.adf("show");
notif.innerHTML = rsp.msg;
inclose.classList.remove("show");
}else if(rsp.no == true){
alert(rsp.msg);
}
}
};
http.send(data);
</script>
<?php
}else if($_GET['acc'] == "konfirmasi-email"){
?>
<div class="inver">
<div class="btn-close"><span class="close">&times;</span></div>
<div class="info"></div>
</div>
<div class="abs-cen">
<form autocomplete="off" class="form-konfirmasi-email">
<div class="title">
<h5>Konfirmasi Email</h5>
<p>Masukkan Alamat Email Konfirmasi</p>
</div>
<div class="row">
<label for="email">Alamat Email</label>
<input type="email" name="email" id="email" placeholder="Masukkan email Anda" class="email"/>
<div class="error"></div>
</div>
<div class="row" style="margin:30px auto">
<button type="submit" name="konfirmasi_email" class="konfirmasi-email">Konfirmasi</button>
</div>
<div class="row form-link">
<p><span class="link kembali">Kembali</span></p>
</div>
</form>
</div>
<script>
const fke = document.querySelector(".form-konfirmasi-email");
fke.addEventListener("submit",function(e){
e.preventDefault();
const
inver = document.querySelector(".inver"),
inclose = document.querySelector(".btn-close .close"),
info = document.querySelector(".inver .info");
info.innerHTML = "";
const email = document.querySelector(".email");
const koem = document.querySelector(".konfirmasi-email");
const error = document.querySelector(".error");
error.innerText = "";
if(email.value == ""){
email.focus();
error.innerText = "Masukkan alamat email konfirmasi!";
return false;
}else{
const data = new FormData();
data.append("email", email.value);
data.append("konfirmasi_email", koem.value);
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
email.blur();
inver.classList.add("show");
info.innerHTML = rsp.msg;
inclose.onclick = function(){
inver.classList.remove("show");
}
}else if(rsp.no == true){
email.focus();
error.innerText = rsp.msg;
}
}
};
http.send(data);
}
});
document.querySelector(".link.kembali").onclick = function() {
window.history.back();
}
</script>
<?php
}else if($_GET['acc'] == trim(strtolower(base64_encode("sandi-baru")),'=')){
?>
<div class="inver">
<div class="btn-close"><span class="close">&times;</span></div>
<div class="info"></div>
</div>
<div class="abs-cen">
<form autocomplete="off" class="form-sandi-baru">
<div class="title">
<h5>Password Baru</h5>
<p>Masukkan Password Baru &amp; Konfirmasi</p>
</div>
<input type="hidden" name="email" value="<?=$_SESSION['ek'];?>" class="email"/>
<div class="row">
<label for="sandi">Password Baru</label>
<input type="password" name="sandi" id="sandi" placeholder="Password baru" class="sandi"/>
<div class="view">✓</div>
<div class="error"></div>
</div>
<div class="row">
<label for="konfirmasi">Konfirmasi Password Baru</label>
<input type="password" name="konfirmasi_sandi" id="konfirmasi" placeholder="Konfirmasi password" class="konfirmasi-sandi"/>
<div class="view">✓</div>
<div class="error"></div>
</div>
<div class="row" style="margin:30px auto">
<button type="submit" name="simpan_sandi_baru" class="simpan-sandi-baru">Simpan</button>
</div>
<div class="row form-link">
<p><span class="link kembali">Kembali</span></p>
</div>
</form>
</div>
<script>
const fsb = document.querySelector(".form-sandi-baru");
const visan = document.querySelectorAll(".row .view");
visan[0].addEventListener("click",function(){
const san = document.querySelector(".sandi");
if(san.getAttribute("type") == "password"){
san.setAttribute("type","text");
visan[0].classList.add("clicked");
visan[0].innerText = "X";
}else if(san.getAttribute("type") == "text"){
san.setAttribute("type","password");
visan[0].classList.remove("clicked");
visan[0].innerText = "✓";
}
});
visan[1].addEventListener("click",function(){
const kon = document.querySelector(".konfirmasi-sandi");
if(kon.getAttribute("type") == "password"){
kon.setAttribute("type","text");
visan[1].classList.add("clicked");
visan[1].innerText = "X";
}else if(kon.getAttribute("type") == "text"){
kon.setAttribute("type","password");
visan[1].classList.remove("clicked");
visan[1].innerText = "✓";
}
});
fsb.addEventListener("submit",function(e){
e.preventDefault();
const
inver = document.querySelector(".inver"),
inclose = document.querySelector(".btn-close .close"),
info = document.querySelector(".inver .info");
//inver.classList.add("show");
info.innerHTML = "";
const email = document.querySelector(".email");
const sandi = document.querySelector(".sandi");
const kosan = document.querySelector(".konfirmasi-sandi");
const sisan = document.querySelector(".simpan-sandi-baru");
const error = document.querySelectorAll(".error");
for(let i = 0; i < error.length; i++){
error[i].innerText = "";
}
const bsr = /[A-Z]/g;
const nmr = /[0-9]/g;
if(sandi.value == ""){
sandi.focus();
error[0].innerText = "Masukkan password baru!";
return false;
}else if(!sandi.value.match(bsr)){
sandi.focus();
error[0].innerText = "Minimal terdapat 1 huruf kapital!";
return false;
}else if(!sandi.value.match(nmr)){
sandi.focus();
error[0].innerText = "Minimal terdapat 1 angka!";
return false;
}else if(sandi.value.length < 6){
sandi.focus();
error[0].innerText = "Minimal password 6 karakter!";
return false;
}else if(sandi.value.length > 10){
sandi.focus();
error[0].innerText = "Maksimal password 10 karakter!";
return false;
}else if(kosan.value == ""){
kosan.focus();
error[1].innerText = "Masukkan konfirmasi password!";
return false;
}else if(sandi.value != kosan.value){
kosan.focus();
error[1].innerText = "Konfirmasi password tidak cocok!";
return false;
}else{
const data = new FormData();
data.append("email", email.value);
data.append("sandi", sandi.value);
data.append("simpan_sandi_baru", sisan.value);
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
window.location.href = rsp.drc;
}else if(rsp.no == true){
alert(rsp.msg);
}else if(rsp.noses == true){
sandi.blur();
kosan.blur();
inver.classList.add("show");
info.innerHTML = rsp.msg;
inclose.onclick = function(){
inver.classList.remove("show");
}
}
}
};
http.send(data);
}
});
document.querySelector(".link.kembali").onclick = function(){
window.history.back();
}
</script>
<?php
}
}
?>

</div>

<script>

</script>
</body>
</html>
