<?php
session_start();
require 'conf.php';

// akses keluar
if(isset($_POST['akses_keluar'])){
if(isset($_SESSION['akses'])){
if(isset($_SESSION['uri_ref'])){
$drc = base64_decode($_SESSION['uri_ref']);
}else{
$drc = $base_url."artikel/beranda";
}
$_SESSION['akses'] = "";
$_SESSION['nama'] = "";
$_SESSION['email'] = "";
$_SESSION['levad'] = "";
$_SESSION['uri_ref'] = "";
if(isset($_SESSION['sc'])){
$_SESSION['sc'] = "";
}
unset($_SESSION['akses']);
unset($_SESSION['nama']);
unset($_SESSION['email']);
unset($_SESSION['level']);
unset($_SESSION['uri_ref']);
if(isset($_SESSION['sc'])){
unset($_SESSION['sc']);
}
session_unset();
session_destroy();
$data = array(
'yes' => true,
'drc' => $drc,
);
echo json_encode($data);
}else{
$drc = $base_url;
header("Location: ".$drc);
}
exit;
}

// akses masuk
if(isset($_POST['akses_masuk'])){
if(isset($_SESSION['uri_ref'])){
$drc = base64_decode($_SESSION['uri_ref']);
}else{
$drc = $base_url;
}
$email = htmlentities($_POST['email']);
$sandi = htmlentities($_POST['sandi']);
$cek_email = mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE email='$email' ");
if(mysqli_num_rows($cek_email)==1){
$sd = mysqli_fetch_assoc($cek_email);
if($sd['aktif'] == "aktif"){
if(password_verify($sandi, $sd['sandi'])){
$_SESSION['akses'] = "masuk";
$_SESSION['nama'] = $sd['nama'];
$_SESSION['email'] = $sd['email'];
$_SESSION['levad'] = $sd['level'];
$_SESSION['uri_ref'] = "";
unset($_SESSION['uri_ref']);
$data = array(
'yes' => true,
'drc' => $drc,
);
}else{
$data = array(
'nosan' => true,
'msg' => "Password salah!",
);
}
}else{
$data = array(
'noact' => true,
'eml' => $email,
);
}
}else{
$data = array(
'noem' => true,
'msg' => "Alamat email salah!",
);
}
echo json_encode($data);
exit;
}

// buat akun baru
if(isset($_POST['buat_akun'])){
$email = htmlentities($_POST['email']);
$cek_email = mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE email='$email' ");
if(mysqli_num_rows($cek_email)==1){
$data = array(
'noem' => true,
'msg' => "Alamat email ini sudah digunakan!",
);
}else{
$nama = htmlentities($_POST['nama']);
$psw = htmlentities($_POST['sandi']);
$sandi = password_hash($psw, PASSWORD_DEFAULT);
$registrasi = date('d-m-Y')." ".date('h:i:s');
$master = "master admin";
$cek_master = mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE level='$master' ");
if(mysqli_num_rows($cek_master)==0){
$level = "master admin";
$aktif = "aktif";
}else{
$level = "penulis";
$aktif = "nonaktif";
}
$folder = "f/g/";
if(!empty($_FILES['profil']['name'])){
$nama_asli = $_FILES['profil']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "profile-".strtolower(str_replace(' ','-',$nama))."-".date('his').".".$ext;
$tmp = $_FILES['profil']['tmp_name'];
$set_lebar = 200;
move_uploaded_file($tmp, $simpan);
$profil = $nama_baru;
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
if(!empty($_FILES['profil']['name'])){
unlink($simpan);
}
}else{
$profil = "";
}
$insert = "INSERT INTO tb_akun_bas VALUES(NULL,'$nama','$email','$sandi','$profil','$level','$aktif','$registrasi')";
if(mysqli_query($con, $insert)){
$uri = trim(strtolower(base64_encode("aktivasi-akun-baru")),'=')."/".trim(base64_encode($email),'=');
$aktivasi = $base_url."akses/".$uri;
$from = "no-replay@atakana.com";
$to = $email;
$subject = "Registrasi Atakana.Com (".$email.")";
$body = '<html><body>';
$body .= '<p>Hai '.$nama.'... <br>Pesan ini dikirim otomatis dari halaman form registrasi. Agar akun Anda dapat segera digunakan silakan aktivasi akun Anda melalui link berikut.</p>';
$body .= 'Aktivasi akun '.$aktivasi.'</p>';
$body .= '<p>Note: <br>Jika bukan Anda yang melakukannya, tolong abaikan atau hapus saja pesan ini.</p>';
$body .= '<p>Mohon tidak membalas pesan ini!</p>';
$body .= '<p>Terima Kasih <br><a href="'.$base_url.'">atakana.com</a></p>';
$body .= '</body></html>';
$headers = "From: Aktivasi Akun <".$from.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$send = mail($to,$subject,$body,$headers);
if($send == true){
$_SESSION['sc'] = '<p style="color:green;font-weight:bold">Berhasil ✓</p><p>Selamat Akun Anda berhasil diregistrasi. Silakan lakukan aktivasi akun Anda agar dapat segera digunakan.</p><p>Pesan aktivasi telah dikirimkan ke alamat email <span style="color:green">'.$email.'</span>, silakan periksa kotak masuk atau bagian spam.<p>';
$data = array(
'yes' => true,
'drc' => $base_url.'akses/'.trim(base64_encode("notif-sukses"),'=')
);
}
}else{
$data = array(
'no' => true,
'msg' => "Gagal proses data!",
);
}
}
echo json_encode($data);
exit;
}

// kirim ulang aktivasi akun
if(isset($_POST['kirim_ulang_aktivasi_akun'])){
$email = $_POST['target'];
$selData = mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE email='$email' ");
if(mysqli_num_rows($selData) == 1){
$dt = mysqli_fetch_assoc($selData);
$nama = $dt['nama'];
}else{
$nama = "Pengguna";
}
$uri = trim(strtolower(base64_encode("aktivasi-akun-baru")),'=')."/".trim(base64_encode($email),'=');
$aktivasi = $base_url."akses/".$uri;
$from = "no-replay@atakana.com";
$to = $email;
$subject = "Permintaan Ulang Atakana.Com (".$email.")";
$body = '<html><body>';
$body .= '<p>Hai '.$nama.'... <br>Ini adalah permintaan ulang aktivasi akun Anda.<br>Agar akun Anda dapat segera digunakan silakan aktivasi akun Anda melalui link berikut.</p>';
$body .= '<p>Aktivasi akun '.$aktivasi.'</p>';
$body .= '<p>Note:<br>Jika bukan Anda yang melakukannya, tolong abaikan atau hapus saja pesan ini.</p>';
$body .= '<p>Mohon tidak membalas pesan ini!</p>';
$body .= '<p>Terima Kasih<br><a href="'.$base_url.'">atakana.com</a></p>';
$body .= '</body></html>';
$headers = "From: Aktivasi Akun <".$from.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$send = mail($to,$subject,$body,$headers);
if($send == true){
$data = array(
'yes' => true,
'msg' => "Sukses ✓\nPermintaan ulang link aktivasi akun berhasil terkirim. Silakan periksa kotak masuk atau bagian spam alamat email Anda.\n\nTerima kasih.",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal! Coba kirim lagi!",
);
}
echo json_encode($data);
exit;
}

// aktivasi akun baru
if(isset($_POST['aktivasi_akun_baru'])){
$email = $_POST['email'];
$cek_data = mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE email='$email' ");
if(mysqli_num_rows($cek_data)==1){
$dt = mysqli_fetch_assoc($cek_data);
$aktivasi = $dt['aktif'];
if($aktivasi == "" || $aktivasi == "nonaktif"){
$aktif = "aktif";
$update = "UPDATE tb_akun_bas SET aktif='$aktif' WHERE email='$email' ";
if(mysqli_query($con, $update)){
$data = array(
'yes' => true,
'msg' => '<div style="text-align:center"><h5 style="color:green;margin:30px 0">Berhasil ✓</h5><p>Selamat akun Anda sekarang sudah aktif dan siap untuk digunakan.</p><p>Silakan klik <a href="'.$base_url.'akses/masuk">disini.</a></p></div>',
);
}else{
$data = array(
'no' => true,
'msg' => "Maaf terjadi kesalahan. Gagal melakukan aktivasi, silakan coba lagi!",
);
}
}else if($aktivasi == "aktif"){
$data = array(
'aktif' => true,
'msg' => '<h5 style="color:green;margin:150px 0 30px">Akun Aktif</h5><p>Akun Anda sudah aktif dan siap digunakan, silakan <a href="'.$base_url.'akses/masuk">login.</a></p>',
);
}
}else{
$data = array(
'no' => true,
'msg' => "Maaf tidak dapat melakukan aktivasi, akun Anda belum terdaftar!",
);
}
echo json_encode($data);
exit;
}

