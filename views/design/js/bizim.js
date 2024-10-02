$(document).ready(function(e) {
    jQuery.fn.extend({
        printElem: function() {
            var cloned = this.clone();
        var printSection = $('#printSection');
        if (printSection.length == 0) {
            printSection = $('<div id="printSection"></div>')
            $('body').append(printSection);
        }
        printSection.append(cloned);
        var toggleBody = $('body *:visible');
        toggleBody.hide();
        $('#printSection, #printSection *').show();
        window.print();
        printSection.remove();
        toggleBody.show();
        }
    });

    // $('.popup-gallery').magnificPopup({
    //     delegate: 'a',
    //     type: 'image',
    //     tLoading: 'Loading image #%curr%...',
    //     mainClass: 'mfp-img-mobile',
    //     gallery: {
    //         enabled: true,
    //         navigateByImgClick: true,
    //         preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    //     },
    //     image: {
    //         tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
    //         titleSrc: function(item) {
    //             return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
    //         }
    //     }
    // });

    // $('.parent-container').magnificPopup({
    //     delegate: 'a', // child items selector, by clicking on it popup will open
    //     type: 'image',
    //     gallery: {
    //         // options for gallery
    //         enabled: true
    //       },
    //     // other options
    // });

    $('.gallery').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
              enabled:true
            },
            preload: [1,3],
            removalDelay: 300,
            mainClass: 'mfp-fade'
        });
    });

});

function BilgiPenceresi(linkAdres,sonucbaslik,sonucmetin,sonuctur) {
    swal(sonucbaslik, sonucmetin, sonuctur, {
        buttons: {
            catch: {
                text: "KAPAT",
                value: "tamam",
            }
        },
    })
    .then((value) => {
        if (value=="tamam") {
            window.location.href = linkAdres;
        }		
    });
}

function silmedenSor (gidilecekLink) {
    swal({
        title: "Silmek istediğine emin misin?",
        text: "Silinen kayıt geri alınamaz.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            window.location.href =  gidilecekLink; 
        } else {
            swal({title:"Silme işleminden vazgeçtiniz", icon: "warning",});
        }
    });
}

function arrowRotateControl(event) {
    const svg = event.children[2];
    const svgs = document.getElementsByClassName("arrowRotate");
    if(svg.classList.contains("arrowRotate")==false){
        svg.classList.add("arrowRotate");
    }else{
        svg.classList.remove("arrowRotate");
    }
    for (let i = 0; i < svgs.length; i++) {
        const element = svgs[i];
        console.log(element);
        element.classList.remove("arrowRotate");
        svg.classList.add("arrowRotate");
    }
}

