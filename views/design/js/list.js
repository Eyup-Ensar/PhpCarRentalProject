const UIcontroller = (function(){
    const select = {
        table: '.table',
        theadtd: 'theadtd',
        tbodytd: 'tbodytd',
    }
    return {
        getSelects: function(){
            return select
        },
        listDesign: function(number){
            const openModal = document.querySelectorAll(".openModal");
            const theadtd = document.getElementsByClassName(select.theadtd)[0].children;
            const tbodytd = document.getElementsByClassName(select.tbodytd);
            var gecici = theadtd.length - number + 1;
            for (let i = theadtd.length - 2; i >= 0; i--) {
                gecici--;
                if(gecici > 0) { 
                    !theadtd.item(i).classList.contains("d-none") ? theadtd.item(i).classList.add("d-none") : null;
                } else {
                    theadtd.item(i).classList.contains("d-none") ? theadtd.item(i).classList.remove("d-none") : null;
                }
            }
            for (let j = 0; j < tbodytd.length; j++) {
                var _tbody = tbodytd[j].children;
                var gecici2 = _tbody.length - number + 1;
                for (let t = _tbody.length - 2; t >= 0; t--) {
                    gecici2--;
                    if(gecici2 > 0) { 
                        !_tbody.item(t).classList.contains("d-none") ? _tbody.item(t).classList.add("d-none") : null;
                    } else {
                        _tbody.item(t).classList.contains("d-none") ? _tbody.item(t).classList.remove("d-none") : null;
                    }
                }
            }
            for (let m = 0; m < openModal.length; m++) {
                openModal[m].style.display = (number >= theadtd.length) ? 'none' : 'block';
            }
        },
        modalDesign: function(e){
            const modalBody = document.querySelector(".modal-body");
            modalBody.innerHTML="";
            const theadtd = document.getElementsByClassName(select.theadtd)[0].children;
            let tbodytd = e.target.parentElement.parentElement.parentElement;
            tbodytd = tbodytd.classList.contains("tbodytd") ? tbodytd : tbodytd.parentElement;
            for (let i = 0; i < theadtd.length; i++) {
                if(tbodytd.children[i].classList.contains("d-none")){
                    const el = document.createElement("p");
                    var _class = tbodytd.children.item(i).classList;
                    if(_class.item(1)) {
                        el.innerHTML = theadtd.item(i).innerHTML + ": " + "<span class='"+_class.item(0)+"'>"+tbodytd.children.item(i).innerHTML+"</span>";
                    } else {
                        el.innerHTML = theadtd.item(i).innerHTML + ": " + "<span>"+tbodytd.children.item(i).innerHTML+"</span>";
                    }
                    const att = document.createAttribute("style");
                    att.value = "text-align:center";
                    el.setAttributeNode(att);
                    modalBody.appendChild(el);
                }
            }
        },
        imageModalDesign: function(e){
            const modalBody = document.querySelector(".image-modal");
          
          modalBody.innerHTML = 
          "<div style='width:100%; display:flex; flex-direction: column'>"+
            "<img style='width:100%' src='"+e+"' />"+
          "</div>";
        },
        searchDesign: function(e) {
            const normalSearch = document.querySelector(".normalsearch");
            const dateSearch = document.querySelectorAll(".datesearch");
            const sigortaSearch = document.querySelector(".sigortasearch");
            if(e.options[e.selectedIndex].classList.contains("optdate")) {
                normalSearch.classList.add("d-none");
                sigortaSearch && sigortaSearch.classList.add("d-none");
                dateSearch[0] && dateSearch[0].classList.remove("d-none");
                dateSearch[0] && dateSearch[1].classList.remove("d-none");
            } else if(e.options[e.selectedIndex].classList.contains("optsigorta")) {
                normalSearch.classList.add("d-none");
                dateSearch[0] && dateSearch[0].classList.add("d-none");
                dateSearch[0] && dateSearch[1].classList.add("d-none");
                sigortaSearch && sigortaSearch.classList.remove("d-none");
            } else {
                normalSearch.classList.remove("d-none");
                dateSearch[0] && dateSearch[0].classList.add("d-none");
                dateSearch[0] && dateSearch[1].classList.add("d-none");
                sigortaSearch && sigortaSearch.classList.add("d-none");
            }
        },
        scrollDesign: function(e) {
            const nav = document.querySelector('.dashboard-nav-list');
            nav.style.height = (e - 92) + "px";
        },
        list2Design: function(e) {
            const normalList = document.querySelectorAll(".normallist");
            const otherList = document.querySelectorAll(".otherlist");
            if(e.options){
                if(e.options[e.selectedIndex].classList.contains("sigorta_turu")) {
                    normalList[0].classList.add("d-none");
                    normalList[1].classList.add("d-none");
                    otherList[0].classList.remove("d-none");
                    otherList[1].classList.remove("d-none");
                } else {
                    normalList[0].classList.remove("d-none");
                    normalList[1].classList.remove("d-none");
                    otherList[0] && otherList[0].classList.add("d-none");
                    otherList[1] && otherList[1].classList.add("d-none");
                }
            }
        },
        sigortaSearchDesign: function(e) {
            const normalSearch = document.querySelectorAll(".normalsearch");
            const sigortaSearch = document.querySelectorAll(".sigortaSearch");
            if(e.options){
                if(e.options[e.selectedIndex].classList.contains("optsigorta")) {
                    normalSearch[0].classList.add("d-none");
                    normalSearch[1].classList.add("d-none");
                    sigortaSearch[0].classList.remove("d-none");
                } else {
                    normalSearch[0].classList.remove("d-none");
                    normalSearch[1].classList.remove("d-none");
                    sigortaSearch[0] && sigortaSearch[0].classList.add("d-none");
                }
            }
        },
    }
}())