// konfirmasi email
if(isset($_POST['konfirmasi_email'])){
$email = htmlentities($_POST['email']);
$cek_email = mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE email='$email' ");
if(mysqli_num_rows($cek_email)==1){
$_SESSION['ek'] = base64_encode($email);
$uri = "sandi-baru";
$dt = mysqli_fetch_assoc($cek_email);
$nama = $dt['nama'];
$konfirmasi = $base_url."akses/".trim(strtolower(base64_encode($uri)),'=');
$from = "no-replay@atakana.com";
$to = $email;
$subject = "Permintaan Password Baru (".$email.")";
$body = '<html><body>';
$body .= '<p>Hai '.$nama.'... <br>Jika memang Anda yakin ingin ganti password, silakan klik link berikut.</p>';
$body .= '<p>Ganti password '.$konfirmasi.'</p>';
$body .= '<p>Note:<br>Jika bukan Anda yang melakukannya, tolong abaikan atau hapus saja pesan ini.</p>';
$body .= '<p>Mohon tidak membalas pesan ini!</p>';
$body .= '<p>Terima Kasih<br><a href="'.$base_url.'">atakana.com</a></p>';
$body .= '</body></html>';
$headers = "From: Konfirmasi Ganti Password <".$from.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$send = mail($to,$subject,$body,$headers);
if($send == true){
$data = array(
'yes' => true,
'msg' => '<p>Pesan konfirmasi telah dikirim otomatis ke alamat alamat email <span style="color:green">'.$email.'</span> silakan periksa kotak masuk atau bagian spam alamat email Anda.</p><p>Jika belum menerima alamat email konfirmasi coba kirim ulang dengan klik tombol Konfirmasi pada form dibawah.</p>',
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal konfirmasi email, silakan coba kembali!",
);
}
}else{
$data = array(
'no' => true,
'msg' => "Alamat email ini belum terdaftar!",
);
}
echo json_encode($data);
exit;
}

// simpan sandi baru
if(isset($_POST['simpan_sandi_baru'])){
if(isset($_SESSION['ek'])){
$email = base64_decode($_POST['email']);
$psw = htmlentities($_POST['sandi']);
$sandi = password_hash($psw, PASSWORD_DEFAULT);
$update = "UPDATE tb_akun_bas SET sandi='$sandi' WHERE email='$email' ";
if(mysqli_query($con, $update)){
$_SESSION['ek'] = "";
unset($_SESSION['ek']);
$data = array(
'yes' => true,
'drc' => $base_url."akses/masuk",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal proses data!",
);
}
}else{
$data = array(
'noses' => true,
'msg' => '<p style="color:brown;font-weight:bold">Sesi Sudah Berakhir!</p><p>Agar dapat mengganti password baru silakan konfirmasi ulang alamat email Anda disini <a href="konfirmasi-email">disini</a>.</p>',
);
}
echo json_encode($data);
exit;
}

// bagian dashboard

// simpan pembaruan web
if(isset($_POST['simpan_pembaruan_web'])){
$id = 1;
$nama = htmlentities($_POST['nama']);
$deskripsi = htmlentities($_POST['deskripsi']);
$selweb = mysqli_query($con,"SELECT * FROM tb_web_bas");
if(mysqli_num_rows($selweb) == 0){
$register = date('d-m-Y')." ".date('h:i:s');
$update = "";
$insert = "INSERT INTO tb_web_bas VALUES('$id','$nama','$deskripsi','$registrasi','$update')";
if(mysqli_query($con, $insert)){
$data = array(
'yes' => true,
'msg' => "Berhasil menyimpan nama dan deskripsi web",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal proses data!",
);
}
}else{
$perubahan = date('d-m-Y')." ".date('h:i:s');
$update = "UPDATE tb_web_bas SET nama_web='$nama', deskripsi_web='$deskripsi', update_web='$perubahan' ";
if(mysqli_query($con, $update)){
$data = array(
'yes' => true,
'msg' => "Perubahan berhasil disimpan",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal update data!",
);
}
}
echo json_encode($data);
exit;
}

// ganti satus admin
if(isset($_POST['set_status_admin'])){
$email = base64_decode($_POST['data_status']);
$sts = base64_decode($_POST['data_target']);
if($sts == "aktif"){
$aktif = "nonaktif";
}else if($sts == "nonaktif"){
$aktif = "aktif";
}else if($sts == ""){
$aktif = "nonaktif";
}
$simpan = "UPDATE tb_akun_bas SET aktif='$aktif' WHERE email='$email' ";
if(mysqli_query($con, $simpan)){
$data = array(
'yes' => true,
'msg' => "Berhasil ganti status",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal ganti status!",
);
}
echo json_encode($data);
exit;
}

// ganti level admin
if(isset($_POST['set_level_admin'])){
$email = base64_decode($_POST['data_level']);
$level = base64_decode($_POST['data_target']);
$simpan = "UPDATE tb_akun_bas SET level='$level' WHERE email='$email' ";
if(mysqli_query($con, $simpan)){
$data = array(
'yes' => true,
'msg' => "Berhasil ganti hak akses",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal ganti hak akses!",
);
}
echo json_encode($data);
exit;
}

