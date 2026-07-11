// =======================
// Ripple Effect
// =======================

document.querySelectorAll(".btn,.quick-card").forEach(button=>{

button.addEventListener("click",function(e){

const circle=document.createElement("span");

circle.classList.add("ripple");

const x=e.clientX-this.offsetLeft;

const y=e.clientY-this.offsetTop;

circle.style.left=x+"px";

circle.style.top=y+"px";

this.appendChild(circle);

setTimeout(()=>{

circle.remove();

},600);

});

});


// =======================
// Loading Bar
// =======================

const loader=document.getElementById("loader");

document.querySelectorAll("a").forEach(link=>{

link.addEventListener("click",function(){

loader.style.transform="scaleX(1)";

});

});

window.addEventListener("load",()=>{

loader.style.transform="scaleX(0)";

});


// =======================
// Sidebar Mobile
// =======================

const toggle=document.getElementById("toggleSidebar");

const sidebar=document.querySelector(".sidebar");

if(toggle){

toggle.addEventListener("click",()=>{

sidebar.classList.toggle("active");

});

}


// =======================
// Card Animation
// =======================

const cards=document.querySelectorAll(".dashboard-card");

cards.forEach(card=>{

card.addEventListener("mouseenter",()=>{

card.style.transform="translateY(-10px)";

});

card.addEventListener("mouseleave",()=>{

card.style.transform="translateY(0)";

});

});


// =======================
// Fade on Scroll
// =======================

const observer=new IntersectionObserver(entries=>{

entries.forEach(entry=>{

if(entry.isIntersecting){

entry.target.style.opacity=1;

entry.target.style.transform="translateY(0)";

}

});

});

document.querySelectorAll(".card,.dashboard-card,.quick-card").forEach(el=>{

el.style.opacity=0;

el.style.transform="translateY(40px)";

el.style.transition=".5s";

observer.observe(el);

});