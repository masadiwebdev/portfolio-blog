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