// edit akun
if(isset($_POST['simpan_perubahan_akun'])){
$eml = $_SESSION['email'];
$selUser = mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE email='$eml' ");
if(mysqli_num_rows($selUser) == 1){
$dt = mysqli_fetch_assoc($selUser);
$san = $dt['sandi'];
$pro = $dt['profil'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$psw = $_POST['sandi'];
if($psw == ""){
$sandi = $san;
}else{
$sandi = password_hash($psw, PASSWORD_DEFAULT);
}
$folder = "f/g/";
if(!empty($_FILES['profil']['name'])){
$nama_asli = $_FILES['profil']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "profile-".strtolower(str_replace(' ','-',$nama))."-".date('his').".".$ext;
$tmp = $_FILES['profil']['tmp_name'];
$set_lebar = 200;
move_uploaded_file($tmp, $simpan);
$profil = $nama_baru;
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
if(!empty($_FILES['profil']['name'])){
unlink($simpan);
}
}else{
$profil = $pro;
}
$simpan = "UPDATE tb_akun_bas SET nama='$nama', email='$email', sandi='$sandi', profil='$profil' WHERE email='$eml' ";
if(mysqli_query($con, $simpan)){
$drc = "../".trim(base64_encode('detail-akun'),'=').'/'.trim(base64_encode($email),'=');
$data = array(
'yes' => true,
'msg' => "Perubahan berhasil disimpan",
'drc' => $drc,
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal simpan perubahan akun!",
);
}
}
echo json_encode($data);
exit;
}

// hapus akun
if(isset($_POST['hapus_akun'])){
$target = $_POST['target'];
$dataAkun = mysqli_query($con,"SELECT * FROM tb_akun_bas WHERE email='$target' ");
if(mysqli_num_rows($dataAkun) == 1){
$da = mysqli_fetch_assoc($dataAkun);
$path = "f/g/";
$img = $da['profil'];
$profil = $path.$img;
$hapus = "DELETE FROM tb_akun_bas WHERE email='$target' ";
if(mysqli_query($con,$hapus)){
if($img != ""){
unlink($profil);
}
$data = array(
'yes' => true,
'msg' => "Akun berhasil dihapus",
'drc' => $base_url.'kelola/'.trim(base64_encode('data-akun'),'='),
);
}else{
$data = array(
'no' => true,
'msg' => "Akun gagal dihapus! Silakan coba kembali.\n\nTerima kasih.",
);
}
}else{
$data = array(
'no' => true,
'msg' => "Tidak dapat menghapus akun, silakan coba beberapa saat lagi.\n\nTerima kasih.",
);
}
echo json_encode($data);
exit;
}

//saran pencarian
if(isset($_POST['suggest'])){
$data = "";
$key = $_POST['key'];
$selData = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE judul_art LIKE '%".$key."%' OR kategori_art LIKE '%".$key."%' ");
if(mysqli_num_rows($selData) > 0){
$data = '
<a href="'.$base_url.'artikel/beranda/1/'.str_replace(' ','-',strtolower($key)).'"><li class="data-list">'.$key.'</li></a>
';
while($dt = mysqli_fetch_assoc($selData)){
$data .= '
<a href="'.$base_url.'artikel/'.$dt['slug_art'].'"><li class="data-list">'.strtolower($dt['judul_art']).'</li></a>
';
}
}else{
$data = '
<a><li class="no-list">Tidak ditemukan!</li></a>
';
}
echo json_encode($data);
exit;
}

// terbitkan artikel baru
if(isset($_POST['terbitkan_artikel_baru'])){
if(isset($_SESSION['id'])){
$id = $_SESSION['id'];
}else{
$id = "";
}
$slug = htmlentities($_POST['uerel']);
$cekSlugArt = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
if(mysqli_num_rows($cekSlugArt) == 0){
//jika cekSlugArt = 0, maka artikel di draft
$sem = $_SESSION['email'];
$cekSlugDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' AND email_art<>'$sem' ");
if(mysqli_num_rows($cekSlugDraft) == 0){
//jika cekSlugDraft = 0, maka terbitkan artikel
$judul = htmlentities($_POST['judul']);
$isi = $_POST['isi'];
$deskripsi = htmlentities($_POST['deskripsi']);
$kategori = htmlentities($_POST['kategori']);
$penulis = $_SESSION['nama'];
$empe = $_SESSION['email'];
$terbit = date('d-m-Y')." | ".date('h:i');
$update = "";
$folder = "files/images/";
if(!empty($_FILES['sampul']['name'])){
$nama_asli = $_FILES['sampul']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "sampul-".$slug."-upload-by-".strtolower(str_replace(' ','-',$penulis))."-".date('his').".".$ext;
$tmp = $_FILES['sampul']['tmp_name'];
$set_lebar = 728;
move_uploaded_file($tmp, $simpan);
$sampul = $nama_baru;
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
if(!empty($_FILES['sampul']['name'])){
unlink($simpan);
}
}else{
$sampul = "";
}
$terbitkan = "INSERT INTO tb_art_bas VALUES(NULL,'$slug','$judul','$sampul','$isi','$deskripsi','$kategori','$penulis','$empe','$terbit','$update')";
if(mysqli_query($con, $terbitkan)){
//jika berhasil diterbitkan, maka hapus data yang ada di draft berdasarkan slug dan email yang diterbitkan
$cekDataDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE id_art='$id' ");
if(mysqli_num_rows($cekDataDraft) == 1){
$hapus = "DELETE FROM tb_art_draft WHERE id_art='$id' ";
if(mysqli_query($con, $hapus)){
$dt = mysqli_fetch_assoc($cekDataDraft);
if($dt['sampul_art'] != ""){
unlink($folder.$dt['sampul_art']);
}
// proses posting ke email
$selArtBas = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
if(mysqli_num_rows($selArtBas) == 1){
$sab = mysqli_fetch_assoc($selArtBas);
$detail = '<html><body>';
$detail .= '<p>Ada posting terbaru dari '.$penulis.' yang berjudul '.$sab['judul_art'].'.</p>';
$detail .= '<p>'.$penulis.' menerbitkan:<br>'.$judul.'<br>'.$deskripsi.'</p>';
$detail .= '<p>Lihat posting '.$base_url.'artikel/'.$slug.'</p>';
$detail .= '<p>Terima Kasih<br><a href="'.$base_url.'artikel/beranda">atakana.com</a></p>';
$detail .= '</body></html>';
}
$subject = $judul;
$from = "no-replay@atakana.com";
$body = $detail;
$headers = "From: Posting Terbaru Atakana.Com <".$from.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$selSubsEm = mysqli_query($con,"SELECT * FROM tb_subs_em");
if(mysqli_num_rows($selSubsEm) > 0){
while($sse = mysqli_fetch_array($selSubsEm)){
$dataSubsEm [] = $sse['email'];
}
foreach($dataSubsEm AS $to){
mail($to,$subject,$body,$headers);
}
}
// end proses posting ke email
$data = array(
'yes' => true,
'href' => $base_url.'artikel/'.$slug,
);
}
}else{//else num rows cekDataDraft
// proses posting ke email
$selArtBas = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
if(mysqli_num_rows($selArtBas) == 1){
$sab = mysqli_fetch_assoc($selArtBas);
$detail = '<html><body>';
$detail .= '<p>Ada posting terbaru dari '.$penulis.' yang berjudul '.$sab['judul_art'].'.</p>';
$detail .= '<p>'.$penulis.' menerbitkan:<br>.'.$judul.'<br>'.$deskripsi.'</p>';
$detail .= '<p>Lihat posting '.$base_url.'artikel/'.$slug.'</p>';
$detail .= '<p>Terima Kasih<br><a href="'.$base_url.'artikel/beranda">atakana.com</a></p>';
$detail .= '</body></html>';
}
$subject = $judul;
$from = "no-replay@atakana.com";
$body = $detail;
$headers = "From: Posting Terbaru Atakana.Com <".$from.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$selSubsEm = mysqli_query($con,"SELECT * FROM tb_subs_em");
if(mysqli_num_rows($selSubsEm) > 0){
while($sse = mysqli_fetch_array($selSubsEm)){
$dataSubsEm [] = $sse['email'];
}
foreach($dataSubsEm AS $to){
mail($to,$subject,$body,$headers);
}
}
// end proses posting ke email
$data = array(
'yes' => true,
'href' => $base_url.'artikel/'.$slug,
);
}//tutup else num rows cekDataDraft
}else{
$data = array(
'no' => true,
'msg' => "Posting gagal diterbitkan!",
);
}
}else{//else num rows cekSlugDraft
$data = array(
'no' => true,
'msg' => "Posting dengan judul yang sama sudah pernah ditulis admin lain dan tersimpan di draft! Coba dengan judul atau topik berbeda.\n\nTerima kasih.",
);
}
}else{//else num rows cekSlugArt
//jika cekSlugArt = 1, maka cekPenArt
$cekPenArt = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
if(mysqli_num_rows($cekPenArt) == 1){
$cpa = mysqli_fetch_assoc($cekPenArt);
if($cpa['email_art'] == $_SESSION['email']){
$penart = "Anda terbitkan sebelumnya";
}else{
$penart = "diterbitkan oleh admin ".$cpa['penulis_art'];
}
}else{//else num rows cekPenArt
$penart = "diterbitkan sebelumnya";
}//tutup else num rows cekPenArt
$data = array(
'no' => true,
'msg' => "Posting dengan judul yang sama sudah pernah ".$penart."! Coba dengan judul atau topik berbeda.\n\nTerima kasih.",
);
}//tutup else num rows cekSlugArt
echo json_encode($data);
exit;
}

// edit artikel
if(isset($_POST['edit_artikel'])){
$slug = htmlentities($_POST['uerel']);
$judul = htmlentities($_POST['judul']);
$isi = $_POST['isi'];
$deskripsi = htmlentities($_POST['deskripsi']);
$kategori = htmlentities($_POST['kategori']);
$perbarui = date('d-m-Y')." | ".date('h:i');
if(!empty($_FILES['sampul']['name'])){
$folder = "files/images/";
$nama_asli = $_FILES['sampul']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "sampul-".$slug."-upload-by-".strtolower(str_replace(' ','-',$_SESSION['nama']))."-".date('his').".".$ext;
$sampul = $nama_baru;
$tmp = $_FILES['sampul']['tmp_name'];
$set_lebar = 728;
move_uploaded_file($tmp, $simpan);
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
if(!empty($_FILES['sampul']['name'])){
unlink($simpan);
}
$folder2 = "files/images/";
$selGam2 = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
$sg2 = mysqli_fetch_assoc($selGam2);
$sampul2 = $sg2['sampul_art'];
if($sg2['sampul_art'] != ""){
unlink($folder2.$sampul2);
}
}else{
$selGam = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
$sg = mysqli_fetch_assoc($selGam);
$sampul = $sg['sampul_art'];
}
$update = "UPDATE tb_art_bas SET judul_art='$judul', sampul_art='$sampul', isi_art='$isi', deskripsi_art='$deskripsi', kategori_art='$kategori', update_art='$perbarui' WHERE slug_art='$slug' ";
if(mysqli_query($con, $update)){
$data = array(
'yes' => true,
'href' => $base_url.'artikel/'.$slug,
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal memperbarui posting!",
);
}
echo json_encode($data);
exit;
}

// simpan ke draft
if(isset($_POST['simpan_ke_draft'])){
$slug = $_POST['uerel'];
$judul = htmlentities($_POST['judul']);
$isi = $_POST['isi'];
$deskripsi = htmlentities($_POST['deskripsi']);
$kategori = htmlentities($_POST['kategori']);
$penulis = $_SESSION['nama'];
$email = $_SESSION['email'];
$terbit = date('d-m-Y')." | ".date('h:i');
$update = date('d-m-Y')." | ".date('h:i');
$folder = "files/images/";
if(isset($_SESSION['id'])){
$id = $_SESSION['id'];
}else{
$id = "";
}
$cekTabArt = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
if(mysqli_num_rows($cekTabArt) == 0){
//jika slug di tabel artikel kosong
$cekTabDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' ");
if(mysqli_num_rows($cekTabDraft) == 0){
//jika slug di tabel draft kosong
$cekId = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE id_art='$id' ");
if(mysqli_num_rows($cekId) == 0){
//jika cekId = 0, maka simpan artikel baru ke draft
if(!empty($_FILES['sampul']['name'])){
$nama_asli = $_FILES['sampul']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "sampul-".$slug."-upload-by-".strtolower(str_replace(' ','-',$penulis))."-".date('his').".".$ext;
$tmp = $_FILES['sampul']['tmp_name'];
$set_lebar = 728;
move_uploaded_file($tmp, $simpan);
$sampul = $nama_baru;
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
if(!empty($_FILES['sampul']['name'])){
unlink($simpan);
}
}else{
$sampul = "";
}
$simpan = "INSERT INTO tb_art_draft VALUES(NULL,'$slug','$judul','$sampul','$isi','$deskripsi','$kategori','$penulis','$email','$terbit','$update')";
if(mysqli_query($con, $simpan)){
$selDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' ");
$sd = mysqli_fetch_assoc($selDraft);
$_SESSION['id'] = $sd['id_art'];
$data = array(
'yes' => true,
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal menyimpan ke draft!",
);
}
}else{//else num rows cekId
//jika cekId = 1, maka simpan perubahan ke draft berdasarkan id
if(!empty($_FILES['sampul']['name'])){
$nama_asli = $_FILES['sampul']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "sampul-".$slug."-upload-by-".strtolower(str_replace(' ','-',$_SESSION['nama']))."-".date('his').".".$ext;
$sampul = $nama_baru;
$tmp = $_FILES['sampul']['tmp_name'];
$set_lebar = 728;
move_uploaded_file($tmp, $simpan);
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
if(!empty($_FILES['sampul']['name'])){
unlink($simpan);
}
$folder2 = "files/images/";
$selGam2 = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE id_art='$id' ");
$sg2 = mysqli_fetch_assoc($selGam2);
$sampul2 = $sg2['sampul_art'];
if($sg2['sampul_art'] != ""){
unlink($folder2.$sampul2);
}
}else{
$selGam = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE id_art='$id' ");
$sg = mysqli_fetch_assoc($selGam);
$sampul = $sg['sampul_art'];
}
$perbarui = "UPDATE tb_art_draft SET slug_art='$slug', judul_art='$judul', sampul_art='$sampul', isi_art='$isi', deskripsi_art='$deskripsi', kategori_art='$kategori', update_art='$update' WHERE id_art='$id' ";
if(mysqli_query($con, $perbarui)){
$data = array(
'yes' => true,
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal menyimpan perubahan!",
);
}
}//tutup else num rows cekId
}else{//else num rows cekTabDraft
//jika slug di tabel draft tidak kosong
$cekEmailDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' AND email_art='$email' ");
if(mysqli_num_rows($cekEmailDraft) == 1){
//jika cekEmailDraft = 1, maka simpan perubahan ke draft berdasarkan slug
if(!empty($_FILES['sampul']['name'])){
$nama_asli = $_FILES['sampul']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "sampul-".$slug."-upload-by-".strtolower(str_replace(' ','-',$_SESSION['nama']))."-".date('his').".".$ext;
$sampul = $nama_baru;
$tmp = $_FILES['sampul']['tmp_name'];
$set_lebar = 728;
move_uploaded_file($tmp, $simpan);
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
if(!empty($_FILES['sampul']['name'])){
unlink($simpan);
}
$folder2 = "files/images/";
$selGam2 = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' ");
$sg2 = mysqli_fetch_assoc($selGam2);
$sampul2 = $sg2['sampul_art'];
if($sg2['sampul_art'] != ""){
unlink($folder2.$sampul2);
}
}else{
$selGam = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' ");
$sg = mysqli_fetch_assoc($selGam);
$sampul = $sg['sampul_art'];
}
$perbarui = "UPDATE tb_art_draft SET slug_art='$slug', judul_art='$judul', sampul_art='$sampul', isi_art='$isi', deskripsi_art='$deskripsi', kategori_art='$kategori', update_art='$update' WHERE slug_art='$slug' ";
if(mysqli_query($con, $perbarui)){
$selDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' ");
$sd = mysqli_fetch_assoc($selDraft);
$_SESSION['id'] = $sd['id_art'];
$data = array(
'yes' => true,
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal menyimpan perubahan!",
);
}
}else{//else num rows cekEmailDraft
//jika cekEmailDraft = 0
$data = array(
'no' => true,
'msg' => "Posting dengan judul yang sama sudah pernah ditulis admin lain, dan tersimpan di draft! Coba dengan judul atau topik berbeda.\n\nTerima kasih.",
);
}//tutup else num rows cekEmailDraft
}//tutup else num rows cekTabDraft
}else{//else num rows cekTabArt
//jika slug di tabel artikel tidak kosong
$data = array(
'no' => true,
'msg' => "Posting dengan judul yang sama sudah pernah diterbitkan! Coba tulis dengan judul atau topik berbeda.\n\nTerima kasih.",
);
}//tutup else num rows cekTabArt
echo json_encode($data);
exit;
}

// simpan edit ke draft
if(isset($_POST['simpan_edit_ke_draft'])){
$slug = htmlentities($_POST['uerel']);
$judul = htmlentities($_POST['judul']);
$isi = $_POST['isi'];
$deskripsi = htmlentities($_POST['deskripsi']);
$kategori = htmlentities($_POST['kategori']);
$penulis = $_SESSION['nama'];
$email = $_SESSION['email'];
$update = date('d-m-Y')." | ".date('h:i');
$folder = "files/images/";
$cekArtDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' ");
if(mysqli_num_rows($cekArtDraft) == 0){
$cekSlugArt = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' AND email_art='$email' ");
if(mysqli_num_rows($cekSlugArt) == 0){
$selArt = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
$sa = mysqli_fetch_assoc($selArt);
$sampul = $sa['sampul_art'];
$sampul2 = $sampul;
$terbit = $sa['terbit_art'];
if(!empty($_FILES['sampul']['name'])){
$nama_asli = $_FILES['sampul']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "sampul-".$slug."-upload-by-".strtolower(str_replace(' ','-',$_SESSION['nama']))."-".date('his').".".$ext;
$sampul = $nama_baru;
$tmp = $_FILES['sampul']['tmp_name'];
$set_lebar = 728;
move_uploaded_file($tmp, $simpan);
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
unlink($simpan);
$folder2 = "files/images/";
unlink($folder2.$sampul2);
}
$simpan = "INSERT INTO tb_art_draft VALUES(NULL,'$slug','$judul','$sampul','$isi','$deskripsi','$kategori','$penulis','$email','$terbit','$update')";
if(mysqli_query($con, $simpan)){
$data = array(
'yes' => true,
'drc' => $base_url."kelola/".trim(base64_encode('edit-draft'),'=')."/".trim(base64_encode($slug),'='),
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal menyimpan ke draft!",
);
}
}else{//else num rows cekSlugArt
$csa = mysqli_fetch_assoc($cekSlugArt);
$id = $csa['id_art'];
$terbit = $csa['terbit_art'];
$update = $csa['update_art'];
$sampul = $csa['sampul_art'];
$sampul2 = $sampul;
$hapus = "DELETE FROM tb_art_bas WHERE id_art='$id' AND slug_art='$slug' ";
if(mysqli_query($con, $hapus)){
if(!empty($_FILES['sampul']['name'])){
$nama_asli = $_FILES['sampul']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "sampul-".$slug."-upload-by-".strtolower(str_replace(' ','-',$_SESSION['nama']))."-".date('his').".".$ext;
$sampul = $nama_baru;
$tmp = $_FILES['sampul']['tmp_name'];
$set_lebar = 728;
move_uploaded_file($tmp, $simpan);
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
unlink($simpan);
unlink($folder.$sampul2);
}else{
$sampul = $sampul;
}
$simpan = "INSERT INTO tb_art_draft VALUES(NULL,'$slug','$judul','$sampul','$isi','$deskripsi','$kategori','$penulis','$email','$terbit','$update')";
if(mysqli_query($con, $simpan)){
$data = array(
'yes' => true,
'drc' => $base_url."kelola/".trim(base64_encode('edit-draft'),'=')."/".trim(base64_encode($slug),'='),
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal menyimpan ke draft!",
);
}
}else{
$data = array(
'no' => true,
'msg' => "Gagal menyimpan ke draft!",
);
}
}//tutup else num rows cekSlugArt
}else{//else num rows cekArtDraft
$cad = mysqli_fetch_assoc($cekArtDraft);
if($cad['email_art'] == $_SESSION['email']){
$penart = "Anda";
}else{
$penart = $cad['penulis_art'];
}
$data = array(
'no' => true,
'msg' => "Posting dengan judul yang sama sudah ada dan tersimpan di draft! Ditulis dan disimpan oleh ".$penart.".\n\nTerima kasih.",
);
}//tutup else num rows cekArtDraft
echo json_encode($data);
exit;
}

// simpan pembaruan draft
if(isset($_POST['simpan_pembaruan_draft'])){
$slug = htmlentities($_POST['uerel']);
$judul = htmlentities($_POST['judul']);
$isi = $_POST['isi'];
$deskripsi = htmlentities($_POST['deskripsi']);
$kategori = htmlentities($_POST['kategori']);
$email = $_SESSION['email'];
if(!empty($_FILES['sampul']['name'])){
$folder = "files/images/";
$nama_asli = $_FILES['sampul']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "sampul-".$slug."-upload-by-".strtolower(str_replace(' ','-',$_SESSION['nama']))."-".date('his').".".$ext;
$sampul = $nama_baru;
$tmp = $_FILES['sampul']['tmp_name'];
$set_lebar = 728;
move_uploaded_file($tmp, $simpan);
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
if(!empty($_FILES['sampul']['name'])){
unlink($simpan);
}
$folder2 = "files/images/";
$selGam2 = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' ");
if(mysqli_num_rows($selGam2) == 1){
$sg2 = mysqli_fetch_assoc($selGam2);
$sampul2 = $sg2['sampul_art'];
if($sg2['sampul_art'] != ""){
unlink($folder2.$sampul2);
}
}
}else{
$selGam = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' ");
$sg = mysqli_fetch_assoc($selGam);
$sampul = $sg['sampul_art'];
}
$simpan = "UPDATE tb_art_draft SET judul_art='$judul', sampul_art='$sampul', isi_art='$isi', deskripsi_art='$deskripsi', kategori_art='$kategori' WHERE slug_art='$slug' AND email_art='$email' ";
if(mysqli_query($con, $simpan)){
$data = array(
'yes' => true,
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal menyimpan!",
);
}
echo json_encode($data);
exit;
}

// terbitkan draft
if(isset($_POST['terbitkan_draft'])){
$sql = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='".$_POST['uerel']."' AND email_art='".$_SESSION['email']."' ");
$sql2 = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='".$_POST['uerel']."' ");
if(mysqli_num_rows($sql2) == 0){
$dt = mysqli_fetch_assoc($sql);
$slug = htmlentities($_POST['uerel']);
$judul = htmlentities($_POST['judul']);
$isi = $_POST['isi'];
$deskripsi = htmlentities($_POST['deskripsi']);
$kategori = htmlentities($_POST['kategori']);
$penulis = $_SESSION['nama'];
$email = $_SESSION['email'];
$terbit = $dt['terbit_art'];
$update = date('d-m-Y')." | ".date('h:i');
$sampul = $dt['sampul_art'];
$sampul2 = $sampul;
if(!empty($_FILES['sampul']['name'])){
$folder = "files/images/";
$nama_asli = $_FILES['sampul']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "sampul-".$slug."-upload-by-".strtolower(str_replace(' ','-',$penulis))."-".date('his').".".$ext;
$sampul = $nama_baru;
$tmp = $_FILES['sampul']['tmp_name'];
$set_lebar = 728;
move_uploaded_file($tmp, $simpan);
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
unlink($simpan);
$folder2 = "files/images/";
unlink($folder2.$sampul2);
}
$terbitkan = "INSERT INTO tb_art_bas VALUES(NULL,'$slug','$judul','$sampul','$isi','$deskripsi','$kategori','$penulis','$email','$terbit','$update')";
if(mysqli_query($con, $terbitkan)){
$hapus = mysqli_query($con,"DELETE FROM tb_art_draft WHERE slug_art='$slug' AND email_art='$email' ");
$data = array(
'yes' => true,
'drc' => $base_url.'artikel/'.$slug,
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal diterbitkan!",
);
}
}else{
$data = array(
'no' => true,
'msg' => "Posting dengan judul yang sama sudah pernah diterbitkan. Coba tulis dengan judul atau topik berbeda.\n\nTerima kasih.",
);
}
echo json_encode($data);
exit;
}

// preview post
if(isset($_POST['preview_post'])){
$slug = htmlentities($_POST['uerel']);
$selDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' AND email_art='".$_SESSION['email']."' ");
if(mysqli_num_rows($selDraft) == 1){
$data = array(
'yes' => true,
'drc' => $base_url."p/a/".trim(base64_encode($slug),'=')."/".trim(base64_encode($_SESSION['email']),'='),
);
}else{
$data = array(
'no' => true,
'msg' => "Harap disimpan dulu!",
);
}
echo json_encode($data);
exit;
}

// upload gambar
if(isset($_POST['upload_gambar_artikel'])){
$by = strtolower(str_replace(' ','-',$_SESSION['nama']));
$nama = htmlentities($_POST['nama']);
$cekNama = mysqli_query($con,"SELECT * FROM tb_gam_art WHERE nama='$nama' ");
if(mysqli_num_rows($cekNama) == 1){
$data = array(
'no' => true,
'msg' => "Nama gambar ini sudah digunakan sebelumnya! Coba koreksi dan upload kembali.",
);
}else{
$folder = "data/file/img/";
$nama_asli = $_FILES['gambar']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = strtolower(str_replace(' ','-',$nama))."-upload-by-".strtolower(str_replace(' ','-',$by))."-".date('his').".".$ext;
$gambar = $nama_baru;
$tmp = $_FILES['gambar']['tmp_name'];
$set_lebar = 728;
move_uploaded_file($tmp, $simpan);
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
if(!empty($_FILES['gambar']['name'])){
unlink($simpan);
}
$insert = "INSERT INTO tb_gam_art VALUES(NULL,'$nama','$gambar')";
if(mysqli_query($con, $insert)){
$data = array(
'yes' => true,
'msg' => "Gambar berhasil diupload",
'drc' => $base_url."files/".trim(base64_encode("copas_data_gambar"),'=')."/".trim(base64_encode($nama_baru),'='),
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal upload gambar!",
);
}
}
echo json_encode($data);
exit;
}

// lihat kode dan gambar
if(isset($_POST['view_ci'])){
$target = base64_decode($_POST['data_ci']);
$data = array(
'yes' => true,
'drc' => $base_url."files/".trim(base64_encode("copas_data_gambar"),'=')."/".trim(base64_encode($target),'='),
);
echo json_encode($data);
exit;
}

// hapus gambar target
if(isset($_POST['hapus_gambar_target'])){
$target = base64_decode($_POST['data_ci']);
$hapusTarget = "data/file/img/".$target;
$hapus = "DELETE FROM tb_gam_art WHERE gambar='$target' ";
if(mysqli_query($con, $hapus)){
if($target != ""){
unlink($hapusTarget);
}
$data = array(
'yes' => true,
'msg' => "Gambar berhasil dihapus",
);
}else{
$data = array(
'no' => true,
'msg' => "Gambar gagal dihapus!",
);
}
echo json_encode($data);
exit;
}

// hapus artikel
if(isset($_POST['hapus_artikel'])){
$slug = $_POST['url'];
$selArtikel = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
if(mysqli_num_rows($selArtikel) == 1){
$sa = mysqli_fetch_assoc($selArtikel);
$slug_art = $sa['slug_art'];
$sampul_art = "files/images/".$sa['sampul_art'];
$hapus = "DELETE FROM tb_art_bas WHERE slug_art='$slug_art' ";
if(mysqli_query($con, $hapus)){
$_SESSION['hps_art_h3'] = "Sukses ✓";
$_SESSION['hps_art_p'] = "Posting berhasil dihapus";
if($sa['sampul_art'] != ""){
unlink($sampul_art);
}
$data = array(
'yes' => true,
'msg' => "Posting berhasil dihapus",
'drc' => $base_url.'artikel/'.$slug,
);
}else{
$data = array(
'no' => true,
'msg' => "Posting gagal dihapus!",
);
}
}else{
$data = array(
'no' => true,
'msg' => "Maaf terjadi kesalahan tak terduga, silakan coba lagi!",
);
}
echo json_encode($data);
exit;
}

// hapus draft
if(isset($_POST['hapus_draft'])){
$slug = $_POST['uerel'];
$selDraft = mysqli_query($con,"SELECT * FROM tb_art_draft WHERE slug_art='$slug' ");
if(mysqli_num_rows($selDraft) == 1){
$dt = mysqli_fetch_assoc($selDraft);
$sampul = "files/images/".$dt['sampul_art'];
}else{
$image = "";
}
$hapusDraft = "DELETE FROM tb_art_draft WHERE slug_art='$slug' ";
if(mysqli_query($con, $hapusDraft)){
if($dt['sampul_art'] != ""){
unlink($sampul);
}
$data = array(
'yes' => true,
'msg' => "Berhasil dihapus",
'drc' => $base_url."kelola/".trim(base64_encode('data-draft'),'='),
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal dihapus!",
);
}
echo json_encode($data);
exit;
}

// kritik dan saran
if(isset($_POST['krisan'])){
$slt = htmlentities($_POST['slt']);
$eml = htmlentities($_POST['eml']);
$msg = htmlentities($_POST['msg']);
$target = htmlentities($_POST['target']);
$x = explode('@',$eml);
$xx = explode('.',$x[0]);
$dari = ucwords(implode(' ',$xx));
$selData = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$target' ");
if(mysqli_num_rows($selData) == 1){
$dt = mysqli_fetch_assoc($selData);
}
if($slt == "web"){
$frm = $eml;
$email = "admin@atakana.com";
$krisan = "Kritik & saran pada website";
$a = explode('@',$email);
$aa = explode('.',$a[0]);
$kepada = ucwords(implode(' ',$aa));
$linkPost = "";
}else if($slt == "post"){
$frm = "no-replay@atakana.com";
$email = $dt['email_art'];
$krisan = "Kritik & saran pada halaman posting";
$a = explode('@',$email);
$aa = explode('.',$a[0]);
$kepada = ucwords(implode(' ',$aa));
$linkPost = '<p><b>Link Posting</b><br><a href="'.$base_url.'artikel/'.$dt['slug_art'].'">'.$base_url.'artikel/'.$dt['slug_art'].'</a></p>';
}
$from = $frm;
$to = $email;
$subject = $krisan;
$body = '<html><body>';
$body .= '<h3 style="color:dodgerblue">Kritik & Saran Pengguna</h3>';
$body .= '<p>Hai <span style="color:green;font-style:italic">'.$kepada.'</span>, perkenalkan saya <span style="color:green;font-style:italic">'.$dari.'</span> ingin menyampaikan perihal berikut.</p>';
$body .= '<p><b>'.$dari.' Menyampaikan</b><br>';
$body .= $msg.'</p>';
$body .= $linkPost;
$body .= '<p>Mohon maaf jika ada kesilapan kata dalam penyampaian perihal di atas.</p>';
$body .= '<p>Terima Kasih<br>'.$dari.'<br><a href="mailto:'.$dari.'">'.$eml.'</a></p>';
$body .= '<p>Powered By <a href="'.$base_url.'">'.$base_url.'</a></p>';
$body .= '</body></html>';
$headers = "From: Kritik & Saran Pengguna<".$from.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$send = mail($to, $subject, $body, $headers);
if($send == true){
$data = array(
'yes' => true,
'msg' => "Berhasil ✓ Kritik dan saran berhasil terkirim ke ".$kepada.".\n\nTerima kasih.",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal! Kritik dan saran gagal terkirim, silakan coba kembali.\n\nTerima kasih.",
);
}
echo json_encode($data);
exit;
}

// report konten
if(isset($_POST['lapkon'])){
$slug = $_POST['target'];
$email = htmlentities($_POST['eml']);
$msg = htmlentities($_POST['msg']);
$em = explode('@',$email);
$by = str_replace('.','-',$em[0]);
if(!empty($_FILES['sst']['name'])){
$folder = "f/g/";
$nama_asli = $_FILES['sst']['name'];
$simpan = $folder.$nama_asli;
$ex = explode(".",$nama_asli);
$ext = strtolower(end($ex));
$nama_baru = "screenshot-".$slug."-report-by-".strtolower(str_replace(' ','-',$by))."-".date('dmYhis').".".$ext;
$layar = $nama_baru;
$tmp = $_FILES['sst']['tmp_name'];
$set_lebar = 1024;
move_uploaded_file($tmp, $simpan);
$ukuran_baru = $folder.$nama_baru;
list($lebar, $tinggi) = getimagesize($simpan);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($simpan);
}else if($ext == "png"){
$source = imagecreatefrompng($simpan);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
unlink($simpan);
}
$simpan = "INSERT INTO tb_art_rpr VALUES(NULL,'$slug','$msg','$layar','$email')";
if(mysqli_query($con, $simpan)){
$selReport = mysqli_query($con,"SELECT * FROM tb_art_rpr WHERE slug_rpr='$slug' AND email_rpr='$email' ORDER BY id_rpr DESC LIMIT 1");
if(mysqli_num_rows($selReport) == 1){
$sr = mysqli_fetch_assoc($selReport);
$id_rpr = $sr['id_rpr'];
$slug_rpr = $sr['slug_rpr'];
$pesan_rpr = $sr['pesan_rpr'];
$layar_rpr = $sr['layar_rpr'];
$email_rpr = $sr['email_rpr'];
$screenshot = $base_url."f/g/".$layar_rpr;
$link = $base_url."rpr/".trim(base64_encode($id_rpr."_".$email_rpr."_".$slug_rpr),'=');
$selData = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
if(mysqli_num_rows($selData) == 1){
$sd = mysqli_fetch_assoc($selData);
$x = explode('@',$email);
$xx = $x[0];
$xxx = explode('.',$xx);
$dari = ucwords(implode(' ',$xxx));
$ringkasan = substr(str_replace("<"," ",str_replace(">"," ",str_replace("&lt;","",str_replace("&gt;","",str_replace("<p>","",str_replace("</p>","<br>",$sd['isi_art'])))))),0,255);
$to = "admin@atakana.com";
$subject = "Laporan Dari ".$dari;
$body = '<html><body>';
$body .= '<p><b>'.$dari.' Melaporkan</b> <br>';
$body .= $pesan_rpr.'</p>';
$body .= '<p><b>Screenshot Konten Bermasalah</b><br>';
$body .= 'Lihat :<a href="'.$screenshot.'">'.$screenshot.'</a></p>';
$body .= '<p><b>Link Tindakan</b><br>';
$body .= '<a href="'.$link.'">'.$link.'</a></p>';
$body .= '<p><b>Judul Posting</b><br>';
$body .= $sd['judul_art'].'</p>';
$body .= '<p><b>Ringkasan Posting</b><br>'.$ringkasan.'</p>';
$body .= '<p><b>Link Posting</b><br>';
$body .= '<a href="'.$base_url.'artikel/'.$sd['slug_art'].'">'.$base_url.'artikel/'.$sd['slug_art'].'</a></p>';
$body .= '<p>Terima Kasih<br><a href="'.$base_url.'artikel/beranda">'.$base_url.'</a></p>';
$body .= '</body></html>';
$headers = "From: Temuan Konten Bermasalah <".$email.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$send = mail($to, $subject, $body, $headers);
if($send == true){
$to2 = $sd['email_art'];
$subject2 = "Laporan Dari ".$dari;
$body2 = '<html><body>';
$body2 .= '<p><b>'.$dari.' Melaporkan</b> <br>';
$body2 .= $pesan_rpr.'</p>';
$body2 .= '<p><b>Screenshot Konten Bermasalah</b><br>';
$body2 .= 'Lihat :<a href="'.$screenshot.'">'.$screenshot.'</a></p>';
$body2 .= '<p><b>Judul Posting</b><br>';
$body2 .= $sd['judul_art'].'</p>';
$body2 .= '<p><b>Ringkasan Posting</b><br>'.$ringkasan.'</p>';
$body2 .= '<p><b>Link Posting</b><br>';
$body2 .= '<a href="'.$base_url.'artikel/'.$sd['slug_art'].'">'.$base_url.'artikel/'.$sd['slug_art'].'</a></p>';
$body2 .= '<p style="color:brown"><b>Note</b><br><i>Mohon untuk segera ditindak lanjuti dan koreksi bagian konten yang bermasalah, dan jika tidak maka, konten Anda yang bersangkutan akan dihapus oleh pengembang.</i></p>';
$body2 .= '<p>Terima Kasih<br><a href="'.$base_url.'artikel/beranda">'.$base_url.'</a></p>';
$body2 .= '</body></html>';
$headers2 = "From: Konten Anda Bermasalah <no-replay@atakana.com>\r\n";
$headers2 .= "MIME-Version: 1.0\r\n";
$headers2 .= "Content-Type: text/html"."\r\n";
$send2 = mail($to2, $subject2, $body2, $headers2);
if($send2 == true){
$data = array(
'yes' => true,
'msg' => "Terima kasih atas dukungannya telah melaporkan konten bermasalah.",
);
}else{
$data = array(
'no' => true,
'msg' => "Pesan report gagal terkirim! Silakan coba lagi.\n\nTerima kasih.",
);
}
}else{
$data = array(
'no' => true,
'msg' => "Pesan report gagal terkirim! Silakan coba lagi.\n\nTerima kasih.",
);
}
}
}else{
$data = array(
'no' => true,
'msg' => "Mohon maaf terjadi kesalah tak terduga, silakan coba kembali.\n\Terima kasih.",
);
}
}
echo json_encode($data);
exit;
}

// kirim komentar
if(isset($_POST['kirim_komentar'])){
$slug = htmlentities(base64_decode($_POST['target']));
$nama = htmlentities($_POST['nama']);
$komentar = htmlentities($_POST['komentar']);
$email = $_SESSION['email'];
$tanggal = date('d-m-Y')." | ".date('h:i');
$simpan = "INSERT INTO tb_art_cmn VALUES(NULL,'$slug','$nama','$komentar','$email','$tanggal')";
if(mysqli_query($con, $simpan)){
// proses komentar ke email
$selArt = mysqli_query($con,"SELECT * FROM tb_art_bas WHERE slug_art='$slug' ");
if(mysqli_num_rows($selArt) == 1){
$sa = mysqli_fetch_assoc($selArt);
$detail = '<html><body>';
$detail .= '<p>Kiriman komentar dari '.$nama.' pada posting atakana.com dengan judul '.$sa['judul_art'].'.</p>';
$detail .= '<p>'.$nama.' mengatakan:<br>'.rtrim($komentar,'.').'.</p>';
$detail .= '<p>Lihat langsung di '.$base_url.'artikel/'.$slug.'#'.str_replace(' ','',str_replace('-','',str_replace(':','',str_replace('|','',$tanggal)))).'</p>';
$detail .= '<p>Terima Kasih<br><a href="'.$base_url.'artikel/branda">atakana.com</a></p>';
$detail .= '</body></html>';
}
$subject = "Pada Postingan Atakana.Com";
$from = "no-replay@atakana.com";
$body = $detail;
$headers = "From: Komentar Terbaru <".$from.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$selEmail = mysqli_query($con,"SELECT * FROM tb_akun_bas");
if(mysqli_num_rows($selEmail) > 0){
while($se = mysqli_fetch_array($selEmail)){
$dataEmail [] = $se['email'];
}
foreach($dataEmail AS $to){
mail($to,$subject,$body,$headers);
}
}
// end proses komentar ke email
$data = array(
'yes' => true,
);
}else{
$data = array(
'no' => true,
'msg' => "Maaf komentar Anda gagal terkirim, silakan coba kembali!",
'txt' => "Kirim",
);
}
echo json_encode($data);
exit;
}

// hapus komentar
if(isset($_POST['hadako'])){
$id = base64_decode($_POST['target']);
$hapus = "DELETE FROM tb_art_cmn WHERE id_cmn='$id' ";
if(mysqli_query($con, $hapus)){
$data = array(
'yes' => true,
'msg' => "Komentar berhasil dihapus",
);
}else{
$data = array(
'no' => true,
'msg' => "Komentar gagal dihapus!",
);
}
echo json_encode($data);
exit;
}

// hubungi pengembang
if(isset($_POST['kirim_pesan_pengembang'])){
$nama = htmlentities($_POST['nama']);
$from = htmlentities($_POST['email']);
$body = '<html><body>';
$body .= '<p>Pesan dari '.$nama.'</p>';
$body .= htmlentities($_POST['pesan']);
$body .= '</body></html>';
$to = "admin@atakana.com";
$subject = "Via Form Pengembang - ".$nama;
$headers = "From: Pesan Pengguna Atakana.Com <".$from.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$send = mail($to,$subject,$body,$headers);
if($send == true){
$data = array(
'yes' => true,
'msg' => "Hai ".$nama.", pesan Anda sudah terkirim ke pengembang atakana.com.\n\nTerima kasih.",
);
}else{
$data = array(
'no' => true,
'msg' => "Pesan gagal terkirim! Silakan coba kembali.",
);
}
echo json_encode($data);
exit;
}

// hubungi admin
if(isset($_POST['kirim_pesan_admin'])){
$from = htmlentities($_POST['email']);
$pesan = htmlentities($_POST['pesan']);
$x = explode('@',$from);
$xx = $x[0];
$xxx = explode('.',$xx);
$nama = ucwords(implode(' ',$xxx));
$body = '<html><body>';
$body .= '<h3>Pesan dari '.$nama.'</h3>';
$body .= '<p><b>'.$nama.' Menyampaikan</b><br>'.$pesan.'</p>';
$body .= '<p>Terima Kasih<br>'.$nama.'<br>'.$from.'</p>';
$body .= '</body></html>';
$to = "admin@atakana.com";
$subject = "Via Form Pesan Admin - ".$nama;
$headers = "From: Pesan Pengguna Atakana.Com <".$from.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$send = mail($to,$subject,$body,$headers);
if($send == true){
$data = array(
'yes' => true,
'msg' => "Hai ".$nama.", pesan Anda sudah terkirim ke admin atakana.com.\n\nTerima kasih.",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal! Pesan gagal terkirim. Silakan coba kembali.",
);
}
echo json_encode($data);
exit;
}

// submit email
if(isset($_POST['submit_email'])){
$email = htmlentities($_POST['email']);
$selEm = mysqli_query($con,"SELECT * FROM tb_subs_em WHERE email='$email' ");
if(mysqli_num_rows($selEm) == 0){
$simpan = "INSERT INTO tb_subs_em VALUES(NULL,'$email')";
if(mysqli_query($con, $simpan)){
$data = array(
'yes' => true,
'msg' => "Selamat sekarang Anda telah berlangganan posting terbaru di Atakana.Com.\n\nTerima kasih.",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal subscribe! Maaf alamat email Anda ".$email." belum tersimpan, coba lagi.",
);
}
}else{
$data = array(
'em' => true,
'msg' => "Alamat email ".$email." sudah pernah disubscribe sebelumnya.\n\nTerima kasih.",
);
}
echo json_encode($data);
exit;
}

// upload iklan
if(isset($_POST["upload_iklan"])){
$email = htmlentities($_POST['email']);
$url = htmlentities($_POST['url']);
$judul = htmlentities($_POST['judul']);
$deskripsi = htmlentities($_POST['deskripsi']);
$atv = htmlentities($_POST['aktif']);
$aktif = 0;
$posisi = htmlentities($_POST['posisi']);
$mulai = date('dmYhis');
$akhir = date('dm')+$atv.date('Yhis');
if(!empty($_FILES['gambar']['name'])){
$eml = explode('@',$email);
$byrep = str_replace('.','-',$eml[0]);
$folder = "files/images/";
$file = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];
$x = explode(".",$file);
$ext = strtolower(end($x));
$gambar = "image-ads-by-".$byrep."-".date('sihYmd').".".$ext;
move_uploaded_file($tmp,$folder.$file);
$set_lebar = 1024;
$ukuran_baru = $folder.$gambar;
list($lebar, $tinggi) = getimagesize($folder.$file);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ext == "jpg" || $ext == "jpeg"){
$source = imagecreatefromjpeg($folder.$file);
}else if($ext == "png"){
$source = imagecreatefrompng($folder.$file);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
unlink($folder.$file);
}else{
$gambar = "";
}
$upload = "INSERT INTO tb_ads VALUES(NULL,'$url','$judul','$deskripsi','$gambar','$email','$aktif','$posisi','$mulai','$akhir')";
if(mysqli_query($con, $upload)){
$data = array(
'yes' => true,
'msg' => "Berhasil, iklan berhasil diupload",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal, iklan gagal diupload!",
);
}
echo json_encode($data);
exit;
}

