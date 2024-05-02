$(document).ready(()=>{
    
})

var btn = document.getElementsByClassName('drop');
for (var i=0;i<btn.length;i++) {
    btn[i].addEventListener('click', function(){
        this.classList.toggle('active');
        this.nextElementSibling.classList.toggle('active');
    })
}