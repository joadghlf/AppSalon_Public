function buscador(){const e=document.querySelector(".admin #buscadorFecha"),o=document.querySelector(".admin #buscador");if(e&&e.addEventListener("input",(function(){const o=e.value;window.location="?fecha="+o})),o){const e=document.querySelectorAll(".busqueda-class");o.addEventListener("keyup",(function(){console.log(o.value),e.forEach(e=>{e.textContent.toLocaleLowerCase().includes(o.value.toLocaleLowerCase())?e.parentNode.parentNode.classList.remove("display-none"):e.parentNode.parentNode.classList.add("display-none")})}))}}document.addEventListener("DOMContentLoaded",(function(){buscador()}));