// contact_admin
if(isset($_POST['submit'])){
if($_POST['submit'] == "contact_admin"){
$email = htmlentities($_POST['email']);
$pesan = htmlentities($_POST['pesan']);
$x = explode('@',$email);
$xx = $x[0];
$xxx = explode('.',$xx);
$nama = ucwords(implode(' ',$xxx));
$body = '<html><body>';
$body .= '<h3>Pesan dari '.$nama.'</h3>';
$body .= '<p><b>'.$nama.' Menyampaikan</b><br>'.$pesan.'</p>';
$body .= '<p>Terima Kasih<br>'.$nama.'<br>'.$email.'</p>';
$body .= '</body></html>';
$to = "admin@atakana.com";
$subject = "Dari - ".$nama;
$headers = "From: By Portfolio Atakana.Com <".$email.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html"."\r\n";
$send = mail($to,$subject,$body,$headers);
if($send == true){
$data = array(
'yes' => true,
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal, pesan Anda gagal terkirim!",
);
}
echo json_encode($data);
exit;
}
}

// add new project
if(isset($_POST['add_new_project'])){
$url = htmlentities($_POST['url']);
$nama = htmlentities($_POST['nama']);
if(!empty($_FILES['screenshot']['name'])){
$folder = "data/file/project/img/";
$file = $_FILES['screenshot']['name'];
$tmp = $_FILES['screenshot']['tmp_name'];
$x = explode(".",$file);
$ex = strtolower(end($x));
$screenshot = "screenshot-".strtolower(str_replace(' ','-',str_replace('.','-',$nama)))."-".date('sihYmd').".".$ex;
move_uploaded_file($tmp,$folder.$file);
$set_lebar = 1024;
$ukuran_baru = $folder.$screenshot;
list($lebar, $tinggi) = getimagesize($folder.$file);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ex == "jpg" || $ex == "jpeg"){
$source = imagecreatefromjpeg($folder.$file);
}else if($ex == "png"){
$source = imagecreatefrompng($folder.$file);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
unlink($folder.$file);
}else{
$screenshot = "";
}
$simpan = "INSERT INTO tb_project VALUES(NULL, '$url', '$nama', '$screenshot')";
if(mysqli_query($con, $simpan)){
$data = array(
'yes' => true,
'drc' => $base_url."#project",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal, project baru gagal ditambahkan!",
);
}
echo json_encode($data);
exit;
}

