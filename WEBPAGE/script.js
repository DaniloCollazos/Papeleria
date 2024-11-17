const header = document.querySelector('header');
function fixedNavbar(){
    header.classList.toggle('scroll',window.pageYOffset > 0)
}
fixedNavbar();
window.addEventListener('scroll', fixedNavbar);

let menu = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');

menu.addEventListener('click', function(){
    let nav = document.querySelector('.navbar');
    nav.classList.toggle('active');
})
userBtn.addEventListener('click', function(){
    let userBox = document.querySelector('.user-box');
    userBox.classList.toggle('active');
})



/*------------home page slider-----------*/
const leftArrow = document.querySelector('.left-arrow .bxs-arrow-left');
const rightArrow = document.querySelector('.right-arrow .bxs-arrow-right');
const slider = document.querySelector('.slider');
     /*------------scroll to right-----------*/
     function scrollRight(){
        if (slider.scrollWidth - slider.clientWidth === slider.scrollLeft){
            slider.scrollTo({
                left: 0,
                behavior: "smooth"
            });
        }else{
            slider.scrollBy({
                left: window.innerWidth,
                behavior: "smooth"
            })
        }
     }
      /*------------scroll to right-----------*/
      function scrollLeft(){
        slider.scrollBy({
            left: -window.innerWidth,
            behavior: "smooth"
        })
      }
let timerId = setInterval(scrollRight, 7000);

/*------------reset timer to scroll right-----------*/
function resetTimer(){
    clearInterval(timerId);
    timerId = setInterval(scrollRight, 7000);
}
/*------------rscroll event-----------*/
slider.addEventListener('click', function(ev){
    if (ev.target === leftArrow){
        scrollLeft();
        resetTimer();
    }
})
slider.addEventListener('click', function(ev){
    if (ev.target === rightArrow){
        scrollright();
        resetTimer();
    }
})