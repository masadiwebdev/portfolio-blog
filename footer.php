<footer class="center">
<p><a href="#home">Home</a>.<a href="https://atakana.com/artikel/beranda">Blog</a>.<a href="#about">About</a>.<a href="#contact">Contact</a>.<a href="#project">Project</a></p>
<p>&copy;2022<?php if(date('Y') > 2022){echo "~".date('Y');}?> | Atakana.Com</p>
</footer>
<script>
let sq = (q) =>
{
	r = document.querySelector(q);
	return r;
}
let sqa = (q) =>
{
	r = document.querySelectorAll(q);
	return r;
}
let el = (s, q, v) =>
{
	r = sq(s).addEventListener(q, v);
	return r;
}
let wlh = (q) =>
{
	r = window.location.href = q;
	return r;
}
if(sq("header h1#title") != null)
{
	sq("header h1#title").onclick = function()
	{
		wlh("/");
	}
}
if(sq("nav") != null)
{
	let list = sqa("nav ul li");
	for(let i = 0; i < list.length; i++)
	{
		list[i].onclick = function()
		{
			let id = list[i].getAttribute("id");
			if(id == "data-home")
			{
				wlh("#home");
			}
			else if(id == "data-blog")
			{
				wlh("artikel/beranda");
			}
			else if(id == "data-about")
			{
				wlh("#about");
			}
			else if(id == "data-contact")
			{
				wlh("#contact");
			}
			else if(id == "data-project")
			{
				wlh("#project");
			}
			else if(id == "data-new-page")
			{
				wlh("pg/add/new-page");
			}
			else if(id == "data-new-project")
			{
				wlh("pg/add/new-project");
			}
			else if(id == "data-logout")
			{
				wlh("tutup/akses/<?=trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=');?>");
			}
			else if(id == "data-login")
			{
				wlh("akses/masuk/<?=trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=');?>");
			}
		}
	}
}
if(sq("#btn-nav") != null)
{
	el("#btn-nav", "click", navToggle);
	function navToggle()
	{
		let menu = sq("#btn-nav"), nav = sq("nav"), list = sqa("nav ul li");
		sq("body").classList.toggle("over");
		menu.classList.toggle("show");
		nav.classList.toggle("show");
		for(let i = 0; i < list.length; i++)
		{
			list[i].onclick = function()
			{
				sq("body").classList.toggle("over");
				menu.classList.toggle("show");
				nav.classList.toggle("show");
				let id = list[i].getAttribute("id");
				if(id == "data-home")
				{
					wlh("#home");
				}
				else if(id == "data-blog")
				{
					wlh("artikel/beranda");
				}
				else if(id == "data-about")
				{
					wlh("#about");
				}
				else if(id == "data-contact")
				{
					wlh("#contact");
				}
				else if(id == "data-project")
				{
					wlh("#project");
				}
				else if(id == "data-new-page")
				{
					wlh("pg/add/new-page");
				}
				else if(id == "data-new-project")
				{
					wlh("pg/add/new-project");
				}
				else if(id == "data-logout")
				{
					wlh("tutup/akses/<?=trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=');?>");
				}
				else if(id == "data-login")
				{
					wlh("akses/masuk/<?=trim(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),'=');?>");
				}
			}
		}
	}
}
if(sq("#jumbotron"))
{
	const fcHeight = sq("#jumbotron figcaption");
	fcHeight.style.height = fcHeight.clientHeight + "px";
	let fc = sq("#jumbotron figcaption span.txt"),
	txt = fc.innerHTML;
	fc.innerHTML = "";
	for(let i = 0; i < txt.length; i++)
	{
		setTimeout(showText, 250*(i));
		function showText()
		{
			fc.innerHTML += txt[i];
		}
	}
	setInterval(function()
	{
		fc.innerHTML = "";
		for(let i = 0; i < txt.length; i++)
		{
			setTimeout(showText, 250*(i));
			function showText()
			{
				fc.innerHTML += txt[i];
			}
		}
	},250*(txt.length));
}
if(sq("#project") != null)
{
	if(sq("#project figure #uppro") != null)
	{
		let uppro = sqa("#project figure #uppro");
		for(let i = 0; i < uppro.length; i++)
		{
			uppro[i].onclick = function()
			{
				let dataUpPro = uppro[i].getAttribute("data-uppro");
				let x = dataUpPro.split('_'), xx = atob(x[1]);
				wlh("pg/edit/project/" + xx);
			}
		}
	}
	if(sq("#project figure #delpro") != null)
	{
		let delpro = sqa("#project figure #delpro");
		for(let i = 0; i < delpro.length; i++)
		{
			delpro[i].onclick = function()
			{
				let dataDelPro = delpro[i].getAttribute("data-delpro");
				let x = dataDelPro.split('_'), xx = atob(x[1]);
				wlh("pg/view/project/" + xx);
			}
		}
	}
	let fig = sqa("#project figure"), img = sqa("#project figure img"), fcp = sqa("#project figure figcaption");
	for(let i = 0; i < fig.length; i++)
	{
		let dataAlt = img[i].getAttribute("alt"), dataImg = img[i].getAttribute("data-img"), openPage = fcp[i].getAttribute("data-page");
		fig[i].onclick = function()
		{
			if(dataImg != "null")
			{
				let openImg = window.open("", "Open Image", "width: 768, height: 500"), styvim = `<style>*{box-sizing:border-box;margin:0;padding:0;}.box-view{background-color:rgba(0,0,30,.9);bottom:0;left:0;margin:0;padding:0;position:absolute;right:0;top:0;}.box-view .btn-close{background-color:#fafafa;border:0;border-radius:50%;box-shadow:0 0 0 2px #555, 0 0 100px black;color:brown;cursor:pointer;font-size:2em;height:50px;line-height:50px;padding:0;position:absolute;right:50px;top:50px;width:50px;z-index:5;}.box-view .btn-close:hover{background-color:#eee;color:maroon;box-shadow:none;}.box-view img{background-color:white;display:block;left:50%;position:relative;top:50%;transform:translate(-50%,-50%);width:100%;z-index:1;}</style>`;
				openImg.document.write(styvim + `<div class="box-view"><button onclick="window.close()" class="btn-close" title="Close">&times;</button><img alt="` + dataAlt + `" src="` + dataImg + `"/></div>`);
			}
			else
			{
				wlh("<?=$base_url;?>pg/add/new-project");
			}
		}
		fcp[i].onclick = function()
		{
			if(openPage != "null")
			{
				wlh(openPage);
			}
			else
			{
				wlh("<?=$base_url;?>pg/add/new-project");
			}
		}
		if(sq("#project figure#anp") != null)
		{
			let im = sq("#project figure#anp");
			cd = im.innerHTML,
			cd = cd.replace(/<img(.*?)>/g, '<div class="img"$1></div>'),
			im.innerHTML = cd;
			let divAnp = sq("#project figure#anp div.img"), figAnp = sq("#project figure#anp figcaption");
			divAnp.onclick = function()
			{
				wlh("<?=$base_url;?>pg/add/new-project");
			}
			figAnp.onclick = function()
			{
				wlh("<?=$base_url;?>pg/add/new-project");
			}
		}
	}
}
if(sq("#kontak") != null)
{
	let form = sq("#kontak"), email = sq("#email"), pesan = sq("#pesan"), err = sqa(".error"), submit = sq("#submit");
	el("#kontak", "submit", sendMessage);
	function sendMessage(e)
	{
		e.preventDefault();
		for(let i = 0; i < err.length; i++)
		{
			err[i].innerText = "";
		}
		if(email.value == "")
		{
			email.focus();
			err[0].innerText = "Harap masukkan email Anda!";
			return false;
		}
		else if(pesan.value == "")
		{
			pesan.focus();
			err[1].innerText = "Tulis pesan yang ingin Anda sampaikan!";
			return false;
		}
		else
		{
			let data = new FormData();
			data.append("email", email.value);
			data.append("pesan", pesan.value);
			data.append("submit", submit.value);
			let http = new XMLHttpRequest();
			http.open("POST","proses",true);
			http.onloadstart = function()
			{
				submit.setAttribute("disabled",true);
				submit.innerText = "Mengirim...";
			}
			http.onreadystatechange = function()
			{
				if(this.readyState == 4 && this.status == 200)
				{
					const rsp = JSON.parse(this.responseText);
					if(rsp.yes == true)
					{
						setTimeout(function()
						{
							submit.innerText = "Terkirim ;)";
						},1000);
						setTimeout(function()
						{
							form.reset();
							submit.removeAttribute("disabled");
							submit.innerText = "Kirim";
						},3000);
					}
					else if(rsp.no == true)
					{
						alert(rsp.msg);
					}
				}
			};
			http.send(data);
		}
	}
}
if(sq("html") != null)
{
	sq("html").setAttribute("id","home");
}
</script>
</body>
</html>
