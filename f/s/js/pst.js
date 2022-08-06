window.addEventListener("DOMContentLoaded", () =>
{
let body = sq("body"), loader = sq(".loadani"), i;
(function()
{
    let pre = sqa('pre'), pl = pre.length, pc = sqa("pre code");
	for(i = 0; i < pc.length; i++)
	{
		x = pc[i].innerHTML;
		x = x.split(/\n/g).filter(x => x).join('\n');
		pc[i].innerHTML = x;
	}
    for(i = 0; i < pl; i++)
	{
		x = pre[i].innerHTML;
		x = x.split(/\n/g).filter(x => x).join('\n');
		pre[i].innerHTML = x;
        pre[i].innerHTML = `<span class="line-number"></span>` + pre[i].innerHTML + `<span class="cl"></span>`;
        let num = pre[i].innerHTML.split(/\n/).length;
        for (let n = 0; n < num; n++) {
            let line_num = pre[i].querySelectorAll("span")[0];
            line_num.innerHTML += `<span>` + (n+1) + `</span>`;
        }
    }
})();
let pre = sqa("pre"), a = sqa("pre code");
for(let i = 0; i <pre.length; i++)
{
	let b = a[i].clientHeight, c = b / (2);
	if(c >= 250)
	{
 		pre[i].style.height = c + "px";
	}
	else
	{
		pre[i].style.height = "180px";
	}
	pre[i].onclick = function()
	{
		let cds = sqa("code"), cdsTxt = cds[i].textContent, textar = document.createElement("textarea");
		cds[i].append(textar);
		textar.textContent = cdsTxt;
		textar.select();
		document.execCommand("copy");
		cds[i].classList.add("show");
		setTimeout(function()
		{
			cds[i].classList.remove("show");
		},3000);
		textar.remove();
	}
}
function synter()
{
	let c = sqa("code");
	for(let i = 0; i < c.length; i++)
	{
		cd = c[i].innerHTML,
		cd = cd.replace(/"(.*?)"/g, '&quot;$1&quot;'.fontcolor('gold')),
		cd = cd.replace(/'\$(.*?)'/g, '&apos;&#36$1&apos;'.fontcolor('gold')),
		cd = cd.replace(/'(.*?)'/g, '&apos;$1&apos;'.fontcolor('gold')),
		cd = cd.replace(/\/\*(.*?)\*\//g, '/*$1*/'.fontcolor('gray')),
		cd = cd.replace(/&lt;!--(.*?);/g, '&lt;!--$1'.fontcolor('gray')),
		cd = cd.replace(/--&gt;/g, '--&gt;'.fontcolor('gray')),
		cd = cd.replace(/&lt;\s/g, '&lt; '.fontcolor('crimson')),
		cd = cd.replace(/&lt;([a-z0-9\/]+)&gt;/g, '&lt;$1&gt;'.fontcolor('crimson')),
		cd = cd.replace(/&lt;(.[a-zA-Z0-9]+)/g, '&lt;$1'.fontcolor('crimson')),
		cd = cd.replace(/&lt;([a-zA-Z0-9]+)/g, '&lt;$1'.fontcolor('crimson')),
		cd = cd.replace(/\/&gt;/g, '/&gt;'.fontcolor('crimson')),
		cd = cd.replace(/\&gt;/g, '&gt;'.fontcolor('crimson')),
		cd = cd.replace(/\?&gt;/g, '?&gt;'.fontcolor('crimson')),
		cd = cd.replace(/\/&gt;/g, '/&gt;'.fontcolor('crimson')),
		cd = cd.replace(/([a-z]+)&gt;/g, '$1'+'&gt;'.fontcolor('crimson')),
		cd = cd.replace(/\$(.[a-zA-Z0-9_]+)?/g, '&#36$1'.fontcolor('deeppink')),
		cd = cd.replace(/\array(.*?)\(/g, 'array$1'.fontcolor('deeppink')+'('),
		cd = cd.replace(/(http\:\/\/)/g, ''),
		cd = cd.replace(/(https\:\/\/)/g, ''),
		cd = cd.replace(/"(.*?)\/\//g, '$1'),
		cd = cd.replace(/\/\/(.*?)\n/g, '\/\/$1\n'.fontcolor('gray')),
		cd = cd.replace(/require/g, 'require'.fontcolor('deepskyblue')),
		cd = cd.replace(/include/g, 'include'.fontcolor('dodgerblue')),
		cd = cd.replace(/\[(.*?)\]/g, '['+'$1'.fontcolor('greenyellow')+']'),
		cd = cd.replace(/\+/g, '+'.fontcolor('deepskyblue')),
		cd = cd.replace(/if(.*?)\(/g, 'if$1'.fontcolor('dodgerblue')+'('),
		cd = cd.replace(/isset/g, 'isset'.fontcolor('aqua')),
		cd = cd.replace(/echo /g, 'echo '.fontcolor('skyblue')),
		cd = cd.replace(/true/g, 'true'.fontcolor('salmon')),
		cd = cd.replace(/false/g, 'false'.fontcolor('salmon')),
		cd = cd.replace(/return /g, 'return '.fontcolor('deepskyblue')),
		cd = cd.replace(/}else/g, '}'+'else'.fontcolor('dodgerblue')),
		cd = cd.replace(/&lt;!(.[A-Z]+)/g, '&lt;'+'!$1'.fontcolor('gray')),
		cd = cd.replace(/for\(/g, 'for'.fontcolor('dodgerblue')+'('),
		cd = cd.replace(/const/g, 'const'.fontcolor('skyblue')),
		cd = cd.replace(/let\s/g, 'let '.fontcolor('skyblue')),
		cd = cd.replace(/\s\=\s/g, ' = '.fontcolor('greenyellow')),
		cd = cd.replace(/\s\==\s/g, ' == '.fontcolor('greenyellow')),
		cd = cd.replace(/\s\===\s/g, ' === '.fontcolor('greenyellow')),
		cd = cd.replace(/\n(.*?)\:/g, '\n'+'$1'.fontcolor('tan')+ ': '),
		cd = cd.replace(/\:(.*?)\;/g, ':'+'$1'.fontcolor('tan')+';'),
		c[i].innerHTML = cd;
	}
}
window.addEventListener("load", synter);
let shart = sqa(".share-art span");
for(let i = 0; i < shart.length; i++)
{
	shart[i].onclick = function()
	{
		let target = shart[i].getAttribute("target-s"), txt = shart[i].innerText;
		if(txt == "Facebook")
		{
			window.open(target,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
			return false;
		}
		else
		{
			wlh(target);
		}
	}
}
if(sq(".post .edha span.edit") != null)
{
	el(".post .edha span.edit", "click", edart);
	function edart()
	{
		body.classList.add("actldr");
		loader.classList.add("show");
		let drc = sq(".post .edha span.edit");
		wlh(drc.getAttribute("target"));
	}
}
if(sq(".post .edha span.hps") != null)
{
	el(".post .edha span.hps", "click", delart);
	function delart()
	{
		if(confirm("Yakin hapus posting ini?") == true)
		{
			const bha = sq(".post .edha span.hps");
			const hps = atob(bha.getAttribute("target-hps"));
			const data = new FormData();
			data.append("url", hps);
			data.append("hapus_artikel", "");
			const http = new XMLHttpRequest();
			http.open("POST", "../proses", true);
			http.onloadstart = function()
			{
				body.classList.add("actldr");
				loader.classList.add("show");
			}
			http.onreadystatechange = function()
			{
				if(this.readyState == 4 && this.status == 200)
				{
					const rsp = JSON.parse(this.responseText);
					if(rsp.yes == true)
					{
						body.classList.remove("actldr");
						loader.classList.remove("show");
						setTimeout(function()
						{
							window.location.href = rsp.drc;
							alert(rsp.msg);
						},500);
					}
					else if(rsp.no == true)
					{
						body.classList.remove("actldr");
						loader.classList.remove("show");
						alert(rsp.msg);
					}
				}
			};
			http.send(data);
		}
	}
}
el(".prenex .prev", "click", prevPost);
function prevPost(e)
{
	e.preventDefault();
	let getPrev = sq(".prenex .prev").getAttribute("data-prev");
	if(getPrev != null)
	{
		loader.classList.add("show");
		wlh(atob(getPrev));
	}
}
el(".prenex .home", "click", backHome);
function backHome(e)
{
	e.preventDefault();
	loader.classList.add("show");
	let getHome = sq(".prenex .home").getAttribute("data-home");
	wlh(atob(getHome));
}
el(".prenex .next", "click", nextPost);
function nextPost(e)
{
	e.preventDefault();
	let getNext = sq(".prenex .next").getAttribute("data-next");
	if(getNext != null)
	{
		loader.classList.add("show");
	wlh(atob(getNext));
	}
}
el(".sbc a", "click", subs);
function subs(e)
{
	e.preventDefault();
	sq(".subbox form.subscribe input.email").focus();
}
el(".krisan span", "click", krisan);
function krisan()
{
	body.classList.add("actldr");
	sq(".krisbox").classList.add("show");
el(".krisbox form.fks", "submit", fks);
	function fks(e)
	{
		e.preventDefault();
		const slt = sq(".krisbox select.pilkrisan"), eml = sq(".krisbox input.eml"), msg = sq(".krisbox textarea.msg"), err = sqa(".krisbox .err"), trg = sq(".krisbox input.target");
		for(let i = 0; i < err.length; i++)
		{
			err[i].classList.remove("show");
		}
		if(slt.value == "")
		{
			slt.focus();
			err[0].classList.add("show");
			return false;
		}
		else if(eml.value == "")
		{
			eml.focus();
			err[1].classList.add("show");
			return false;
		}
		else if(msg.value == "")
		{
			msg.focus();
			err[2].classList.add("show");
			return false;
		}
		else
		{
			const data = new FormData();
			data.append("slt", slt.value);
			data.append("eml", eml.value);
			data.append("msg", msg.value);
			data.append("target", atob(trg.value));
			data.append("krisan", "");
			const http = new XMLHttpRequest();
			http.open("POST", "../proses", true);
			http.onloadstart = function()
			{
				loader.classList.add("show");
			}
			http.onreadystatechange = function()
			{
				if(this.readyState == 4 && this.status == 200)
				{
					const rsp = JSON.parse(this.responseText);
					if(rsp.yes == true)
					{
						body.classList.remove("actldr");
						loader.classList.remove("show");
						sq(".krisbox").classList.remove("show");
						sq(".krisbox form.fks").reset();
						setTimeout(function()
						{
							alert(rsp.msg);
						},500);
						sq(".krisbox form.fks").removeEventListener("submit", fks);
					}
					else
					{
						body.classList.remove("actldr");
						loader.classList.remove("show");
						sq(".krisbox").classList.remove("show");
						alert(rsp.msg);
					}
				}
			};
			http.send(data);
			sq(".krisbox form.fks").removeEventListener("submit", fks);
		}
	}
	el(".krisbox form.fks .cls", "click", close);
	function close()
	{
		body.classList.remove("actldr");
		sq(".krisbox").classList.remove("show");
		sq(".krisbox form.fks").reset();
		let err = sqa(".krisbox .err");
		for(let i = 0; i < err.length; i++)
		{
			err[i].classList.remove("show");
		}
	}
}
el(".report span", "click", report);
function report()
{
	body.classList.add("actldr");
	sq(".rebox").classList.add("show");
	el(".rebox input.sst", "change", chang);
	function chang()
	{
		const ss = sq(".rebox input.sst"), sst = ss.value, ext = /(\.jpg|\.jpeg|\.png)$/i;
		if(!ext.exec(sst))
		{
			sqa(".rebox .err")[2].classList.add("show");
			return false;
		}
		else
		{
			sqa(".rebox .err")[2].classList.remove("show");
		}
	}
	el(".rebox form.frp", "submit", frp);
	function frp(e)
	{
		e.preventDefault();
		const eml = sq(".rebox input.eml"), msg = sq(".rebox textarea.msg"), err = sqa(".rebox .err"), trg = sq(".rebox input.target"), ss = sq(".rebox input.sst"), sst = ss.value, ext = /(\.jpg|\.jpeg|\.png)$/i;
		for(let i = 0; i < err.length; i++)
		{
			err[i].classList.remove("show");
		}
		if(eml.value == "")
		{
			eml.focus();
			err[0].classList.add("show");
			return false;
		}
		else if(msg.value == "")
		{
			msg.focus();
			err[1].classList.add("show");
			return false;
		}
		else if(sst == "")
		{
			ss.focus();
			err[2].classList.add("show");
			return false;
		}
		else if(!ext.exec(sst))
		{
			ss.focus();
			err[2].classList.add("show");
			return false;
		}
		else
		{
			const data = new FormData();
			data.append("eml", eml.value);
			data.append("msg", msg.value);
			data.append("sst", ss.files[0]);
			data.append("target", atob(trg.value));
			data.append("lapkon", "");
			const http = new XMLHttpRequest();
			http.open("POST", "../proses", true);
			http.onloadstart = function()
			{
				loader.classList.add("show");
			}
			http.onreadystatechange = function()
			{
				if(this.readyState == 4 && this.status == 200)
				{
					const rsp = JSON.parse(this.responseText);
					if(rsp.yes == true)
					{
						body.classList.remove("actldr");
						loader.classList.remove("show");
						sq(".rebox").classList.remove("show");
						sq(".rebox form.frp").reset();
						setTimeout(function()
						{
							alert(rsp.msg);
						},500);
						sq(".rebox form.frp").removeEventListener("submit", frp);
					}
					else
					{
						body.classList.remove("actldr");
						loader.classList.remove("show");
						sq(".rebox").classList.remove("show");
						alert(rsp.msg);
					}
				}
			};
			http.send(data);
			sq(".rebox form.frp").removeEventListener("submit", frp);
		}
	}
	el(".rebox form.frp .cls", "click", close);
	function close()
	{
		body.classList.remove("actldr");
		sq(".rebox").classList.remove("show");
		sq(".rebox form.frp").reset();
		let err = sqa(".rebox .err");
		for(let i = 0; i < err.length; i++)
		{
			err[i].classList.remove("show");
		}
	}
}
let rel = sqa(".relbox");
for(let i = 0; i < rel.length; i++)
{
	rel[i].onclick = function()
	{
		sq(".loadani").classList.add("show");
		wlh(atob(rel[i].getAttribute("data-view")));
	}
}
if(sq("body").getAttribute("load") != "loaded" && sq("body").getAttribute("load") != "")
{
	let drc = sq("body").getAttribute("load");
	sq(".komentar").onclick = function()
	{
		let cnf = confirm("Harap login dulu!"), ms = "../akses/masuk/";
		if(cnf == true)
		{
			wlh(ms+drc);
			return false;
		}
	}
	el(".form-cmn", "submit", lcm);
	function lcm(e)
	{
		e.preventDefault();
		if(sq(".nama").value == "")
		{
			let cnf = confirm("Harap login dulu!"), ms = "../akses/masuk/";
			if(cnf == true)
			{
				wlh(ms+drc);
				return false;
			}
			return false;
		}
	}
}
let coms = sq(".coms");
coms.onclick = function()
{
	let fm = sq("#form-com"),
	ch = fm.offsetTop+110;
	window.scroll({
		top: ch,
		left: 0,
		behavior: "smooth"
	});
}
el(".cmn .ic", "click", nc);
function nc()
{
	alert(atob(sq(".cmn .ic").getAttribute("ntf")));
}
sq(".komentar").onfocus = function()
{
	sq(".but-fix").style.bottom = "-100%";
}
sq(".komentar").onblur = function ()
{
	sq(".but-fix").style.bottom = 0;
}
let fk = sq(".form-cmn");
fk.addEventListener("submit",function(e)
{
	e.preventDefault();
	let tg = sq(".target"), nm = sq(".nama"), km = sq(".komentar"), err = sq(".error"), kk = sq(".kirim-komentar");
	err.innerText = "";
	let ftr = km.getAttribute("filter"), rpc = "/"+atob(ftr)+"/g";
	if(km.value == "")
	{
		km.focus();
		err.innerText = "Masukkan komentar Anda!";
		return false;
	}
	else if(km.value.match(rpc))
	{
		km.focus();
		err.innerText = "Terdapat kata tidak pantas atau karakter yang tidak diizinkan, mohon koreksi! Terima kasih.";
		return false;
	}
	else if(km.value.leng > 150)
	{
		km.focus();
		err.innerText = "Maksimal 150 karakter!";
		return false;
	}
	else
	{
		const data = new FormData();
		data.append("target", tg.value);
		data.append("nama", nm.value);
		data.append("komentar", km.value);
		data.append("kirim_komentar", kk.value);
		const http=new XMLHttpRequest();
		http.onloadstart = function()
		{
			sq(".kirim-komentar").innerText = "Mengirim...";
		}
		http.open("POST", "../proses", true);
		http.onreadystatechange = function()
		{
			if(this.readyState == 4 && this.status == 200)
			{
				const rsp = JSON.parse(this.responseText);
				if(rsp.yes == true)
				{
					km.value = "";
					window.location.reload();
				}
				else if(rsp.no == true)
				{
					err.innerText = rsp.msg;
					kk.innerText = rsp.txt;
				}
			}
		};
		http.send(data);
	}
});
let dlt = sqa(".del-cmn");
for(let i = 0; i < dlt.length; i++)
{
	dlt[i].onclick = function()
	{
		let del = dlt[i].getAttribute("data-target"), cnf = confirm("Hapus komentar?");
		if(cnf == true)
		{
			const data = new FormData();
			data.append("target", del);
			data.append("hadako", "");
			const http = new XMLHttpRequest();
			http.open("POST", "../proses", true);
			http.onreadystatechange = function()
			{
				if(this.readyState == 4 && this.status == 200)
				{
					const rsp = JSON.parse(this.responseText);
					if(rsp.yes == true)
					{
						alert(rsp.msg);
						window.location.reload();
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
});