const App = (function(UIctrl) {

    const UIselectors = UIcontroller.getSelects();

    const LoadEventListeners = function(){

        window.addEventListener("resize", tableResize);

        window.addEventListener("load", windowLoad);

        document.querySelector(".menusvg").addEventListener("click", menuClick);

        document.querySelectorAll(".openModal").forEach(el => {

            el.addEventListener("click", openModal);

        });

        document.querySelectorAll(".openModalImage").forEach(el => {

            el.addEventListener("click", openModalImage);

        });

        document.querySelector(".searchSelect").addEventListener("change", searchSelectChange);

        document.querySelector(".listSelect").addEventListener("change", listSelectChange);

        // document.querySelector(".searchSelect").addEventListener("change", sigortaSearchChange);

    }

    const tableResize = function() {

        const table = document.querySelectorAll(UIselectors.table);

        var number = parseInt(table[0].offsetWidth / 200);

        UIctrl.listDesign(number);

    }

    const windowLoad = function() {

        var weight = document.documentElement.clientWidth;
        
        var height = document.documentElement.clientHeight;

        const search = document.querySelector(".searchSelect");

        var ek = weight <= 992 ? 20 : 258; 
        
        UIctrl.listDesign(((weight - ek) / 200));

        UIctrl.searchDesign(search);

        UIctrl.scrollDesign(height);

    }

    const menuClick = function() {

        const table = document.querySelectorAll(UIselectors.table);

        var number = parseInt(table[0].offsetWidth / 200);

        number = document.querySelector(".dashboard").classList.contains("dashboard-compact") ? number - 1 : number + 1;

        UIctrl.listDesign(number);

    }

    const openModal = function(e) {

        UIctrl.modalDesign(e);
    }

    const openModalImage = function(e) {

        UIctrl.imageModalDesign(e.target.src);

    }

    const searchSelectChange = function(e) {

        UIctrl.searchDesign(e.target);

    }

    const listSelectChange = function(e) {

        UIctrl.list2Design(e.target);

    }

    return{

        init: function(){

            console.log('starting...');

            LoadEventListeners();

        }
        
    }

})(UIcontroller)

App.init();