<?php
require 'conf.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Halaman Report</title>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no/">
<style>
* {
box-sizing: border-box;
margin: 0;
padding: 0;
}
body {
font-family: sans-serif;
font-size: 14px;
min-height: 100vh;
position: relative;
width: 100%;
}
header {
background-color: rgba(0,0,0,.75);
box-shadow: 0 5px 10px rgba(0,0,0,.25);
height: 40px;
line-height: 40px;
position: relative;
}
header h1 {
color: rgba(222,222,222);
font-size: 1.25em;
text-align: center;
}
main {
border-radius: 5px;
box-shadow: 0 0 0 1px rgba(0,0,0,.1), 2px 5px 10px rgba(0,0,0,.25);
min-height: 100%;
margin: 30px auto;
padding: 20px;
position: relative;
width: 95%;
}
article img {
border: 1px solid #ccc;
display: block;
margin: 20px auto;
width: 100%;
}
article p {
line-height: 1.35em;
margin: 15px 0;
}
footer {
background-color: transparent;
height: 50px;
line-height: 50px;
position: relative;
text-align: center;
width: 100%;
}
footer p {
color: rgba(0,0,0,.5);
font-size: .8em;
}
.row {
margin: 20px 0;
text-align: center;
}
.row.my {
margin: 50px 0;
}
.row button {
background-color: rgba(0,0,0,.15);
border: 0;
border-radius: 3px;
box-shadow: 0 0 0 1px rgba(0,0,0,.35), 3px 3px 10px rgba(0,0,0,.2);
height: 30px;
line-height; 30px;
margin: 0 5px;
padding: 0 13px;
transition: all .15s ease-in-out;
}
.row button:hover {
box-shadow: 0 0 0 1px rgba(0,0,0,.5);
transform: scale(.9);
}
.row button.hakon {
background-color: brown;
color: white;
}
@media(max-width: 768px){

}
</style>
</head>
<body>

<header>
<h1>Halaman Report</h1>
</header>

<main>

<article>
<?php
$x = base64_decode($_GET['rpr']);
$xx = explode('_',$x);
$id = $xx[0];
$email = $xx[1];
$slug = $xx[2];
$dataReport = mysqli_query($con,"SELECT * FROM tb_art_rpr WHERE id_rpr='$id' AND slug_rpr='$slug' AND email_rpr='$email' ");
if(mysqli_num_rows($dataReport) == 1){
$dataPost = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
if(mysqli_num_rows($dataPost) == 1){
$dr = mysqli_fetch_assoc($dataReport);
$pesan = $dr['pesan_rpr'];
$layar = $base_url."f/g/".$dr['layar_rpr'];
$dp = mysqli_fetch_assoc($dataPost);
$judul = $dp['judul_art'];
$sampul = $base_url."files/images/".$dp['sampul_art'];
$ringkasan = substr(str_replace("<"," ",str_replace(">"," ",str_replace("&lt;","",str_replace("&gt;","",str_replace("<p>","",str_replace("</p>","<br>",$dp['isi_art'])))))),0,255);
$kategori = $dp['kategori_art'];
$diterbitkan = $dp['terbit_art'];
$penulis = $dp['penulis_art'];
$imel = $dp['email_art'];
?>
<h1>Konten Bermasalah</h1>
<p>Pengirim: <?=$email;?></p>
<p>Pesan: <?=$pesan;?></p>
<a href="<?=$layar;?>" target="_blank"><img alt="<?="Tangkap Layar - ".$judul;?>" src="<?=$layar;?>"/></a>
<h2><?=$judul;?></h2>
<img alt="<?="Sampul - ".$judul;?>" src="<?=$sampul;?>"/>
<p>Ringkasan: <?=$ringkasan;?></p>
<p>Kategori: <?=$kategori;?></p>
<p>Diterbitkan: <?=$diterbitkan;?></p>
<p>Penulis: <?=$penulis;?></p>
<p>Email: <?=$imel;?></p>
<div class="row my">
<button type="button" data-hps="<?=trim(base64_encode($slug),'=');?>" class="hakon">Hapus Konten</button>
</div>
<?php
}else{
?>
<div class="noda">
<h5>Tidak Ditemukan!</h5>
<p>Konten terkait tidak tersedia, mungkin sudah dihapus oleh pemiliknya.</p>
</div>
<?php
}
}else{
?>
<div class="noda">
<h5>Tidak Ditemukan!</h5>
<p>Data yang dimaksud tidak tersedia, mungkin sudah dihapus atau bisa jadi url salah.</p>
</div>
<?php
}
?>
</article>

</main>

<footer>
<p>By Atakana.Com</p>
</footer>

<script>
if(document.querySelector(".hakon") != null){
const hps = document.querySelector(".hakon");
hps.addEventListener("click",function(){
if(confirm("Hapus konten?") == true){
const tg = hps.getAttribute("data-hps");
const data = new FormData();
data.append("url", atob(tg));
data.append("hapus_artikel", "");
const http = new XMLHttpRequest();
http.open("POST","../proses",true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
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
});
}
</script>
</body>
</html>
