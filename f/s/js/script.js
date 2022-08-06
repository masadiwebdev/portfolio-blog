sq(".loadani").classList.add("show");
window.addEventListener("DOMContentLoaded", () =>
{
	setTimeout(function()
	{
		ldr.classList.remove("show");
	},100);
let bdy = sq("body"), ldr = sq(".loadani"), forse = sq("form.form-search"), info = sq(".form-search .input-key"), restkey = sq(".form-search .rest-key"), butfix = sq(".butbox .but-fix");
if(forse != null)
{
	info.onfocus = function()
	{
		restkey.classList.add("show");
	}
	info.onblur = function()
	{
		restkey.classList.remove("show");
	}
	info.onkeyup = function(e)
	{
		e.preventDefault();
		const query = this.value, result = sq(".aucom ul.list"), losu = sq(".losu");
		if(query == "")
		{
			result.innerHTML = "";
			return false;
		}
		else
		{
			const source = atob(result.getAttribute("data-src"));
			const data = new FormData();
			data.append("key", query);
			data.append("suggest", "");
			const http = new XMLHttpRequest();
			http.open("POST",source,true);
			http.onloadstart = function()
			{
				restkey.classList.remove("show");
				losu.classList.add("show");
			}
			http.onreadystatechange = function()
			{
				if(this.readyState == 4 && this.status == 200)
				{
					const rsp = JSON.parse(this.responseText);
					result.innerHTML = rsp;
					let list = sqa(".aucom ul.list a li.data-list");
					for(let i = 0; i < list.length; i++)
					{
						list[i].onclick = function()
						{
							bdy.classList.add("actldr");
							ldr.classList.add("show");
						}
					}
					setTimeout(function()
					{
						losu.classList.remove("show");
					},250);
					setTimeout(function()
					{
						restkey.classList.add("show");
					},500);
				}
			};
			http.send(data);
		}
	}
	el(".form-search", "submit", serp);
	function serp(e)
	{
		e.preventDefault();
		const uri = sq(".form-search").getAttribute("action"),
		key = sq(".input-key").value;
		if(key != "")
		{
			bdy.classList.add("actldr");
			ldr.classList.add("show");
			wlh(uri+key.replace(/\s/g,'-'));
		}
	}
	el(".rest-key .rest", "click", rest);
	function rest()
	{
		sq(".form-search").reset();
		sq(".input-key").value = "";
		sq(".aucom ul.list").innerHTML = "";
	}
}
setTimeout(function()
{
	if(sq(".slides") != null)
	{
		let sl = sqa(".slides ul.sld li"), cx = 0, sli = sqa(".slides ul.sld li img"), anisu = sq(".losu");
		for(let i = 0; i < sl.length; i++)
		{
			anisu.classList.add("show");
			let sliHeight = sli[i].clientHeight, src = sli[i].getAttribute("src");
			sli[i].style.height = sliHeight + "px";
			sli[i].setAttribute("src", "");
			setTimeout(function()
			{
				sli[i].setAttribute("src", src);
				sl[0].classList.add("show");
				sl[0].onclick = function()
				{
					wlh(atob(sl[0].getAttribute("data-source")));
				}
				anisu.classList.remove("show");
			},1000);
		}
		setInterval(ns,5000);
		function ns()
		{
			sl[cx].classList.remove("show");
			cx = (cx+1)%sl.length;
			sl[cx].classList.add("show");
			sl[cx].onclick = function(){
			wlh(atob(this.getAttribute("data-source")));
			}
		}
	}
},1500);
setTimeout(function()
{
if(sq(".post .card-img img") != null)
{
	let caim = sqa(".post .card-img img");
	for(let i = 0; i < caim.length; i++)
	{
		let alt = caim[i].getAttribute("alt"), src = caim[i].getAttribute("src");
		function imgFile(data)
		{
			let http = new XMLHttpRequest(), imgUri = data;
			http.open("HEAD", imgUri, false);
			http.send();
			if(http.status == 404)
			{
				let imgSrc = location.origin + "/f/g/no-image.png";
				return imgSrc;
			}
			else
			{
				let imgSrc = imgUri;
				return imgSrc;
			}
		}
		caim[i].style.minHeight = caim[i].clientHeight + "px";
		caim[i].setAttribute("alt", "");
		caim[i].setAttribute("src", "");
		setTimeout(function()
		{
			caim[i].classList.add("show");
			caim[i].setAttribute("alt", alt);
			caim[i].setAttribute("src", imgFile(src));
		},1000*(i+1));
	}
}
},1500);
el(".heright .menu .btn-menu", "click", butmen);
function butmen()
{
	bdy.classList.toggle("tglmn");
	sq(".post").classList.toggle("tglmn");
	let btn = sq(".heright .menu .btn-menu");
	btn.classList.toggle("toggle");
	butfix.classList.remove("bfs");
	let bm = sq(".box-menu");
	bm.classList.toggle("toggle");
}
let lm = sqa(".header .box-menu ul li");
for(let i = 0; i < lm.length; i++)
{
	lm[i].onclick = function()
	{
		let tgm = this.getAttribute("target");
		wlh(tgm);
	}
}
if(sq(".post .slot .img img") != null)
{
	let imgSlot = sq(".post .slot .img"), img = sq(".post .slot .img img"), th5 = sq(".post .slot .txt h5"), tp = sq(".post .slot .txt p"), src = img.getAttribute("src"), hims = img.clientHeight, wims = img.clientWidth;
	imgSlot.style.minHeight = hims + "px";
	imgSlot.style.maxWidth = wims + "px";
	img.setAttribute("src", "");
	let th5h = th5.clientHeight,
	tph = tp.clientHeight,
	th51 = th5.innerText,
	th52 = th51.split(""),
	tp1 = tp.innerText,
	tp2 = tp1.split("");
	th5.innerHTML = "";
	tp.innerHTML = "";
	th5.style.height = th5h + "px";
	tp.style.height = tph + "px";
	setTimeout(function()
	{
		for(let x = 0; x < th52.length; x++)
		{
			setTimeout(function()
			{
				th5.classList.add("show");
				th5.innerHTML += th52[x];
			},75*(x));
		}
		for(let x = 0; x < tp2.length; x++)
		{
			setTimeout(function()
			{
				tp.classList.add("show");
				tp.innerHTML += tp2[x];
			},15*(x));
		}
		imgSlot.classList.add("show");
		img.setAttribute("src", src);
	},2500);
}
if(sq(".boxads") != null)
{
	let boxads = sqa(".boxads"), imgads = sqa(".boxads .img img");
	for(let i = 0; i < imgads.length; i++)
	{
		let hima = imgads[i].clientHeight, wima = imgads[i].clientWidth, alt = imgads[i].getAttribute("alt"), src = imgads[i].getAttribute("src");
		imgads[i].style.minHeight = hima + "px";
		imgads[i].style.minWidth = wima + "px";
		imgads[i].setAttribute("alt","");
		imgads[i].setAttribute("src","");
		imgads[i].style.opacity = 0;
		imgads[i].style.transition = "all 1s ease-in-out";
		setTimeout(function()
		{
			imgads[i].style.opacity = 1;
			imgads[i].setAttribute("alt",alt);
			imgads[i].setAttribute("src",src);
		},2500);
	}
	let th5 = sq(".boxads .txt h5"), tp = sq(".boxads .txt p"),
	th5h = th5.clientHeight,
	tph = tp.clientHeight,
	th51 = th5.innerText,
	th52 = th51.split(""),
	tp1 = tp.innerText,
	tp2 = tp1.split("");
	th5.innerHTML = "";
	tp.innerHTML = "";
	th5.style.height = th5h + "px";
	tp.style.height = tph + "px";
	setTimeout(function()
	{
		for(let x = 0; x < th52.length; x++)
		{
			setTimeout(function()
			{
				th5.innerHTML += th52[x];
			},75*(x));
		}
		for(let x = 0; x < tp2.length; x++)
		{
			setTimeout(function()
			{
				tp.innerHTML += tp2[x];
			},20*(x));
		}
	},2500);
	for(let i = 0; i < boxads.length; i++)
	{
		let bxd = boxads[i].getAttribute("data-source");
		if(bxd != "")
		{
			boxads[i].onclick = function()
			{
				window.open(atob(bxd));
			}
		}
	}
}
if(sq(".slot") != null)
{
	let boxads = sqa(".slot"), imgads = sqa(".slot .img img");
	for(let i = 0; i < imgads.length; i++)
	{
		let hima = imgads[i].clientHeight, wima = imgads[i].clientWidth;
		imgads[i].style.minHeight = hima + "px";
		imgads[i].style.minWidth = wima + "px";
	}
	for(let i = 0; i < boxads.length; i++)
	{
		let bxd = boxads[i].getAttribute("data-source");
		if(bxd != "")
		{
			boxads[i].onclick = function()
			{
				window.open(atob(bxd));
			}
		}
	}
}
let cCard = sqa(".post .post-card");
for(let i = 0; i < cCard.length; i++)
{
	cCard[i].onclick = function()
	{
		let data_target = cCard[i].getAttribute("target");
		if(atob(data_target) != "NOTTARGET")
		{
			wlh(atob(data_target));
		}
		else
		{
			let notFound = window.open("", "Not Found!", "width=768, height=500");
			notFound.document.write(`
				<div style="text-align:center">
				<h1 style="color:brown;font-size:3em;margin:50% 0 70px">Halaman Belum Tersedia!</h1>
				<a href="#" onclick="window.close()" style="font-size:1.5em">Kembali</a>
				</div>
			`);
		}
	}
}
if(sq(".post .cover img") != null || sq(".post .isiart img") != null)
{
	let styvim = `<style>*{box-sizing:border-box;margin:0;padding:0;}.box-view{background-color:rgba(0,0,30,.9);bottom:0;left:0;margin:0;padding:0;position:absolute;right:0;top:0;}.box-view .btn-close{background-color:#fafafa;border:0;border-radius:50%;box-shadow:0 0 0 2px #555, 0 0 100px black;color:brown;cursor:pointer;font-size:2em;height:50px;line-height:50px;padding:0;position:absolute;right:50px;top:50px;width:50px;z-index:5;}.box-view .btn-close:hover{background-color:#eee;color:maroon;box-shadow:none;}.box-view img{background-color:white;display:block;left:50%;position:relative;top:50%;transform:translate(-50%,-50%);width:100%;z-index:1;}</style>`;
	el(".post .cover img", "click", opcoim);
	function opcoim()
	{
		let cvr = sq(".post .cover img"), alt = cvr.getAttribute("alt"), src = cvr.getAttribute("src"), imgCover = window.open("", alt, "width=768, height=500");
		imgCover.document.write(styvim + `<div class="box-view"><button onclick="window.close()" class="btn-close" title="Close">&times;</button><img alt="` + alt + `" src="` + src + `"/></div>`);
	}
	let imps = sqa(".post .isiart img");
	for(let i = 0; i < imps.length; i++)
	{
		imps[i].onclick = opimpo;
		function opimpo()
		{
			let alt = imps[i].getAttribute("alt"), src = imps[i].getAttribute("src"), imgPost = window.open("", alt, "width=768, height=500");
			imgPost.document.write(styvim + `<div class="box-view"><button onclick="window.close()" class="btn-close" title="Close">&times;</button><img alt="` + alt + `" src="` + src + `"/></div>`);
		}
	}
}
el(".subbox form.subscribe", "submit", subs);
function subs(e)
{
	e.preventDefault();
	const em = sq(".subbox form.subscribe .email"), er = sq(".subbox form.subscribe .error"), se = sq(".subbox form.subscribe .submit-email");
	er.innerText = "";
	if(em.value == "")
	{
		em.focus();
		er.innerText = "Harap masukkan email Anda!";
		return false;
	}
	else
	{
		const data = new FormData();
		data.append("email", em.value);
		data.append("submit_email", se.value);
		let http = new XMLHttpRequest();
		http.open("POST", "../proses", true);
		http.onloadstart = function()
		{
			ldr.classList.add("show");
			se.innerText = "Proses...";
		}
		http.onreadystatechange = function()
		{
			if(this.readyState == 4 && this.status == 200)
			{
				const rsp = JSON.parse(this.responseText);
				if(rsp.yes == true)
				{
					em.value = "";
					se.innerText = "Sukses";
					setTimeout(function()
					{
						ldr.classList.remove("show");
					},3000);
					setTimeout(function()
					{
						alert(rsp.msg);
					},4000);
					setTimeout(function()
					{
						se.innerText = "Subscribe";
					},5000);
				}
				else if(rsp.no == true)
				{
					ldr.classList.remove("show");
					alert(rsp.msg);
				}
				else if(rsp.em == true)
				{
					em.value = "";
					setTimeout(function()
					{
						ldr.classList.remove("show");
					},3000);
					setTimeout(function()
					{
						alert(rsp.msg);
					},4000);
					setTimeout(function()
					{
						se.innerText = "Subscribe";
					},5000);
				}
			}
		};
		http.send(data);
	}
}
el("form#kontak_admin", "submit", conad);
function conad(e)
{
	e.preventDefault();
	const eml = sq("#kontak_admin #email"), msg = sq("#kontak_admin #pesan"), err = sqa("#kontak_admin .err"), subut = sq("#kontak_admin #kirim_pesan_admin"), errEml = "Masukkan email Anda!", errMsg = "Tulis pesan Anda!";
	for(let i = 0; i < err.length; i++)
	{
		err[i].innerText = "";
	}
	if(eml.value == "")
	{
		eml.focus();
		err[0].innerText = errEml;
		return false;
	}
	else if(msg.value == "")
	{
		msg.focus();
		err[1].innerText = errMsg;
		return false;
	}
	else
	{
		const data = new FormData();
		data.append("email", eml.value);
		data.append("pesan", msg.value);
		data.append("kirim_pesan_admin", subut.value);
		const http = new XMLHttpRequest();
		http.open("POST","../proses",true);
		http.onloadstart = function()
		{
			ldr.classList.add("show");
			subut.innerText = "Mengirim...";
		}
		http.onreadystatechange = function()
		{
			const rsp = JSON.parse(this.responseText);
			if(rsp.yes == true)
			{
				ldr.classList.remove("show");
				setTimeout(function()
				{
					eml.value = "";
					msg.value = "";
					subut.innerText = "Kirim";
					alert(rsp.msg);
				},100);
			}
			else if(rsp.no == true)
			{
				ldr.classList.remove("show");
				setTimeout(function()
				{
					subut.innerText = "Kirim";
					alert(rsp.msg);
				},100);
			}
		};
		http.send(data);
	}
}
el(".butbox .but-fix button.btn-plus", "click", adart);
function adart()
{
	let aa = sq(".butbox .but-fix button.btn-plus");
	wlh(atob(aa.getAttribute("data-tp"))+aa.getAttribute("data-td"));
}
el(".butbox .but-fix button.btn-sct", "click", sct);
function sct()
{
	window.scroll(
	{
		top: 0,
		left: 0,
		behavior: "smooth"
	});
}
el(".heleft h1", "click", bth);
function bth()
{
	wlh(atob(sq(".heleft").getAttribute("gth")));
}
const ga = sqa(".box-nepo");
for(let i = 0; i < ga.length; i++)
{
	ga[i].onclick = function()
	{
		let da = ga[i].getAttribute("data-art");
		wlh(atob(da));
	}
}
function wScroll()
{
	let sco = window.pageYOffset, mts = 1000, mte = 2000;
	window.onscroll = function()
	{
		let sce = window.pageYOffset, hostog = sq(".header"), blopo = sq(".block-post");
		if(sco > sce)
		{
			setTimeout(function()
			{
				hostog.classList.remove("hostog");
				blopo.classList.remove("scr");
			},250);
		}
		else
		{
			setTimeout(function()
			{
				hostog.classList.add("hostog");
				blopo.classList.add("scr");
			},250);
		} sco = sce;
		if(sce > mts && sce < bdy.clientHeight-mte)
		{
			butfix.classList.add("bfs");
		}
		else
		{
			butfix.classList.remove("bfs");
		}
	}
}
return wScroll();
});
