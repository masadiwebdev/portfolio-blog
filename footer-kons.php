<div class="sidebar">
<?php
if(isset($_GET['publik'])){
if($_GET['publik'] != "beranda" && $_GET['publik'] != "tentang" && $_GET['publik'] != "kontak" && $_GET['publik'] != "disclaimer" && $_GET['publik'] != "privacy"){
$selAdsBySide1 = mysqli_query($con,"SELECT * FROM tb_ads WHERE posisi_ads='sidebar1' ");
if(mysqli_num_rows($selAdsBySide1) == 1){
$ads1 = mysqli_fetch_assoc($selAdsBySide1);
$side1 = '<div class="boxads" data-source="'.trim(base64_encode($ads1['url_ads']),'=').'" title="'.$ads1['judul_ads'].'">
<div class="img"><img alt="'.$ads1['judul_ads'].'" loading="lazy" src="'.$base_url.'files/images/'.$ads1['gambar_ads'].'"/></div>
<div class="txt">
<h5>'.$ads1['judul_ads'].'</h5>
<p>'.$ads1['deskripsi_ads'].'</p>
</div>
</div>';
}else{
$side1 = '<div class="slot" data-source="'.trim(base64_encode('https://youtu.be/mRttyh1GQ5I'),'=').'" title="Menjadi Backend Developer di 2022">
<div class="img"><img alt="Menjadi Backend Developer di 2022" loading="lazy" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8r0hIQVdag_EqPWARBc-hb7rhV0Slx_8H8Q&usqp=CAU"/></div>
<div class="txt">
<h5>YUOTUBE: Menjadi Backend Developer di 2022</h5>
<p><strong>Web Programming UNPAS</strong> adalah channel khusus yang membahas mengenai teknologi internet dan pengembangan web / web development, khususnya...</p>
</div>
</div>';
}
$selAdsBySide2 = mysqli_query($con,"SELECT * FROM tb_ads WHERE posisi_ads='sidebar2' ");
if(mysqli_num_rows($selAdsBySide2) == 1){
$ads2 = mysqli_fetch_assoc($selAdsBySide2);
$side2 = '<div class="boxads" data-source="'.trim(base64_encode($ads2['url_ads']),'=').'" title="'.$ads2['judul_ads'].'">
<div class="img"><img alt="'.$ads2['judul_ads'].'" loading="lazy" src="'.$base_url.'files/images/'.$ads2['gambar_ads'].'"/></div>
<div class="txt">
<h5>'.$ads2['judul_ads'].'</h5>
<p>'.$ads2['deskripsi_ads'].'</p>
</div>
</div>';
}else{
$side2 = '<div class="slot" data-source="'.trim(base64_encode('https://youtu.be/mRttyh1GQ5I'),'=').'" title="Menjadi Backend Developer di 2022">
<div class="img"><img alt="Menjadi Backend Developer di 2022" loading="lazy" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8r0hIQVdag_EqPWARBc-hb7rhV0Slx_8H8Q&usqp=CAU"/></div>
<div class="txt">
<h5>YUOTUBE: Menjadi Backend Developer di 2022</h5>
<p><strong>Web Programming UNPAS</strong> adalah channel khusus yang membahas mengenai teknologi internet dan pengembangan web / web development, khususnya...</p>
</div>
</div>';
}
}else{
$side1 = "";
$side2 = "";
}
}else{
$side1 = "";
$side2 = "";
}
echo $side1;
// artikel terbaru
$selTer = mysqli_query($con,"SELECT * FROM tb_art_bas ORDER BY id_art DESC LIMIT 7");
if(mysqli_num_rows($selTer) > 0){
?>
<h2>Posting Terbaru</h2>
<div class="rowbox">
<?php
while($st = mysqli_fetch_assoc($selTer)){
if(isset($_GET['p']) && isset($_GET['key'])){
$txt = "../../";
}else if(isset($_GET['p']) || isset($_GET['tags'])){
$txt = "../";
}else{
$txt = "";
}
if(!empty($st['sampul_art'])){
$imgNepo = $base_url."files/images/".$st['sampul_art'];
}else{
$imgNepo = $base_url."f/g/no-image.png";
}
?>
<div data-art="<?=trim(base64_encode($txt.$st['slug_art']),'=');?>" class="box-nepo">
<div class="img-nepo">
<img alt="<?=$st['judul_art'];?>" loading="lazy" src="<?=$imgNepo;?>" title="<?=$st['judul_art'];?>"/>
</div>
<div class="txt-nepo">
<h3><?=$st['judul_art'];?></h3>
</div>
</div>
<?php
}
?>
</div>
<?php
}
?>
<?php
// daftar kategori
$selKat = mysqli_query($con,"SELECT DISTINCT(kategori_art) FROM tb_art_bas");
if(mysqli_num_rows($selKat) > 0){
?>
<h2>Daftar Kategori</h2>
<div class="rowbox">
<div class="box-ctr">
<?php
while($sk = mysqli_fetch_assoc($selKat)){
$xk = str_replace(", "," ",$sk['kategori_art']);
$a [] = $xk;}
$b = implode(" ",$a);
$c = explode(" ",$b);
$d = array_unique($c);
$e = implode(" ",$d);
$f = explode(" ",$e);
for($i = 0; $i < count($f); $i++){
?>
<span class="txt-ctr"><a href="<?=$base_url."artikel/".strtolower(str_replace(' ','-',$f[$i]))."/1";?>"><?=$f[$i];?></a></span>
<?php
}
?>
</div>
</div>
<?php
}
?>
<h2>Berlangganan</h2>
<div class="rowbox rwb">
<div class="subbox">
<h3>Subscribe Atakana.Com</h3>
<p>Dapatkan pemberitahuan terbaru untuk setiap postingan yang baru diterbitkan.</p>
<form autocomplete="off" class="subscribe">
<div class="row">
<input type="email" name="email" placeholder="Masukkan email" class="email"/>
<div class="error"></div>
</div>
<div class="row btn">
<button type="submit" name="subscribe_email" class="submit-email">Subscribe</button>
</div>
</form>
</div>
<div class="konad">
<form autocomplete="off" id="kontak_admin">
<h5>Hubungi Pengembang</h5>
<div class="row">
<label for="email">Email Anda</label>
<input type="email" name="email" id="email" placeholder="Masukkan email Anda"/>
<div class="err"></div>
</div>
<div class="row">
<label for="pesan">Pesan Anda</label>
<textarea name="pesan" id="pesan" placeholder="Tulis pesan Anda"></textarea>
<div class="err"></div>
</div>
<div class="row ma">
<button type="submit" name="kirim_pesan_admin" id="kirim_pesan_admin">Kirim</button>
</div>
</form>
</div>
<?=$side2;?>
</div>
<div class="butbox">
<div class="but-fix">
<button type="button" data-tp="<?=trim(base64_encode($base_url.'kelola/'),'=');?>" data-td="<?=trim(base64_encode('tambah-artikel-baru'),'=');?>" title="Posting Baru" class="btn-plus">&plus;</button><button type="button" title="Scroll Top" class="btn-sct">∆</button>
</div>
</div>
</div>
</div>
<div class="footer">
<p><?php if(isset($_GET['publik'])){if($_GET['publik'] != "beranda"){?><a href="<?=$base_url.'artikel/beranda';?>">Beranda</a> . <?php }}?><a href="<?=$base_url.'artikel/disclaimer';?>">Disclaimer</a> . <a href="<?=$base_url.'artikel/privacy';?>">Privacy</a> . <a href="<?=$base_url.'artikel/tentang';?>">Tentang</a> . <?php if(isset($_SESSION['akses'])){?><a href="<?=$base_url.'akses/keluar';?>">Logout</a><?php }else{?><a href="<?=$base_url.'akses/daftar';?>">Registrasi</a> . <a href="<?=$base_url.'akses/masuk';?>">Login</a><?php }?></p>
<p>&copy;2022 ~ <?=date('Y');?> . All Rights Reserved <?=$namaWeb;?></p>
</div>
</div>
<?php
if(isset($_SESSION['id'])){
$_SESSION['id'] = "";
unset($_SESSION['id']);
}
?>
<script src="<?=$base_url.'f/s/js/script.js?version='.filemtime('f/s/js/script.js');?>"></script>
</body>
</html>
