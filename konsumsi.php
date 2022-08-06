<?php
require 'header-kons.php';
if(isset($_GET['publik'])){ // isset get publik
$slides = mysqli_query($con,"SELECT * FROM tb_art_bas ORDER BY id_art ASC LIMIT 0, 10");
if(mysqli_num_rows($slides) > 0){
$data_slide_post = '<div class="slides">
<ul class="sld">';
while($sld = mysqli_fetch_assoc($slides)){
if(empty($sld['sampul_art'])){
$imgSlide = $base_url."f/g/no-image.png";
}else{
$imgSlide = $base_url."files/images/".$sld['sampul_art'];
}
$jdlSlide = $sld['judul_art'];
$data_slide_post .= '
<li data-source="'.trim(base64_encode($base_url.'artikel/'.$sld['slug_art']),'=').'">
<img alt="'.$jdlSlide.'" loading="lazy" src="'.$imgSlide.'" title="'.$jdlSlide.'"/><h1>'.$jdlSlide.'</h1>
</li>';
}//tutup while slides
$data_slide_post .= '</ul>
</div>';
}else{//tutup else num rows slides
$data_slide_post = "";
}//tutup if num rows slides
echo $data_slide_post;
$slot_one = '<div class="slot" data-source="'.trim(base64_encode('https://youtu.be/mRttyh1GQ5I'),'=').'" title="Menjadi Backend Developer di 2022">
<div class="slot_one">
<div class="img">
<img alt="Menjadi Backend Developer di 2022" loading="lazy" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8r0hIQVdag_EqPWARBc-hb7rhV0Slx_8H8Q&usqp=CAU"/>
</div>
<div class="txt">
<h5>YUOTUBE: Menjadi Backend Developer di 2022</h5>
<p><strong>Web Programming UNPAS</strong> adalah channel khusus yang membahas mengenai teknologi internet dan pengembangan web / web development, khususnya untuk mahasiswa teknik informatika di Universitas Pasundan Bandung dan...</p>
</div>
</div>
</div>';
?>
<div class="post">
<?php
if($_GET['publik'] == "beranda"){
if(!isset($_GET['key'])){
echo $slot_one;
}
?>
<?php
if(isset($_GET['key'])){
$getKey = str_replace('-',' ',$_GET['key']);
$hisho = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE judul_art LIKE '%".$getKey."%' OR kategori_art LIKE '%".$getKey."%' ");
if(mysqli_num_rows($hisho) > 0){
$totalData = mysqli_num_rows($hisho);
echo '<div class="res-txt">
Menampilkan '.$totalData.' hasil untuk <span class="txt">'.str_replace('-',' ',$_GET['key']).'</span>
</div>';
}//tutup num rows hisho
}//tutup isset get key
}//tutup get publik = beranda
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
<?php
if(isset($_GET['publik'])){if($_GET['publik'] == "beranda"){
?>
<div class="links"></div>
<?php
}
?>
<?php
}
?>
<?php
if($_GET['publik'] == "beranda"){ // if get publik = beranda
?>
<?php
if(isset($_GET['key'])){
$key = str_replace('-',' ',$_GET['key']);
}else{
$key = "";
}
$bts = 8;
$hal = isset($_GET['p'])?(int)$_GET['p']:1;
$awal = ($hal>1)?($hal*$bts)-$bts:0;
$mdr = $hal-1;
$mju = $hal+1;
$data = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE judul_art LIKE '%".$key."%' OR kategori_art LIKE '%".$key."%' ORDER BY id_art DESC");
$jml = mysqli_num_rows($data);
$total = ceil($jml/$bts);
$sel_artikel = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE judul_art LIKE '%".$key."%' OR kategori_art LIKE '%".$key."%' ORDER BY id_art DESC LIMIT $awal, $bts");
if(mysqli_num_rows($sel_artikel) > 0){ // if num rows sel_artikel
while($result = mysqli_fetch_array($sel_artikel)){
$data_array [] = $result;
}
$result_one = "";
$result_two = "";
$count_array = ceil(count($data_array)/2);
$slice_array = array_chunk($data_array, $count_array);
$count_slice = count($slice_array);
if($count_slice == 1){
$array_one = $slice_array[0];
foreach($array_one AS $ao){
if(!empty($ao['sampul_art'])){
$cover = $base_url."files/images/".$ao['sampul_art'];
}else{
$cover = $base_url."f/g/no-image.png";
}
$jdl = strlen($ao['judul_art']);
if($jdl > 40){
$dot = "...";
}else{
$dot = "";
}
$result_one .= '<div class="post-card" target="'.trim(base64_encode($base_url."artikel/".$ao['slug_art']),'=').'">
<div class="card-img">
<img alt="'.$ao['judul_art'].'" loading="lazy" src="'.$cover.'" title="'.$ao['judul_art'].'"/>
</div>
<h2>'.rtrim(rtrim(substr($ao['judul_art'],0,40),' '),'.').$dot.'</h2>
</div>';
}
}else{
$array_one = $slice_array[0];
$array_two = $slice_array[1];
foreach($array_one AS $ao){
if(!empty($ao['sampul_art'])){
$cover = $base_url."files/images/".$ao['sampul_art'];
}else{
$cover = $base_url."f/g/no-image.png";
}
$jdl = strlen($ao['judul_art']);
if($jdl > 40){
$dot = "...";
}else{
$dot = "";
}
$result_one .= '<div class="post-card" target="'.trim(base64_encode($base_url."artikel/".$ao['slug_art']),'=').'">
<div class="card-img">
<img alt="'.$ao['judul_art'].'" loading="lazy" src="'.$cover.'" title="'.$ao['judul_art'].'"/>
</div>
<h2>'.rtrim(rtrim(substr($ao['judul_art'],0,40),' '),'.').$dot.'</h2>
</div>';
}
foreach($array_two AS $at){
if(!empty($at['sampul_art'])){
$cover = $base_url."files/images/".$at['sampul_art'];
}else{
$cover = $base_url."f/g/no-image.png";
}
$jdl = strlen($at['judul_art']);
if($jdl > 40){
$dot = "...";
}else{
$dot = "";
}
$result_two .= '<div class="post-card" target="'.trim(base64_encode($base_url."artikel/".$at['slug_art']),'=').'">
<div class="card-img">
<img alt="'.$at['judul_art'].'" loading="lazy" src="'.$cover.'" title="'.$at['judul_art'].'"/>
</div>
<h2>'.rtrim(rtrim(substr($at['judul_art'],0,40),' '),'.').$dot.'</h2>
</div>';
}
}
echo $result_one.'<div class="post-card card-ads" target="'.trim(base64_encode('NOTTARGET'),'=').'">
<div class="card-img ads">
<img alt="#" loading="lazy" src="'.$base_url.'files/images/sampul-contoh-css-box-shadow-upload-by-ardi-11805.jpg" title="#"/>
</div>
<h2>Forum Web Programming Atakana.Com</h2>
</div>'.$result_two;
if(isset($_GET['p']) && isset($_GET['key'])){
$link = $base_url."artikel/beranda/";
$k = "/".$_GET['key'];
}else{
$link = $base_url."artikel/beranda/";
$k = "";
}
if($total > 1){
?>
<div class="pages">
<?php
if($hal > 1){
$linkPrev = $link.$mdr.$k;
$prev = '<a href="'.$linkPrev.'"><span class="link-page">&laquo;</span></a>';
}else{
$prev = '<span class="link-page">&laquo;</span>';
}
echo $prev." ";
$ttl = 3;
if(isset($_GET['p'])){
if($_GET['p'] == 1){
$ttl = 3;
}else{
$ttl = 2;
}
}
$start = ($hal > $ttl)?$hal-$ttl:1;
$end = ($hal < ($total-$ttl))?$hal+$ttl:$total;
$str = $end-$start;
if($total > 4){
if($end == 2){
$end = $end+1;
}else if($end == 3){
$end = $end+2;
}else if($end == 4){
$end = $end+1;
}else if($str == 2){
$start = $start-2;
}else if($str == 3){
$start = $start-1;
}
}
for($p = $start; $p <= $end; $p++){
$active = ($hal==$p)?'active':'';
?>
<a href="<?=$link.$p.$k;?>"><span class="link-page <?=$active;?>"><?=$p;?></span></a>
<?php
}
if($hal < $total){
$linkNext = $link.$mju.$k;
$next = '<a href="'.$linkNext.'"><span class="link-page">&raquo;</span></a>';
}else{
$next = '<span class="link-page">&raquo;</span>';
}
echo $next;
?>
</div>
<?php
}
}else{ // else if num rows sel_artikel
?>
<div class="notData">
<h5>Oops!</h5>
<p>Maaf data tidak ditemukan atau belum tersedia, silakan kembali ke <a href="<?=$base_url.'artikel/beranda';?>">beranda</a>.</p>
</div>
<?php
} // tutup if num rows sel_artikel
?>
<?php
}else if($_GET['publik'] == "sitemap"){ // else if get publik = beranda
echo '<div class="statis">';
echo '<h1>Sitemap</h1>';
echo '<p>Daftar posting atakana.com</p>';
$cekCtr = mysqli_query($con,"SELECT DISTINCT(kategori_art) FROM tb_art_bas");
while($cc = mysqli_fetch_assoc($cekCtr)){
$cx [] = str_replace(',','',$cc['kategori_art']);
}
$ax1 = implode(' ',$cx);
$ax2 = explode(' ',$ax1);
$ax3 = array_count_values($ax2);
function delDupArray($count){
return $count > 1;
}
$ax4 = array_filter(array_count_values($ax2),"delDupArray");
$ax5 = array_unique($ax2);
$ax6 = implode(' ',$ax5);
$ax7 = explode(' ',$ax6);
$ax = $ax7;
for($i = 0; $i < count($ax); $i++){
$categori = $ax[$i];
$listData = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE kategori_art LIKE '%".$categori."%' ");
if(mysqli_num_rows($listData) > 0){
echo '<ul class="sts">';
echo '<li class="title"># Kategori '.$categori.'</li>';
while($ld = mysqli_fetch_assoc($listData)){
?>
<li><a href="<?=$base_url.'artikel/'.$ld['slug_art'];?>" title="<?=$ld['judul_art'];?>"><?=$ld['judul_art'];?></a></li>
<?php
}
echo '</ul>';
}else{
echo '<p>Belum ada data!</p>';
}
}
//}
echo '</div>';
}else if($_GET['publik'] == "tentang"){
?>
<div class="statis">
<h1>Tentang</h1>
<p>Atakana.Com adalah sebuah platform web blog yang membagikan konten dalam bentuk teks dan gambar dengan beragam topik dan kategori.</p>
<p>Web blog Atakana.Com dibuka untuk publik jadi siapa saja dapat membuat, menulis atau membagikan ide dan ceritanya disini (Atakana.Com) dibawah aturan yang telah ditetapkan.</p>
<p>Anda yang ingin bergabung menjadi penulis di Atakana.Com, bisa langsung <a href="<?=$base_url.'akses/daftar/'.trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=');?>" title="Buat Akun Baru">daftar disini</a>, dan setelah itu lakukan aktivasi agar akun Anda dapat digunakan.</p>
<p>Walaupun dibuka untuk publik tapi tetap ada aturan mainnya. Jadi bagia siapa saja yang sudah menjadi bagian sebagai penulis di Atakana.Com harus patuh pada aturan yang telah ditetapkan.</p>
<p><strong>Note:</strong><br>Konten halaman ini dapat berubah kapan saja tanpa pemberitahuan.</p>
</div>
<?php
}else if($_GET['publik'] == "kontak"){
?>
<div class="statis">
<h1>Kontak</h1>
<ul class="sts">
<li>Email: <a href="mailto:admin@atakana.com">admin@atakana.com</a></li>
<li>Whatsapp: <a href="https://wa.me/6281285242366">081285242366</a></li>
</ul>
</div>
<?php
}else if($_GET['publik'] == "disclaimer"){
?>
<div class="statis">
<h1>Disclaimer</h1>
<h2>Disclaimer untuk Atakana.Com</h2>
<p>Dengan mengikuti dan menggunakan informasi di Atakana.Com artinya Anda sebagai penggunna telah memahami dan menyetujui segala ketentuan yang berlaku.</p>
<p>Seluruh konten dan informasi yang tersedia di web blog Atakana.Com ditulis dan disajikan dengan sejujur-jujurnya.</p>
<p>Dan jika Anda sebagai pengguna menemui atau mendapati konten bermasalah atau yang membagikan informasi palsu silakan laporkan kontent tersebut, gunakan fitur &quot;Laporkan Konten Ini&quot; tepat dibawah posting.</p>
<p>Namun jika dianggap hanya suatu kekeliruan (bukan kesalahan atau masalah), Anda sebagai penggunakan diharap untuk memberitahukan penulis terkain konten tersebut melalui fitur &quot;Kritik &amp; Saran&quot; tepat dibawah posting.</p>
<p>Di Atakana.Com terdapat sebagaian tautan yang mengarah ke website atau situs lain. Namun itu semua dibawah kendali pemilik website atau situs tersebut. Jika terjadi hal yang tidak diharapkan hubungi pemilik website atau situs yang bersangkutan.</p>
<p>Apabila tanpa sengaja, Anda (pengguna) merasa dirugikan akibat aktifitas dari pihak, website atau tautan dari sumber lain, jika hal ini terjadi diluar tanggung jawab kami (pengembang dan penulis).</p>
<h3>Pengembang Web Blog Atakana.Com</h3>
<p>Saya (pengembang) web blog Atakana.Com tidak sepenuhnya dapat mengontrol seluruh konten yang dibagikan di Atakana.Com.</p>
<p>Apapun bentuk kesalahan, kekeliruan, atau masalah terkait konten adalah spenuhnya tanggung jawab Anda (penulis) koten yang bersangkutan.</p>
<p>Saya (pengembang) hanya menyediakan fasilitas untuk Anda (penulis) agar dapat membagikan ide dan ceritanya di Atakana.Com, diluar itu semua tanggung jawab Anda (penulis).</p>
<h3>Penulis Konten Atakana.Com</h3>
<p>Anda sebagai penulis, sebelum atau sesaat sesudah konten (posting) Anda terbitkan (publish) diharap untuk periksa atau kroscek kembali konten yang Anda tersebut sehingga dapat terhindar dari hal-hal yang tidak diinginkan dikemudian hari.</p>
<p>Berhati-hatilah dalam membuat atau menulis konten jangan sampai melanggar hak cipta, atau konten plagiat hasil copy paste dari konten orang lain baik dari Atakana.Com atau dari luar.</p>
<p>Saya (pengembang) akan segera menindak lanjuti konten terkait jika kedapatan atau menerima laporan dari penggunna yang melaporkan konten Anda (penulis) bermasalah.</p>
<p>Saya (pengembang) bisa saja menghapus konten dan menonaktifkan akun Anda (penulis) untuk batas waktu yang tidak ditentukan, dan bahkan bisa saja menghapusnya.</p>
<h3>Anda Pengguna Web Blog Atakana.Com</h3>
<p>Anda sebagai pengguna Atakana.Com tidak dapat menuntut apapun jika Anda merasa dirugikan setelah menggunakan informasi di Atakana.Com.</p>
<p>Kerugian yang Anda alami di Atakana.Com bukanlah murni kesalahan dari pihak kami (pengembang maupun penulis), dan tidak dilakukan dengan sengaja.</p>
<p>Kesalah baik disengaja atau tidak disengaja saya (pengembang) menghimbau kepada seluruh pengguna Atakana.com untuk menghubungi dan menyampaikan perihal tersebut via &quot;Form Pengembang&quot; yang ada dibagian sidebar (bawah mobile) dan (kanan desktop).</p>
<p>Saya (pengembang) Atakana.Com akan merespon dan menindak lanjuti semua masukkan atau laporan yang Anda (pengguna) sampaikan demi mewujudkan kenyamanan bersama.</p>
<p>Dan jika Anda (penulis) mengutip sebagian isi konten dari sumber lain diluar sana maka, jangan lupa untuk mencantukan informasi sumber kutipan tersebut.</p>
<p>Setelah Anda (penulis dan pengguna) membaca dan memahami isi konten ini, saya (pengembang) anggap sudah mengerti dan setuju dengan ketetapan yang tertulis di atas.</p>
<p><strong>Note</strong><br>Konten halaman ini dapat berubah kapan saja tanpa pemberitahuan terlebih dahulu.</p>
</div>
<?php
}else if($_GET['publik'] == "privacy"){
?>
<div class="statis">
<h1>Privacy Policy</h1>
<h2>Privacy Policy untuk Atakana.Com</h2>
<p>Atakana.Com mengumpulkan dan menyimpan informasi pribadi yang Anda (penulis dan pengguna) berikan pada saat pertama kali melakukan registrasi.</p>
<p>Informasi yang Anda (penulis dan pengguna) berikan akan tersimpan rapi dan aman di database Atakana.Com, tanpa membagikannya kepihak atau organisasi lain.</p>
<p>Jika dikemudian hari terjadi hal yang kita (bersama) tidak harapkan, dan bukan suatu kesengajaan, itu terjadi diluar kendali saya (pengembang), dan dengan itu saya (pengembang) tidak bertanggung jawab.</p>
<p></p>
<p>Setelah Anda (penulis dan pengguna) membaca dan memahami isi konten ini, saya (pengembang) anggap sudah mengerti dan setuju dengan ketetapan yang tertulis di atas.</p>
<p><strong>Note</strong><br>Konten halaman ini dapat berubah kapan saja tanpa pemberitahuan terlebih dahulu.</p>
</div>
<?php
}else{
?>
<?php
$getPublik = $_GET['publik'];
$selArtikel = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$getPublik' ");
if(mysqli_num_rows($selArtikel) == 1){
$sa = mysqli_fetch_assoc($selArtikel);
if(!empty($sa['sampul_art'])){
$sampul = "../files/images/".$sa['sampul_art'];
}else{
$sampul = "../f/g/no-image.png";
}
$k = explode(', ',$sa['kategori_art']);
if(!empty($sa['update_art'])){
$editing = "Diperbarui: ".str_replace('|','/',$sa['update_art']);
}else{
$editing ="";
}
if(!isset($_GET['key'])){
//echo $slot_one;
}
?>
<div class="links"><a href="<?=$base_url.'artikel/beranda';?>">Beranda</a> / <?php for($i = 0; $i < count($k); $i++){echo '<a href="'.strtolower(str_replace(' ','-',$k[$i])).'/1">'.$k[$i].'</a> / ';}?> <?=$sa['judul_art'];?></div>
<h1 class="title"><?=$sa['judul_art'];?></h1>
<div class="share-art">
<span target-s="https://facebook.com/sharer/sharer.php?u=<?=str_replace(':','%3A',str_replace('/','%2F',$base_url.'artikel/'.$_GET['publik']));?>" class="efbi">Facebook</span>
<span target-s="https://api.whatsapp.com/send?text=<?=str_replace(':','%3A',str_replace('/','%2F',$base_url.'artikel/'.$_GET['publik']));?>" class="wea">Whatsapp</span>
<span target-s="https://twitter.com/intent/tweet?text=<?=str_replace(':','%3A',str_replace('/','%2F',$base_url.'artikel/'.$_GET['publik']));?>" class="twit">Twitter</span>
</div>
<?php
if(isset($_SESSION['akses'])){
if($sa['email_art'] == $_SESSION['email']){
?>
<div class="edha"><span target-hps="<?=trim(base64_encode($sa['slug_art']),'=');?>" class="hps">hapus</span> <span target="<?=$base_url.'kelola/'.trim(base64_encode('edit-artikel'),'=').'/'.trim(base64_encode($sa['slug_art']),'=');?>" class="edit">edit</span></div>
<?php
}
}
$counCom = mysqli_query($con,"SELECT COUNT(id_cmn) AS tocom FROM tb_art_cmn WHERE slug_art='".$sa['slug_art']."' ");
if(mysqli_num_rows($counCom) > 0){
$cc = mysqli_fetch_assoc($counCom);
$tocom = $cc['tocom'];
}
$relpoco = Array();
$trg = $getPublik;
$left = $trg;
$selData2 = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art<>'$trg' ");
if(mysqli_num_rows($selData2) > 0){
while($sd2 = mysqli_fetch_assoc($selData2)){
$linkTarget= $base_url."artikel/".$sd2['slug_art'];
$judul = $sd2['judul_art'];
$right = $sd2['judul_art'];
$pers = 45;
$max = 5;
similar_text($left, $right, $perc);
if($perc >= $pers){
if(count($relpoco) <= $max){
$relpoco [] = '
<li><a href="'.$linkTarget.'" title="'.$judul.'">'.$judul.'</a></li>
';
}
}
}
if(count($relpoco) > 0){
for($i = 0; $i < count($relpoco); $i++){
$darelpo .= $relpoco[$i];
}
}else{
$darelpo = "";
}
}
$selAdsByPost1 = mysqli_query($con,"SELECT * FROM tb_ads WHERE posisi_ads='post1' ");
if(mysqli_num_rows($selAdsByPost1) == 1){
$adp1 = mysqli_fetch_assoc($selAdsByPost1);
$data1 = '<div class="boxads" data-source="'.trim(base64_encode($adp1['url_ads']),'=').'" title="'.$adp1['judul_ads'].'">
<div class="img"><img alt="'.$adp1['judul_ads'].'" loading="lazy" src="'.$base_url.'files/images/'.$adp1['gambar_ads'].'"/></div>
<div class="txt">
<h5>'.$adp1['judul_ads'].'</h5>
<p>'.$adp1['deskripsi_ads'].'</p>
</div>
</div>';
}else{
$data1 = '<div class="boxads" data-source="'.trim(base64_encode('https://youtu.be/mRttyh1GQ5I'),'=').'" title="Menjadi Backend Developer di 2022">
<div class="img"><img alt="Menjadi Backend Developer di 2022" loading="lazy" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8r0hIQVdag_EqPWARBc-hb7rhV0Slx_8H8Q&usqp=CAU"/></div>
<div class="txt">
<h5>YUOTUBE: Menjadi Backend Developer di 2022</h5>
<p><strong>Web Programming UNPAS</strong> adalah channel khusus yang membahas mengenai teknologi internet dan pengembangan web / web development, khususnya...</p>
</div>
</div>';
}
$selAdsByPost2 = mysqli_query($con,"SELECT * FROM tb_ads WHERE posisi_ads='post2' ");
if(mysqli_num_rows($selAdsByPost2) == 1){
$adp2 = mysqli_fetch_assoc($selAdsByPost2);
$data2 = '<div class="boxads" data-source="'.trim(base64_encode($adp2['url_ads']),'=').'" title="'.$adp2['judul_ads'].'">
<div class="img"><img alt="'.$adp2['judul_ads'].'" loading="lazy" src="'.$base_url.'files/images/'.$adp2['gambar_ads'].'"/></div>
<div class="txt">
<h5>'.$adp2['judul_ads'].'</h5>
<p>'.$adp2['deskripsi_ads'].'</p>
</div>
</div>';
}else{
$data2 = '<div class="boxads" data-source="">
<div class="txt">
<h5>Follow Sosial Media Sandhika Galih - Web Programming UNPAS</h5>
<ul>
<li><a href="https://instagram.com/sandhikagalih" title="Instagram Sandhika Galih" target="_blank">Instagram Sandhika Galih</a></li>
<li><a href="https://twitter.com/sandhikagalih" title="Twitter Sandhika Galih" target="_blank">Twitter Sandhika Galih</a></li>
<li><a href="https://linkedin.com/in/sandhikagalih" title="Linkedin Sandhika Galih" target="_blank">Linkedin Sandhika Galih</a></li>
<li><a href="https://github.com/sandhikagalih" title="Github Sandhika Galih" target="_blank">Github Sandhika Galih</a></li>
<li><a href="https://codepen.io/sandhikagalih" title="Codepen Sandhika Galih" target="_blank">Codepen Sandhika Galih</a></li>
</ul>
</div>
</div>';
}
$selAdsByPost3 = mysqli_query($con,"SELECT * FROM tb_ads WHERE posisi_ads='post3' ");
if(mysqli_num_rows($selAdsByPost3) == 1){
$adp3 = mysqli_fetch_assoc($selAdsByPost3);
$data3 = '<div class="boxads" data-source="'.trim(base64_encode($adp3['url_ads']),'=').'" title="'.$adp3['judul_ads'].'">
<div class="img"><img alt="'.$adp3['judul_ads'].'" loading="lazy" src="'.$base_url.'files/images/'.$adp3['gambar_ads'].'"/></div>
<div class="txt">
<h5>'.$adp3['judul_ads'].'</h5>
<p>'.$adp3['deskripsi_ads'].'</p>
</div>
</div>';
}else{
$data3 = "";
}
$selAdsByPost4 = mysqli_query($con,"SELECT * FROM tb_ads WHERE posisi_ads='post4' ");
if(mysqli_num_rows($selAdsByPost4) == 1){
$adp4 = mysqli_fetch_assoc($selAdsByPost4);
$data4 = '<div class="boxads" data-source="'.trim(base64_encode($adp4['url_ads']),'=').'" title="'.$adp4['judul_ads'].'">
<div class="img"><img alt="'.$adp4['judul_ads'].'" loading="lazy" src="'.$base_url.'files/images/'.$adp4['gambar_ads'].'"/></div>
<div class="txt">
<h5>'.$adp4['judul_ads'].'</h5>
<p>'.$adp4['deskripsi_ads'].'</p>
</div>
</div>';
}else{
$data4 = "";
}
if($darelpo != null){
$darpos = '<div class="darepo"><ul><li>Jangan Lewatkan</li>'.$darelpo.'</ul></div>';
}else{
$darpos = "";
}
$data_string = $sa['isi_art'];
$data_leng = strlen($data_string);
if($data_leng > 1500){
$data_array = explode("</p>",$data_string);
if(count($data_array) >= 10 && count($data_array) <= 20){
$int = 2;
}else if(count($data_array) >= 20 && count($data_array) <= 30){
$int = 3;
}else if(count($data_array) >= 30){
$int = 4;
}else{
$int = 1;
}
$data_int = ceil(count($data_array)/$int);
$array_result = array_chunk($data_array,$data_int);
if(count($array_result) == 1){
$result_one = implode('',$array_result[0]);
$result_two = "";
$result_three = "";
$result_four = "";
$data_one = $data1;
$data_two = "";
$data_three = "";
$data_four = "";
}else if(count($array_result) == 2){
$result_one = implode('',$array_result[0]);
$result_two = implode('',$array_result[1]);
$result_three = "";
$result_four = "";
$data_one = $data1;
$data_two = $data2;
$data_three = "";
$data_four = "";
}else if(count($array_result) == 3){
$result_one = implode('',$array_result[0]);
$result_two = implode('',$array_result[1]);
$result_three = implode('',$array_result[2]);
$result_four = "";
$data_one = $data1;
$data_two = $data2;
$data_three = $data3;
$data_four = "";
}else if(count($array_result) == 4){
$result_one = implode('',$array_result[0]);
$result_two = implode('',$array_result[1]);
$result_three = implode('',$array_result[2]);
$result_four = implode('',$array_result[3]);
$data_one = $data1;
$data_two = $data2;
$data_three = $data3;
$data_four = $data4;
}else{
$result_one = "";
$result_two = "";
$result_three = "";
$result_four = "";
$data_one = "";
$data_two = "";
$data_three = "";
$data_four = "";
}
$data_post = $data_one.$result_one.$darpos.$data_two.$result_two.$data_three.$result_three.$darpos.$result_four.$data_four;
}else{
$data_post = $data_string;
}
?>
<div class="getcom"><span title="Komentar" class="coms"><?=$tocom;?> Komentar</span></div>
<div class="cover">
<div class="imp">
<div class="img"></div>
<div class="txt">
<h6><?=$sa['penulis_art'];?></h6>
<p><?=$sa['terbit_art'];?></p>
</div>
</div>
<div class="img">
<img alt="<?=$sa['judul_art'];?>" loading="lazy" src="<?=$sampul;?>" title="<?=$sa['judul_art'];?>"/>
</div>
<div class="caption"><?=$sa['judul_art'];?></div>
</div>
<div class="isiart">
<?=$data_post;?>
</div>
<div class="editing"><?=$editing;?></div>
<div class="tags">
<?php
$tag = explode(', ',$sa['kategori_art']);
for($i = 0; $i < count($tag); $i++){
?>
<a href="<?=strtolower(str_replace(' ','-',$k[$i]));?>/1" class="tag"><?=$tag[$i];?></a>
<?php
}
$get_id = $sa['id_art'];
$prev = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE id_art<$get_id ORDER BY id_art DESC");
$next = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE id_art>$get_id ORDER BY id_art ASC");
?>
</div>
<div class="prenex">
<?php
if($dt = mysqli_fetch_array($prev)){
$linkPrev = $dt['slug_art'];
?>
<button type="button" data-prev="<?=trim(base64_encode($base_url.'artikel/'.$linkPrev),'=');?>" class="prev">Sebelumnya</button>
<?php
}else{
?>
<button type="button" class="prev notlink">Sebelumnya</button>
<?php
}
?>
<button type="button" data-home="<?=trim(base64_encode($base_url.'artikel/beranda'),'=');?>" class="home">Beranda</button>
<?php
if($dt = mysqli_fetch_array($next)){
$linkNext = $dt['slug_art'];
?>
<button type="button" data-next="<?=trim(base64_encode($base_url.'artikel/'.$linkNext),'=');?>" class="next">Selanjutnya</button>
<?php
}else{
?>
<button type="button" class="next notlink">Selanjutnya</button>
<?php
}
?>
</div>
<div class="sbc">
<p>Terima kasih telah mengunjungi Atakana.Com. Baca juga topik menarik lainnya, dan jangan lewatkan setiap update terbaru dengan cara klik tombol dibawah.<br><a href="#" title="Subscribe Atakana.Com">Subscribe Disini</a></p>
</div>
<div class="krisan"><span>Kritik &amp; Saran</span></div>
<div class="report"><span>Laporkan Konten Ini</span></div>
<div class="share-art">
<span target-s="https://facebook.com/sharer/sharer.php?u=<?=str_replace(':','%3A',str_replace('/','%2F',$base_url.'artikel/'.$_GET['publik']));?>" class="efbi">Facebook</span>
<span target-s="https://api.whatsapp.com/send?text=<?=str_replace(':','%3A',str_replace('/','%2F',$base_url.'artikel/'.$_GET['publik']));?>" class="wea">Whatsapp</span>
<span target-s="https://twitter.com/intent/tweet?text=<?=str_replace(':','%3A',str_replace('/','%2F',$base_url.'artikel/'.$_GET['publik']));?>" class="twit">Twitter</span>
</div>
<div class="relarea">
<h3>Terkait Topik</h3>
<div class="relpost">
<?php
$related = Array();
$target = $_GET['publik'];
$selTarget = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$target' ");
if(mysqli_num_rows($selTarget) == 1){
$st = mysqli_fetch_assoc($selTarget);
$left = $st['judul_art'];
}
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
$related [] = '<div data-view="'.$dirtarget.'" class="relbox">
<div class="img">
<img alt="'.$judul.'" loading="lazy" src="'.$sampul.'" title="'.$judul.'"/>
</div>
<div class="reltext">
<h4>'.$judul.'</h4>
</div>
</div>';
}
}
}
if(count($related) > 1){
for($i = 0; $i < count($related) - 1; $i++){
echo $related[$i];
}
}else{
echo '<div class="relnot">Belum ada data untuk ditampilkan!</div>';
}
}
?>
</div>
</div>
<div id="form-com" class="cmn">
<form class="form-cmn">
<h4>Kirim Komentar</h4>
<p>Berkomentarlah dengan bijak dan sopan, terima kasih. <span ntf="<?=trim(base64_encode('Dilarang keras menggunakan kata-kata tidak pantas dalam berkomentar. Komentar yang baik akan mencerminkan kepribadian Anda. Form komentar telah terfilter. Terima kasih.'),'=');?>" class="ic">?</span></p>
<div class="row">
<?php
if(isset($_SESSION['nama'])){
$stakom = "Komentar Anda";
$readonly = "";
$stanam = "@".strtolower(str_replace(' ','_',$_SESSION['nama']));
}else{
$stakom = 'Harap <a href="../akses/masuk/'.trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=').'">login</a> dulu!';
$readonly = "readonly";
$stanam = "";
}
?>
<label for="komentar"><?=$stakom;?></span></label>
<textarea filter="<?=trim(base64_encode('|ajar|anji|anjeng|apaan|asu|babi|bahenol|bajingan|banci|bece|bencong|begok|blow|binat|natang|blagu|bokong|cemo|coli|colm|colo|cium|ciuman|cipokan|dada|eek| elu |ellu|elluu|eluu|gelo|gelok|gendeng|gendrowo|genderowo|genjo|goblo|hantu|inde|indih|ingus|ingusan|isap|itil|jilat|juling|julit|kebo|kerbau|kentu|kento|kontol|koco|lidah|ludah|luu|lubang| lo |loo|mabo|mani|memek|menonjol|meki|mesu|monye|mont|m0nt|nabo|nendang|nenen|ngent|ngoco|nyemot|nyepong|onani|orgasme|pantat|payu|peju|pesek|pentil|peler|pler|pincang|puki|sampah|sapi|setan|sek|seks|seksi|slangkang|sepong|sexy|sombong|sok|sokaan|sperma|tabo|nendang|tai |teler|tete|tetek|tetex|tinju|tonjo|<|>|\/|\'|'),'=');?>" name="komentar" id="komentar" placeholder="Tulis komentar Anda" <?=$readonly;?> class="komentar"></textarea>
<div class="error"></div>
</div>
<div class="row btn-cmn">
<input type="hidden" name="target" value="<?=trim(base64_encode($sa['slug_art']),'=');?>" class="target">
<input type="hidden" name="nama" value="<?=$stanam;?>" class="nama">
<button type="reset">Reset</button>
<button type="submit" name="kirim_komentar" class="kirim-komentar">Kirim</button>
</div>
</form>
<div class="list-cmn">
<h5>Komentar <span class="tocom">(<?=$tocom;?>)</span></h5>
<?php
$selCom = mysqli_query($con,"SELECT * FROM tb_art_cmn WHERE slug_art='".$sa['slug_art']."' ORDER BY id_cmn DESC");
if(mysqli_num_rows($selCom) > 0){
while($sc = mysqli_fetch_assoc($selCom)){
?>
<div class="data-cmn" id="<?=str_replace(' ','',str_replace('-','',str_replace(':','',str_replace('|','',$sc['tanggal_cmn']))));?>">
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
<script src="<?=$base_url.'f/s/js/pst.js?version='.filemtime('f/s/js/pst.js');?>"></script>
<?php
}else{
$bts = 9;
$hal = isset($_GET['p'])?(int)$_GET['p']:1;
$awal = ($hal>1)?($hal*$bts)-$bts:0;
$mdr = $hal-1;
$mju = $hal+1;
$getTags = str_replace('-',' ',$_GET['publik']);
$data = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE kategori_art LIKE '%".$getTags."%' ");
$jml = mysqli_num_rows($data);
$total = ceil($jml/$bts);
$selKat = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE kategori_art LIKE '%".$getTags."%' ORDER BY id_art DESC LIMIT $awal, $bts");
if(mysqli_num_rows($selKat) > 0){
if(!isset($_GET['key'])){
echo $slot_one;
}
?>
<div class="links"><a href="<?=$base_url.'artikel/beranda';?>">Beranda</a> / Kategori / <?=ucwords($getTags)." / ".$_GET['p'];?></div>
<?php
while($sk = mysqli_fetch_assoc($selKat)){
if(isset($_GET['p'])){
if(!empty($sk['sampul_art'])){
$sampul = "../../files/images/".$sk['sampul_art'];
}else{
$sampul = "../../f/g/no-image.png";
}
}else{
if(!empty($sk['sampul_art'])){
$sampul = "../files/images/".$sk['sampul_art'];
}else{
$sampul = "../f/g/no-image.png";
}
}
?>
<div class="post-card" target="../<?=$sk['slug_art'];?>">
<div class="card-img">
<img alt="<?=$sk['judul_art'];?>" loading="lazy" src="<?=$sampul;?>" title="<?=$sk['judul_art'];?>"/>
</div>
<h2><?=substr($sk['judul_art'],0,50);?></h2>
</div>
<?php
}
if(isset($_GET['p'])){
$tlink = "";
}else{
$tlink = $getTags."/";
}
if($total > 1){
?>

<div class="pages">
<?php
if($hal > 1){
$link = $tlink.$mdr;
$prev = '<a href="'.$link.'"><span class="link-page">&laquo;</span></a>';
}else{
$prev = '<span class="link-page">&laquo;</span>';
}
echo $prev." ";
$ttl = 3;
if(isset($_GET['p'])){
if($_GET['p'] == 1){
$ttl = 3;
}else{
$ttl = 2;
}
}
$start = ($hal > $ttl)?$hal-$ttl:1;
$end = ($hal < ($total-$ttl))?$hal+$ttl:$total;
$str = $end-$start;
if($total > 4){
if($end == 2){
$end = $end+1;
}else if($end == 3){
$end = $end+2;
}else if($end == 4){
$end = $end+1;
}else if($str == 2){
$start = $start-2;
}else if($str == 3){
$start = $start-1;
}
}
for($p = $start; $p <= $end; $p++){
$active = ($hal==$p)?'active':'';
?>
<a href="<?=$tlink.$p;?>"><span class="link-page <?=$active;?>"><?=$p;?></span></a>
<?php
}
if($hal < $total){
$link = $tlink.$mju;
$next = '<a href="'.$link.'"><span class="link-page">&raquo;</span></a>';
}else{
$next = '<span class="link-page">&raquo;</span>';
}
echo $next;
?>
</div>
<?php
}
?>
<?php
}else{
if(isset($_SESSION['hps_art_h3']) && isset($_SESSION['hps_art_p'])){
$hpsArtH3 = $_SESSION['hps_art_h3'];
$hpsArtP = $_SESSION['hps_art_p'];
$timeout = 1;
$timeout = $timeout * 10;
if(isset($_SESSION['start_session'])){
$eltime = time() - $_SESSION['start_session'];
if($eltime >= $timeout){
$_SESSION['hps_art_h3'] = "";
$_SESSION['hps_art_p'] = "";
unset($_SESSION['hps_art_h3']);
unset($_SESSION['hps_art_p']);
}
}
$_SESSION['start_session'] = time();
}else{
$hpsArtH3 = "Tidak Ditemukan!";
$hpsArtP = "Posting yang Anda cari tidak tersedia, bisa jadi posting telah dihapus atau URL salah!";
}
?>
<div class="tts">
<h3><?=$hpsArtH3;?></h3>
<p><?=$hpsArtP;?>. Silakan muat ulang atau kembali ke <a href="<?=$base_url.'artikel/beranda';?>">halaman utama</a>.</p>
</div>
<?php
}
}
}
?>
</div>
<?php
}
?>
<?php
require 'footer-kons.php';
?>