// edit data project
if(isset($_POST['edit_data_project'])){
$trg = explode('_',$_POST['target']);
$target = base64_decode($trg[1]);
$url = htmlentities($_POST['url']);
$nama = htmlentities($_POST['nama']);
$data_project = mysqli_query($con,"SELECT * FROM tb_project WHERE id='$target' ");
if(mysqli_num_rows($data_project) == 1){
$dp = mysqli_fetch_assoc($data_project);
$id = $dp['id'];
$screen = $dp['screenshot'];
if(!empty($_FILES['screenshot']['name'])){
$folder = "data/file/project/img/";
$file = $_FILES['screenshot']['name'];
$tmp = $_FILES['screenshot']['tmp_name'];
$x = explode(".",$file);
$ex = strtolower(end($x));
$screenshot = "screenshot-".strtolower(str_replace(' ','-',str_replace('.','-',$nama)))."-".date('sihYmd').".".$ex;
move_uploaded_file($tmp,$folder.$file);
$set_lebar = 1024;
$ukuran_baru = $folder.$screenshot;
list($lebar, $tinggi) = getimagesize($folder.$file);
$k = $lebar/$set_lebar;
$lebar_baru = $lebar/$k;
$tinggi_baru = $tinggi/$k;
$thumb = imagecreatetruecolor($lebar_baru,$tinggi_baru);
if($ex == "jpg" || $ex == "jpeg"){
$source = imagecreatefromjpeg($folder.$file);
}else if($ex == "png"){
$source = imagecreatefrompng($folder.$file);
}
imagecopyresized($thumb,$source,0,0,0,0,$lebar_baru,$tinggi_baru,$lebar,$tinggi);
imagejpeg($thumb,$ukuran_baru);
imagedestroy($thumb);
imagedestroy($source);
unlink($folder.$file);
unlink($folder.$screen);
}else{
$screenshot = $screen;
}
$simpan = "UPDATE tb_project SET url='$url', nama='$nama', screenshot='$screenshot' WHERE id='$id' ";
if(mysqli_query($con, $simpan)){
$data = array(
'yes' => true,
'drc' => "/#project",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal, data project gagal disimpan!",
);
}
}else{
$data = array(
'no' => true,
'msg' => "Tidak dapat menyimpan perubahan data project!",
);
}
echo json_encode($data);
exit;
}

