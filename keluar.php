<?php
session_start();
require 'conf.php';
if(isset($_SESSION['akses'])){
if($_GET['tutup'] == "akses"){
if(isset($_GET['x'])){
$_SESSION['uri_ref'] = $_GET['x'];
$proses = "../../proses";
}else{
$proses = "../proses";
}
?>
<script data-target="<?=$proses;?>" class="data-target">
const dataTarget = document.querySelector("script.data-target");
const proses = dataTarget.getAttribute("data-target");
const data = new FormData();
data.append("akses_keluar", "");
const http = new XMLHttpRequest();
http.open("POST",proses,true);
http.onreadystatechange = function(){
if(this.readyState == 4 && this.status == 200){
const rsp = JSON.parse(this.responseText);
if(rsp.yes == true){
window.location.href = rsp.drc;
}
}
};
http.send(data);
</script>
<?php
}
}else{
header("Location: ".$base_url);
exit;
}
?>
