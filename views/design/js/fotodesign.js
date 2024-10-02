const KazaUIcontroller = (function(){
    const select = {
        table: '.table',
        theadtd: 'theadtd',
        tbodytd: 'tbodytd',
    }
    return {
        getSelects: function(){
            return select
        },
        fotoLoadDesign: function(e) {
            // console.log(e);
        }
    }
}())
var sayac = 0;
const KazaApp = (function(KUIctrl) {

    const UIselectors = KazaUIcontroller.getSelects();

    const LoadEventListeners = function(){

        document.querySelectorAll(".kazafotoupload").forEach(el => {

            el.addEventListener("change", fotoLoad);

        });

    }

    const fotoLoad = function(e) {

        const inputfilediv = document.querySelectorAll(".inputfileadd");

        const preview = document.querySelector(".fotopreview");

        const deleteSvg = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" id="iconDanger" class="fotodeleteicon">'+
        '<path d="M0 0h24v24H0V0z" fill="none"/><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-3.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z"/></svg>';

        console.log(inputfilediv[inputfilediv.length - 1]);

        [...this.files].map(file => {
            console.log(file);
            const reader = new FileReader();
            reader.addEventListener('load', function(){
                sayac++;
                const image = new Image();
                const div = document.createElement("div");
                div.classList.add('maindiv');
                div.classList.add('sira-'+sayac);
                const islemdiv = document.createElement("div");
                div.style="position: relative;";
                islemdiv.style = "position: absolute; bottom:6px; left: 6px; display:none;"; 
                islemdiv.innerHTML = deleteSvg;
                // islemdiv.innerHTML += deleteSvg;
                islemdiv.classList.add("islemdiv");
                image.height = 100;
                image.title = file.name;
                image.src = this.result;
                image.classList.add('img-responsive');
                image.classList.add('kaza-img');
                image.classList.add('rounded');
                image.classList.add('border');
                // image.style="margin: 20px";
                div.appendChild(image);
                div.appendChild(islemdiv);
                preview.appendChild(div);
                e.target.style = "display: none";
                inputfilediv[inputfilediv.length - 1].innerHTML += 
                '<input type="file" accept="image/*" name="kazafoto[]" class="form-control kazafotoupload">'+
                '<div class="inputfileadd sira-'+(sayac+2)+'"></div>';
                document.querySelectorAll(".kazafotoupload").forEach(el => {
                    el.addEventListener("change", fotoLoad);
                });

                document.querySelectorAll(".fotodeleteicon").forEach(el => {
                    el.addEventListener("click", fotodeleteicon);
                });

            });
            reader.readAsDataURL(file);
        });
    }

    const fotodeleteicon = function (e) {
        const gecici = e.target.parentElement.parentElement;
        const element = gecici.classList.contains("maindiv") ? gecici : gecici.parentElement;
        console.log(element);
        document.querySelectorAll(".inputfileadd").forEach(el => {
            if(el.classList.contains(element.classList[1])) {
               el.firstChild.tagName=="INPUT" ? el.firstChild.remove() : el.firstChild.nextSibling.remove();
            }
        })
        element.remove();
    }

    return{

        init: function(){

            console.log('starting...');

            LoadEventListeners();

        }
        
    }

})(KazaUIcontroller)

KazaApp.init();