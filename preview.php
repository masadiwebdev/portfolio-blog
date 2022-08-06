<?php
require 'header-kons.php';
if(!isset($_SESSION['akses'])){
echo '<script>window.location.href="'.$base_url.'akses/masuk/'.trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=').'";</script>';
exit;
}
if(isset($_GET['s']) && isset($_GET['e'])){ // isset get s & e
?>
<?php
$gets = base64_decode($_GET['s']);
$gete = base64_decode($_GET['e']);
$selDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$gets' AND email_art='$gete' ");
if(mysqli_num_rows($selDraft) == 1){
$sd = mysqli_fetch_assoc($selDraft);
if(!empty($sd['sampul_art'])){
$sampul = "../../../files/images/".$sd['sampul_art'];
}else{
$sampul = "../../../f/g/no-image.png";
}
$k = explode(', ',$sd['kategori_art']);
if(!empty($sd['penulis_art'])){
$penulis = "Penulis: ".$sd['penulis_art']." | ".str_replace('-','/',$sd['terbit_art']);
}else{
$penulis ="";
}
if(!empty($sd['update_art'])){
$editing = "Diperbarui: ".str_replace('-','/',$sd['update_art']);
}else{
$editing ="";
}
$counCom = mysqli_query($con,"SELECT COUNT(id_cmn) AS tocom FROM tb_art_cmn WHERE slug_art='".$sd['slug_art']."' ");
if(mysqli_num_rows($counCom) > 0){
$cc = mysqli_fetch_assoc($counCom);
$tocom = $cc['tocom'];
}
$slides = mysqli_query($con,"SELECT * FROM tb_art_bas ORDER BY id_art ASC LIMIT 0, 10");
if(mysqli_num_rows($slides) > 0){
$data_slide_post = '
<div class="slides">
<ul class="sld">
';
while($sld = mysqli_fetch_assoc($slides)){
if(empty($sld['sampul_art'])){
$imgSlide = $base_url."f/g/no-image.png";
}else{
$imgSlide = $base_url."files/images/".$sld['sampul_art'];
}
$jdlSlide = $sld['judul_art'];
$data_slide_post .= '
<li data-source="'.trim(base64_encode($base_url.'artikel/'.$sld['slug_art']),'=').'">
<img alt="'.$jdlSlide.'" loading="lazy" src="'.$imgSlide.'" title="'.$jdlSlide.'"/>
<h1>'.$jdlSlide.'</h1>
</li>
';
}//tutup while slides
$data_slide_post .= '
</ul>
</div>
';
}else{//tutup else num rows slides
$data_slide_post = "";
}//tutup if num rows slides
echo $data_slide_post;
?>
<div class="post">
<div class="links"><a href="beranda">Beranda</a> / <?php for($i = 0; $i < count($k); $i++){echo '<a href="'.strtolower(str_replace(' ','-',$k[$i])).'">'.$k[$i].'</a> / ';}?><?=$sd['judul_art'];?></div>
<h1 class="title"><?=$sd['judul_art'];?></h1>
<div class="share-art">
<span class="efbi">Facebook</span>
<span class="wea">Whatsapp</span>
<span class="twit">Twitter</span>
</div>
<div class="getcom"><span title="Komentar" class="coms">0 Komentar</span></div>
<div class="cover">
<div class="imp">
<div class="img"></div>
<div class="txt">
<h6><?=$sd['penulis_art'];?></h6>
<p><?=$sd['terbit_art'];?></p>
</div>
</div>
<div class="img">
<img alt="<?=$sd['judul_art'];?>" loading="lazy" src="<?=$sampul;?>" title="<?=$sd['judul_art'];?>"/>
</div>
<div class="caption"><?=$sd['judul_art'];?></div>
</div>
<div class="isiart">
<?=$sd['isi_art'];?>
</div>
<div class="editing"><?=$editing;?></div>
<div class="tags">
<?php
$tag = explode(', ',$sd['kategori_art']);
for($i = 0; $i < count($tag); $i++){
?>
<a href="#" class="tag"><?=$tag[$i];?></a>
<?php
}
?>
</div>
<div class="prenex">
<button type="button" class="prev">Sebelumnya</button>
<button type="button" class="home">Beranda</button>
<button type="button" class="next">Selanjutnya</button>
</div>
<div class="sbc">
<p>Terima kasih telah mengunjungi Atakana.Com. Baca juga topik menarik lainnya, dan jangan lewatkan setiap update terbaru dengan cara klik tombol dibawah.<br><a href="#" title="Subscribe Atakana.Com">Subscribe Disini</a></p>
</div>
<div class="krisan"><span>Kritik &amp; Saran</span></div>
<div class="report"><span>Laporkan Konten Ini</span></div>
<div class="share-art">
<span class="efbi">Facebook</span>
<span class="wea">Whatsapp</span>
<span class="twit">Twitter</span>
</div>
<div class="relarea">
<h3>Terkait Topik</h3>
<div class="relpost">
<?php
$related = Array();
$target = base64_decode($_GET['s']);
//echo $target;
$selTarget = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$target' ");
if(mysqli_num_rows($selTarget) == 1){
$st = mysqli_fetch_assoc($selTarget);
$left = $st['judul_art'];
}
//echo $judul;
$notTarget = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art<>'$target' ");
if(mysqli_num_rows($notTarget) > 0){
while($nt = mysqli_fetch_assoc($notTarget)){
$dirtarget = trim(base64_encode($base_url."artikel/".$nt['slug_art']),'=');
$judul = $nt['judul_art'];
if(!empty($nt['sampul_art'])){
$sampul = $base_url."files/images/".$nt['sampul_art'];
}else{
$sampul = $base_url."f/g/no-image.png";
}
$right = $nt['judul_art'];
$pers = 45;
$max = 6;
similar_text($left, $right, $perc);
if($perc >= $pers){
if(count($related) <= $max){
$related [] = '
<div data-view="'.$dirtarget.'" class="relbox">
<div class="img">
<img alt="'.$judul.'" loading="lazy" src="'.$sampul.'" title="'.$judul.'"/>
</div>
<div class="reltext">
<h4>'.$judul.'</h4>
</div>
</div>
';
}
}
}
if(count($related) > 0){
for($i = 0; $i < count($related) - 1; $i++){
echo $related[$i];
}
}else{
echo '<div class="relnot">Tidak ada data untuk ditampilkan!</div>';
}
}
?>
</div>
</div>
<div id="form-com" class="cmn">
<form class="form-cmn">
<h4>Kirim Komentar</h4>
<div class="row">
<label for="komentar">Komentar Anda</span></label>
<textarea name="komentar" id="komentar" placeholder="Tulis komentar Anda" class="komentar"></textarea>
<div class="error"></div>
</div>
<div class="row btn-cmn">
<button type="reset">Reset</button>
<button type="submit" name="kirim_komentar" class="kirim-komentar">Kirim</button>
</div>
</form>
<div class="list-cmn">
<h5>Komentar <span class="tocom">(<?=$tocom;?>)</span></h5>
<?php
$selCom = mysqli_query($con,"SELECT * FROM tb_art_cmn WHERE slug_art='".$sd['slug_art']."' ORDER BY id_cmn DESC");
if(mysqli_num_rows($selCom) > 0){
while($sc = mysqli_fetch_assoc($selCom)){
?>
<div class="data-cmn">
<?php
if(isset($_SESSION['akses'])){
if($_SESSION['email'] == $sc['email_cmn']){
?>
<span data-target="<?=trim(base64_encode($sc['id_cmn']),'=');?>" class="del-cmn">&times;</span>
<?php
}
}
?>
<h6><?=$sc['nama_cmn'];?> <span class="datCom"><?=$sc['tanggal_cmn'];?></span></h6>
<p><?=$sc['komentar_cmn'];?></p>
</div>
<?php
}
}else{
?>
<div class="nocom">Belum ada komentar di artikel ini!</div>
<?php
}
?>
</div>
</div>
</div>
<script src="<?=$base_url.'f/s/js/pst.js?version='.filemtime('f/s/js/pst.js');?>"></script>
<?php
}else{
?>
<div class="post">
<div class="tts">
<h3>Preview Kosong!</h3>
<p>Tidak ada data preview yang dapat ditampilkan.</p>
</div>
</div>
<?php
}
} // end isset get s & e
?>
<?php
require 'footer-kons.php';
?>
