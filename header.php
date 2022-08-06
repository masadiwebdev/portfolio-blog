<?php
session_start();
require 'conf.php';
?>
<!DOCTYPE html>
<html id="html">
<head>
<title>Atakana.Com</title>
<meta charset="UTF-8">
<meta name="description" content="Portfolio Arnadi Atakana.Com - Web Programming"/>
<meta name="keywords" content="portfolio, arnadi, web developer, , web programmin, web atakana.com"/>
<meta name="author" content="Arnadi Web Atakana.Com"/>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no"/>
<meta name="theme-color" content="rgba(30,144,255)"/>
<meta property="og:title" content="Atakana.Com"/>
<meta property="og:url" content="<?=$base_url;?>"/>
<meta property="og:description" content="Portfolio Arnadi Atakana.Com - Web Programming"/>
<meta property="og:image" content="<?=$base_url.'f/g/icon.png';?>"/>
<meta property="og:type" content="website"/>
<meta name="google-site-verification" content="AvorMrnuZ6TFJpdNdxI6gi1m5mCtYVxY5OW13YMKP10"/>
<link rel="canonical" href="<?=$base_url;?>"/>
<link rel="icon" type="image/png" href="<?=$base_url.'f/g/icon.png';?>"/>
<style>
* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}
html {
	scroll-behavior: smooth;
}
body {
	background-color: #efefef;
	font-family: sans-serif;
	font-size: 16px;
	height: 100%;
	min-height: 100vh;
	position: relative;
	text-size-adjust: none;
	user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	-webkit-text-size-adjust: none;
	-webkit-user-select: none;
	width: 100%;
}
body.over {
	overflow: hidden;
}
body.over img {
	filter: contrast(50%) sepia(100%);
}
body.over section {
	filter: blur(1px);
}
hr {
	background-color: white;
	border: 0;
	height: 50px;
	line-height: 50px;
	margin: -1px auto;
	max-width: 1024px;
	overflow: hidden;
	padding: 0;
	position: relative;
	width: 100%;
}
hr:before {
	background-color: rgba(0,0,30,.125);
	content: "";
	height: 1px;
	max-width: 1024px;
	position: absolute;
	top: 50%;
	width: 100%;
}
.left {
	text-align: left;
}
.center {
	text-align: center;
}
.right {
	text-align: right;
}
.justify {
	text-align: justify;
}
img {
	filter: contrast(115%) saturate(1.25);
}
header {
	background-color: rgba(30,144,255);
	min-height: 50px;
	height: 50px;
	left: 50%;
	line-height: 50px;
	margin: 0 auto;
	max-width: 1024px;
	overflow: hidden;
	position: fixed;
	top: 0;
	transform: translate(-50%,0);
	width: 100%;
	z-index: 100;
}
header h1 {
	color: white;
	cursor: pointer;
	font-size: 1.35em;
	left: 0;
	padding: 0 10px;
	position: absolute;
}
header button#btn-nav {
	display: none;
}
nav {
	position: fixed;
	right: 0;
	text-align: right;
	top: 0;
	transform: none;
	transition: all .25s ease-in-out;
	width: auto;
	z-index: 110;
}
nav ul {
	background-color: rgba(30,144,255);
	float: right;
	padding: 0;
	transition: all .5s ease-in-out;
	width: auto;
}
nav ul li {
	color: rgba(222,222,222);
	cursor: pointer;
	display: inline-block;
	height: 50px;
	line-height: 50px;
	list-style: none;
	padding: 0 15px;
	transition: all .25s ease-in-out;
}
nav ul li:hover {
	background-color: rgba(0,0,30,.1);
}
section {
	background-color: white;
	height: 100%;
	margin: 0 auto;
	max-width: 1024px;
	overflow: hidden;
	padding: 50px 10px;
	position: relative;
	width: 100%;
}
section h1 {
	font-size: 1.5em;
	margin: 0 0 15px;
}
section h2 {
	font-size: 1.35em;
	margin: 10px 0 30px;
	padding: 0 0 10px;
	position: relative;
}
section h2:after {
	border-bottom: 1px solid rgba(0,0,30,.1);
	bottom: 0;
	content: "";
	left: 50%;
	max-width: 50%;
	position: absolute;
	transform: translate(-50%);
	width: 50%;
}
section#jumbotron {
	margin: 50px auto 0;
	padding: 0;
	position: sticky;
	top: 50px;
	z-index: -1;
}
section#jumbotron figure {
	max-height: 25vh;
	overflow: hidden;
	position: relative;
	width: 100%;
}
section#jumbotron figure img {
	display: block;
	height: auto;
	margin-top: -13vh;
	width: 100%;
}
section#jumbotron figcaption {
	color: yellow;
	font-family: times new roman;
	font-size: 3.5em;
	font-weight: 600;
	left: 50%;
	line-height: 1.5em;
	padding: 0 10px;
	position: absolute;
	text-align: center;
	text-shadow: 1px 1px 10px rgba(0,0,30);
	top: 50%;
	transform: translate(-50%,-50%);
	width: 90%;
}
section#jumbotron figcaption i.under {
	color: white;
}
section#about p {
	color: #333;
	font-size: .9em;
	letter-spacing: .03em;
	line-height: 1.5em;
	margin: 25px 0;
	padding: 0 5%;
	text-shadow: 1px 1px 0 white, 2px 2px 3px rgba(0,0,30,.15);
	word-spacing: .35em;
}
section#about p a {
	color: rgba(30,144,255);
	font-family: times new roman;
	font-size: .9em;
	font-style: italic;
	text-decoration: none;
}
section#about p a:hover {
	color: rgba(255,0,0);
	text-decoration: underline;
}
section#project figure {
	border-radius: 2px;
	box-shadow: 0 0 0 1px rgba(0,0,30,.15), 3px 4px 4px rgba(0,0,30,.05);
	display: inline-block;
	height: 100%;
	margin: 20px 2%;
	min-height: 225px;
	overflow: hidden;
	position: relative;
	width: 45%;
	vertical-align: middle;
}
section#project figure:before {
	background-color: rgba(0,0,30,.5);
	border-radius: 50%;
	color: white;
	content: "+";
	height: 30px;
	left: 50%;
	line-height: 30px;
	position: absolute;
	text-align: center;
	top: 40%;
	transform: translate(-50%, -46.75%);
	width: 30px;
	z-index: 1;
}
section#project figure button#uppro, section#project figure button#delpro {
	background-color: white;
	border: 0;
	border-radius: 50%;
	box-shadow: 0 0 5px 1px rgba(0,0,30,.95);
	color: red;
	cursor: pointer;
	height: 23px;
	left: 50%;
	line-height: 23px;
	position: absolute;
	text-align: center;
	top: 50%;
	transform: translate(-50%, -50%);
	width: 23px;
	z-index: 10;
}
section#project figure button#uppro {
	border-radius: 3px;
	font-size: .65em;
	height: 20px;
	left: auto;
	line-height: 20px;
	padding: 0 7px;
	right: 5px;
	top: 5px;
	transform: none;
	width: auto;
}
section#project figure button#uppro:hover, section#project figure button#delpro:hover {
	background-color: red;
	color: white;
}
section#project figure img, section#project figure .img {
	background-color: rgba(0,0,30,.005);
	background-image: url('<?=$base_url;?>f/g/no-image.png');
	background-position: center;
	background-repeat: no-repeat;
	background-size: cover;
	border-radius: 2px 2px 0 0;
	color: rgba(30,144,255,.5);
	cursor: pointer;
	display: block;
	font-size: .75em;
	height: 100%;
	min-height: 189px;
	object-fit: cover;
	position: relative;
	text-align: left;
	width: 100%;
	z-index: 2;
}
section#project figure figcaption {
	background-color: white;
	border-top: 1px solid rgba(0,0,30,.125);
	bottom: 0;
	color: rgba(40,144,255);
	cursor: pointer;
	font-size: .8em;
	padding: 10px;
	overflow-x: scroll;
	position: absolute;
	transition: all .25s ease-in-out;
	white-space: nowrap;
	width: 100%;
}
section#project figure figcaption::-webkit-scrollbar {
	display: none;
}
section#project figure figcaption:hover {
	color: rgba(255,0,0);
	font-size: .7em;
}
section #kontak {
	border-radius: 3px;
	box-shadow: 0 0 0 1px rgba(0,0,30,.1), 2px 3px 5px rgba(0,0,30,.075);
	margin: 0 auto;
	max-width: 768px;
	padding: 20px 20px;
	width: 95%;
}
section #kontak h5 {
	font-size: 1.05em;
	margin: 0 0 10px;
}
section #kontak p {
	color: #555;
	font-size: .9em;
	margin: 0 0 15px;
}
section #kontak .row {
	margin: 10px 0;
}
section #kontak .row label {
	color: #555;
	display: block;
	font-size: .9em;
	font-weight: 500;
}
section #kontak .row input {
	border: 0;
	border-radius: 2px;
	box-shadow: 0 0 0 1px rgba(0,0,30,.15), 0 0 0 3px rgba(0,0,30,.05);
	margin: 5px 0;
	padding: 10px;
	transition: all .25s ease-in-out;
	width: 100%;
}
section #kontak .row textarea {
	border: 0;
	border-radius: 2px;
	box-shadow: 0 0 0 1px rgba(0,0,30,.15), 0 0 0 3px rgba(0,0,30,.05);
	height: 100px;
	margin: 5px 0;
	padding: 10px;
	width: 100%;
}
section #kontak .row input:focus, section #kontak .row textarea:focus {
	box-shadow: 0 0 0 1px rgba(30,144,255,.35), 0 0 0 4px rgba(30,144,255,.15);
	outline-style: none;
}
section #kontak .row input::placeholder, section #kontak .row textarea::placeholder {
	font-family: monospace;
	font-size: .95em;
}
section #kontak .row .error {
	color: brown;
	font-size: .8em;
	height: 18px;
	min-height: 18px;
}
section #kontak button {
	background-color: rgba(0,0,30,.15);
	border: 0;
	border-radius: 2px;
	box-shadow: 0 0 0 1px rgba(0,0,30,.125), 2px 2px 2px rgba(0,0,30,.1);
	color: #555;
	height: 37px;
	letter-spacing: .035em;
	line-height: 37px;
	margin: 0 10px;
	padding: 0 15px;
}
section #kontak button[type=submit] {
	background-color: rgba(30,144,255,.95);
	color: white;
}
section #kontak button:hover {
	opacity: .85;
	transform: scale(.9);
	transition: all .25s ease-in-out;
}
footer {
	background-color: white;
	margin: 0 auto;
	max-width: 1024px;
	padding: 50px 0;
	position: relative;
	width: 100%;
}
footer p {
	color: rgba(0,0,30,.5);
	font-size: .8em;
	margin: 0 0 30px;
}
footer p a {
	color: rgba(30,144,255);
	dislay: inline-block;
	margin: 0 5px;
	padding: 3px 7px;
	text-decoration: none;
}
footer p:last-child {
	margin-bottom: 0;
}
@media(max-width: 768px){
	header button#btn-nav {
		background-color: transparent;
		border: 0;
		cursor: pointer;
		display: block;
		height: 50px;
		outline-style: none;
		overflow: hidden;
		position: absolute;
		right: 0;
		width: 50px;
	}
	header button#btn-nav span {
		background-color: white;
		border-radius: 3px;
		content: "";
		height: 3px;
		left: 50%;
		position: absolute;
		top: 50%;
		transform: translate(-50%,-50%);
		transition: all .5s ease-in-out;
		width: 30px;
	}
	header button#btn-nav span:nth-child(1) {
		top: 15px;
	}
	header button#btn-nav span:nth-child(2) {
		top: 25px;
	}
	header button#btn-nav span:nth-child(3) {
		top: 35px;
	}
	header button#btn-nav.show span {
		border-radius: 50%;
	}
	header button#btn-nav.show span:nth-child(1) {
		left: 10px;
		top: 24px;
		transform: rotate(45deg);
	}
	header button#btn-nav.show span:nth-child(2) {
		left: -50px;
		top: 25px;
	}
	header button#btn-nav.show span:nth-child(3) {
		left: 10px;
		top: 24px;
		transform: rotate(-45deg);
	}
	nav {
		left: 50%;
		max-width: 768px;
		opacity: 0;
		top: -100%;
		transform: translate(-50%);
		width: 100%;
		z-index: 90;
	}
	nav ul {
		opacity: 0;
		width: 150px;
	}
	nav ul li {
		border-bottom: 1px solid rgba(222,222,222,.25);
		display: block;
		padding: 0 20px;
	}
	nav ul li:nth-child(1) {
		border-top: 1px solid rgba(222,222,222,.25);
	}
	nav ul li:last-child {
		border-bottom: 0;
	}
	nav ul li:hover {
		color: maroon;
		padding-right: 30px;
	}
	nav.show {
		opacity: 1;
		top: 50px;
	}
	nav.show ul {
		opacity: 1;
	}
	section#jumbotron figcaption {
		font-size: 1.5em;
	}
}
</style>
</head>
<body>
<header>
<h1 id="title">Atakana.Com</h1>
<button type="button" id="btn-nav">
<span></span>
<span></span>
<span></span>
</button>
</header>
<nav>
<ul>
<li id="data-home">Home</li>
<li id="data-blog">Blog</li>
<li id="data-about">About</li>
<li id="data-contact">Contact</li>
<li id="data-project">Project</li>
<?php
if(isset($_SESSION['levad'])){
if($_SESSION['levad'] == "master admin"){
?>
<li id="data-new-page">+ Page</li>
<li id="data-new-project">+ Project</li>
<li id="data-logout">Logout</li>
<?php
}
}else{
?>
<li id="data-login">Login</li>
<?php
}
?>
</ul>
</nav>