// delete data project
if(isset($_POST['delete_data_project'])){
if($_POST['delete_data_project'] == "by_target"){
$target  = base64_decode($_POST['target']);
$data_project = mysqli_query($con,"SELECT * FROM tb_project WHERE id='$target' ");
if(mysqli_num_rows($data_project) == 1){
$dp = mysqli_fetch_assoc($data_project);
$id = $dp['id'];
$screenshot = $dp['screenshot'];
$hapus = "DELETE FROM tb_project WHERE id='$id' ";
if(mysqli_query($con, $hapus)){
unlink("data/file/project/img/".$screenshot);
$data = array(
'yes' => true,
'drc' => "/#project",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal, data project gagal dihapus!",
);
}
}else{
$data = array(
'no' => true,
'msg' => "Data project tidak dapat dihapus!",
);
}
echo json_encode($data);
exit;
}
}

// add new page
if(isset($_POST['add_new_page'])){
$page = htmlentities($_POST['target']);
$judul = htmlentities($_POST['judul']);
$deskripsi = htmlentities($_POST['deskripsi']);
$terbit = date('d/m/Y');
$update = "";
$cek_data_page = mysqli_query($con,"SELECT * FROM tb_statis WHERE page='$page' ");
if(mysqli_num_rows($cek_data_page) == 1){
$data = array(
'no' => true,
'msg' => "Halaman ".$judul." sudah ada!",
);
}else{
$simpan  = "INSERT INTO tb_statis VALUES(NULL, '$page', '$judul', '$deskripsi', '$terbit', '$update')";
if(mysqli_query($con, $simpan)){
if($page == "about"){
$drc = $base_url."#about";
}else{
$drc = "";
}
$data = array(
'yes' => true,
'drc' => $drc,
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal, halaman baru gagal ditambahkan!",
);
}
}
echo json_encode($data);
exit;
}

