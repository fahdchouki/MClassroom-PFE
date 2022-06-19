let myheader = document.querySelector(".header");
let mybuttonmenu = document.querySelector(".menu-btn");

window.addEventListener('scroll', function () {
        
        if(window.scrollY > 0){
                
                myheader.classList.add('sticky');
                mybuttonmenu.classList.add('sticky');
        }else{
                myheader.classList.remove('sticky')
                mybuttonmenu.classList.remove('sticky')
        }
})




let menubutton = document.querySelector('.menu-btn');
let mynav = document.querySelector('nav');

menubutton.onclick = function(){
        this.classList.toggle('active');
        mynav.classList.toggle('active');
}


/*-----------------------------------*/

let allnav = document.querySelectorAll('nav');

allnav.forEach(nv => {
        nv.addEventListener('click', (e) =>{

                if(mynav.classList.contains('active') && menubutton.classList.contains('active')){
                        mynav.classList.remove('active');
                        menubutton.classList.remove('active');
                }

        })
})