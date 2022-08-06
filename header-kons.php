<?php
session_start();
require 'conf.php';
$ogTitle = "";
$ogUrl = "";
$ogDescription = "";
$ogImage = "";
$ogKeyword = "";
$ogAuthor = "";
if(isset($_GET['publik'])){
$getSlugArt = $_GET['publik'];
$dataArtikel = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$getSlugArt' ");
if(mysqli_num_rows($dataArtikel) == 1){
$da = mysqli_fetch_assoc($dataArtikel);
$ogTitle = $da['judul_art'];
$ogUrl = $base_url."artikel/".$da['slug_art'];
$ogDescription = $da['deskripsi_art'].", ".$da['kategori_art'].".";
$ogKeyword = $da['kategori_art'].", ".str_replace(' ',', ',$da['judul_art']." ".$da['deskripsi_art']);
$ogAuthor = $da['penulis_art'];
if(!empty($da['sampul_art'])){
$ogImage = $base_url."files/images/".$da['sampul_art'];
}else{
$ogImage = $base_url."f/g/no-image.png";
}
}else{
$selData = mysqli_query($con,"SELECT * FROM tb_web_bas");
if(mysqli_num_rows($selData)){
$dt = mysqli_fetch_assoc($selData);
$ogTitle = "Beranda - ".html_entity_decode($dt['nama_web']);
$ogUrl = $base_url."artikel/beranda";
$ogDescription = html_entity_decode($dt['deskripsi_web']);
$ogImage = $base_url."f/g/icon.png";
$ogKeyword = "atakana, atakana.com, web atakana, blog atakana, web blog atakana, web blog atakana.com, artikel atakana.com";
$ogAuthor = "Arnadi";
}
}
}else if(isset($_GET['s']) && isset($_GET['e'])){
$slug = base64_decode($_GET['s']);
$selData = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' ");
if(mysqli_num_rows($selData) == 1){
$dt = mysqli_fetch_assoc($selData);
$ogTitle = "Preview - ".$dt['judul_art'];
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$ogTitle;?></title>
<meta charset="UTF-8">
<meta name="description" content="<?=$ogDescription;?>"/>
<meta name="keywords" content="<?=$ogKeyword;?>"/>
<meta name="author" content="<?=$ogAuthor;?>"/>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no"/>
<meta name="theme-color" content="white"/>
<meta property="og:title" content="<?=$ogTitle;?>"/>
<meta property="og:url" content="<?=$ogUrl;?>"/>
<meta property="og:description" content="<?=$ogDescription;?>"/>
<meta property="og:image" content="<?=$ogImage;?>"/>
<meta property="og:type" content="website"/>
<link rel="canonical" href="<?=$ogUrl;?>"/>
<link rel="icon" type="image/png" href="<?=$base_url.'f/g/icon.png';?>"/>
<style><?php if(isset($_GET['publik']) || isset($_GET['s'])){$getPub="";if(isset($_GET['publik'])){$getPub=$_GET['publik'];$selDart=mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$getPub'");}else if(isset($_GET['s'])){$getPub=base64_decode($_GET['s']);$selDart=mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$getPub'");}if(mysqli_num_rows($selDart)==1){$sar=mysqli_fetch_assoc($selDart);$em=$sar['email_art'];$selPro=mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE email='$em' ");if(mysqli_num_rows($selPro)==1){$sp=mysqli_fetch_assoc($selPro);if(!empty($sp['profil'])){$bip=$base_url."f/g/".$sp['profil'];}else{$bip=$base_url."f/g/no-profile.png";}}else{$bip=$base_url."f/g/no-profile.png";}}else{$bip=$base_url."f/g/no-profile.png";}}else{$bip=$base_url."f/g/no-profile.png";}?>.card-img .imp .img, .post .cover .imp .img{background:white url('<?=$bip;?>');}</style>
<link rel="stylesheet" href="<?=$base_url.'f/s/css/style.css?version='.filemtime('f/s/css/style.css');?>">
<script src="<?=$base_url.'f/s/js/slr.js?version='.filemtime('f/s/js/slr.js');?>"></script>
</head>
<body load="<?php if(!isset($_SESSION['akses'])){echo trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=');}else{echo "loaded";}?>">
<?php
if(isset($_GET['s']) && isset($_GET['e'])){
?>
<div class="preview-post"><div class="block-post"></div></div>
<?php
}
?>
<div class="loadani"><div class="loader"></div></div>
<?php
if(isset($_GET['publik'])){
if($_GET['publik'] != "beranda"){
?>
<div class="krisbox">
<form autocomplete="off" class="fks">
<span class="cls">&times;</span>
<h5>Sampaikan Kritik &amp; Saran Anda</h5>
<div class="row">
<label for="pilkrisan">Kepada</label>
<select name="pilkrisan" id="pilkrisan" class="pilkrisan">
<option disabled selected value="">Pilih Satu</option>
<option value="post">Penulis</option>
<option value="web">Pengembang</option>
</select>
<div class="err">Harap pilih salah satu!</div>
</div>
<div class="row">
<label for="email">Email</label>
<input type="email" name="email" id="email" placeholder="Masukkan email Anda" class="eml"/>
<div class="err">Masukkan email Anda!</div>
</div>
<div class="row">
<label for="msg">Kritik &amp; Saran</label>
<textarea name="msg" id="msg" placeholder="Masukkan kritik & saran" class="msg"></textarea>
<input type="hidden" name="target" value="<?=rtrim(base64_encode($_GET['publik']),'=');?>" class="target"/>
<div class="err">Masukkan kritik &amp; saran Anda!</div>
</div>
<div class="row ctr">
<button type="submit" name="subkrisan" class="subkrisan">Kirim</button>
</div>
</form>
</div>
<div class="rebox">
<form autocomplete="off" enctype="multipart/form-data" class="frp">
<span class="cls">&times;</span>
<h5>Laporkan Konten Bermasalah</h5>
<div class="row">
<label for="email">Email Anda</label>
<input type="email" name="email" id="email" placeholder="Masukkan email Anda" class="eml"/>
<div class="err">Masukkan email Anda!</div>
</div>
<div class="row">
<label for="msg">Masalah Konten</label>
<textarea name="msg" id="msg" placeholder="Ceritakan masalah konten" class="msg"></textarea>
<div class="err">Ceritakan permasalah pada konten!</div>
</div>
<div class="row">
<label for="sst">Tangkap Layar</label>
<input type="file" name="sst" id="sst" class="sst"/>
<input type="hidden" name="target" value="<?=rtrim(base64_encode($_GET['publik']),'=');?>" class="target"/>
<div class="err">Pilih gambar / format yang didukung .jpg, .jpeg, .png</div>
</div>
<div class="row ctr">
<button type="submit" name="lapkon" class="lapkon">Laporkan</button>
</div>
</form>
</div>
<?php
}
}
?>
<div class="wrapper">
<?php
if(isset($_GET['publik']) || isset($_GET['s']) && isset($_GET['e'])){
$selWeb = mysqli_query($con,"SELECT * FROM tb_web_bas");
if(mysqli_num_rows($selWeb) == 1){
$sw = mysqli_fetch_assoc($selWeb);
$namaWeb = $sw['nama_web'];
$deskripsiWeb = $sw['deskripsi_web'];
}else{
$namaWeb = "Belum Ada Nama";
$deskripsiWeb = "Belum Ada Deskripsi";
}
}else{
$namaWeb = "Get Nama";
$deskripsiWeb = "Get Deskripsi";
}
?>
<div class="header">
<div gth="<?=trim(base64_encode($base_url.'artikel/beranda'),'=');?>" class="heleft">
<h1><?=$namaWeb;?></h1>
</div>
<div class="heright">
<?php
if(isset($_GET['p'])){
$url = $base_url."artikel/beranda/1/";
}else if(isset($_GET['key'])){
$url = $base_url."artikel/beranda/1/";
}else if(isset($_GET['p']) || isset($_GET['key'])){
$url = $base_url."artikel/beranda/1/";
}else{
$url = $base_url."artikel/beranda/1/";
}
?>
<div class="menu">
<span title="Navigasi" class="btn-menu">
<span></span>
<span></span>
<span></span>
</span>
</div>
</div>
<div class="box-menu">
<ul>
<?php
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] != "penulis"){
?>
<li target="<?=$base_url;?>">Beranda</li>
<?php
}
}
?>
<li target="<?=$base_url.'artikel/beranda';?>"><?php if(isset($_SESSION['levad'])){if($_SESSION['levad'] == "penulis"){?>Beranda<?php }else{?>Artikel<?php }}else{ ?>Beranda<?php } ?></li>
<li target="<?=$base_url.'artikel/sitemap';?>">Sitemap</li>
<li target="<?=$base_url.'artikel/tentang';?>">Tentang</li>
<li target="<?=$base_url.'artikel/kontak';?>">Kontak</li>
<li target="<?=$base_url.'artikel/disclaimer';?>">Disclaimer</li>
<li target="<?=$base_url.'artikel/privacy';?>">Privacy</li>
<?php
if(isset($_SESSION['akses'])){
?>
<li target="<?=$base_url.'kelola/'.trim(base64_encode('tambah-artikel-baru'),'=');?>">&plus; Artikel</li>
<li target="<?=$base_url.'kelola/'.trim(base64_encode('data-draft'),'=');?>">Buka Draft</li>
<?php
if($_SESSION['levad'] != "penulis"){
?>
<li target="<?=$base_url.'kelola/'.trim(base64_encode('nama-deskripsi'),'=');?>">Pengaturan</li>
<?php
}else{
?>
<li target="<?=$base_url.'kelola/'.trim(base64_encode('data-akun'),'=');?>">Pengaturan</li>
<?php
}
?>
<li target="<?=$base_url.'tutup/akses/'.trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=');?>">Logout</li>
<?php
}else{
?>
<li target="<?=$base_url.'akses/daftar/'.trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=');?>">Registrasi</li>
<li target="<?=$base_url.'akses/masuk/'.trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=');?>">Login</li>
<?php
}
?>
</ul>
</div>
</div>
<div class="container">
<div class="box-search">
<form action="<?=$url;?>" autocomplete="off" class="form-search">
<label for="key" class="rest-key"><span class="rest">&times;</span></label>
<input type="text" name="input_key" id="key" value="<?php if(isset($_GET['key'])){echo str_replace('-',' ',$_GET['key']);}?>" placeholder="Ketik kata kunci pencarian..." class="input-key"/>
<div class="losu"><span></span></div>
</form>
<div class="aucom">
<ul class="list" data-src="<?=trim(base64_encode($base_url.'proses'),'=');?>">
</ul>
</div>
</div>
