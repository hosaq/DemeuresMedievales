/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Animation {
    
    static slideUp(element) {
        let cellule1=document.querySelector(".cellule1");
        setTimeout(element.style.display="block",10000);
        cellule1.style.display="none";
        let gauche= document.querySelector(".gauche") ;
        gauche.style= "grid-area:photo; justify-self: center;align-self: center;";
    }
    static slideDown(element) {
         let cellule1=document.querySelector(".cellule1");
       element.style.display="none";
       cellule1.style.display="block";
       let gauche= document.querySelector(".gauche") ;
       gauche.style= "grid-area:photo; justify-self: center;";
    }
}
console.log("nombrePhotos");
const cellule2=document.querySelector(".cellule2");
const cellule3=document.querySelector(".cellule3");

let pres= document.querySelector(".vignet2");
pres.addEventListener("mouseover", function (e) {
    Animation.slideUp(cellule2);
});
document.querySelector(".vignet2").addEventListener("mouseout", function () {
    Animation.slideDown(cellule2);
}); 

let des= document.querySelector(".vignet3");
des.addEventListener("mouseover", function (e) {
    Animation.slideUp(cellule3);
});
document.querySelector(".vignet3").addEventListener("mouseout", function () {
    Animation.slideDown(cellule3);
}); 