// edit data page statis
if(isset($_POST['edit_data_page'])){
$page = htmlentities($_POST['page']);
$judul = htmlentities($_POST['judul']);
$deskripsi = htmlentities($_POST['deskripsi']);
$edit = date('d/m/Y');
$simpan = "UPDATE tb_statis SET judul='$judul', deskripsi='$deskripsi', edit='$edit' WHERE page='$page' ";
if(mysqli_query($con, $simpan)){
if($page == "about"){
$drc = $base_url."#about";
}else{
$drc = "";
}
$data = array(
'yes' => true,
'drc' => $drc,
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal, perubahan halaman gagal disimpan!",
);
}
echo json_encode($data);
exit;
}

// delete data page
if(isset($_POST['delete_data_page'])){
if($_POST['delete_data_page'] == "statis_page"){
$page = $_POST['data_page'];
$hapus = "DELETE FROM tb_statis WHERE page='$page' ";
if(mysqli_query($con, $hapus)){
$data = array(
'yes' => true,
'msg' => "Berhasil, halaman berhasil dihapus.",
'drc' => "",
);
}else{
$data = array(
'no' => true,
'msg' => "Gagal, halaman gagal dihapus!",
);
}
echo json_encode($data);
exit;
}
}

// jika akses langsung
if(!isset($_POST[''])){
echo "Oops halaman tidak ditemukan!";
}
?>
