<?php
header('Content-Type: application/xml');
require 'conf.php';
$selData = mysqli_query($con,"SELECT * FROM tb_art_bas");
echo "<?xml version='1.0' encoding='UTF-8'?>"."\n";
echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>"."\n";
echo " ";
echo "<url>";
echo "<loc>".$base_url."</loc>";
echo "<lastmod>2022-05-07</lastmod>";
echo "<priority>1.00</priority>";
echo "</url>";
echo "<url>";
echo "<loc>".$base_url."artikel/beranda</loc>";
echo "<lastmod>2022-05-23</lastmod>";
echo "<priority>1.00</priority>";
echo "</url>";
while($dt = mysqli_fetch_assoc($selData)){
if(!empty($dt['terbit_art'])){
$x = explode(' |',$dt['terbit_art']);
$xx = explode('-',$x[0]);
$lastone = $xx[2]."-".$xx[1]."-".$xx[0];
$lastmod = $lastone;
}else{
$lastmod = "";
}
echo "<url>";
echo "<loc>".$base_url."artikel/".$dt['slug_art']."</loc>";
echo "<lastmod>".$lastmod."</lastmod>";
echo "<priority>1.00</priority>";
echo "</url>";
}
echo "</urlset>";
?>
