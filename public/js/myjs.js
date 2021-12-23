const hidemenu = document.querySelector(".hide-menu-button");
const showmenu = document.querySelector(".show-menu-button");
const sidebar = document.querySelector(".sidebar-normal");
const sidebar_mobile = document.querySelector(".sidebar-mobile");
const menu_group = document.querySelectorAll(".menu-group");
const menu_detail = document.querySelectorAll(".menu-detail");
const arrow_menu = document.querySelectorAll(".arrow-menu");
const mobile_main_menu = document.querySelectorAll(".mobile-main-menu");
const mobile_sub_menu = document.querySelectorAll(".mobile-sub-menu");

for (let i = 0; i < menu_group.length; i++) {
    menu_group[i].addEventListener("click", () => {
        menu_detail[i].classList.toggle("hidden");
        arrow_menu[i].classList.toggle("rotate-180");
    });
    
}

hidemenu.addEventListener("click", () => {
    let page_content = document.querySelector(".page-content");

    page_content.classList.remove("page-content");
    page_content.classList.add("page-content-mobile");
    sidebar_mobile.classList.remove("transform","-translate-x-full");
    sidebar.classList.add("transform", "-translate-x-full");

});

showmenu.addEventListener("click", () => {
    let page_content = document.querySelector(".page-content-mobile");
    
    page_content.classList.remove("page-content-mobile");
    page_content.classList.add("page-content");
    sidebar_mobile.classList.add("transform","-translate-x-full");
    sidebar.classList.remove("transform", "-translate-x-full");

    closeMobileSubMenu();
});

for (let i = 0; i < mobile_main_menu.length; i++) {
    mobile_main_menu[i].addEventListener("click", () => {
        toggleMobileSubMenu(i);
    });
    
}

function toggleMobileSubMenu(index){
    mobile_sub_menu[index].classList.toggle("transform");
    mobile_sub_menu[index].classList.toggle("opacity-100");
    mobile_sub_menu[index].classList.toggle("-translate-y-2");
    mobile_sub_menu[index].classList.toggle("pointer-events-none");
    // console.log(mobile_sub_menu[index]);
}

function closeMobileSubMenu(){
    for (let i = 0; i < mobile_sub_menu.length; i++) {
        mobile_sub_menu[i].classList.remove("transform");
        mobile_sub_menu[i].classList.remove("opacity-100");
        mobile_sub_menu[i].classList.remove("-translate-y-2");
        mobile_sub_menu[i].classList.add("pointer-events-none");
    }
    
}