const UIcontroller = (function(){
    const select = {
    }
    return {
        getSelects: function (){
            return select
        },
        scrollDesign: function (e) {
            const nav = document.querySelector('.dashboard-nav-list');
            nav.style.height = (e - 92) + "px";
        }
    }
}())


const App = (function(UIctrl) {

    const UIselectors = UIcontroller.getSelects();

    var listValues = [];

    const Pagination = {
        toplamVeri: 0,
        adet : 6, 
        mevcutSayfa: 1,
        get sayfaAdet () { 
           return Math.ceil(this.toplamVeri / this.adet)
        },
    }

    const LoadEventListeners = function() {

        window.addEventListener("load", windowLoad);

        document.querySelector("#plakaList").addEventListener("change", changePlakaList);

        document.querySelector("#dateRangeList").addEventListener("change", changeDateRangeList);

        document.querySelector("#dateCriterionList").addEventListener("change", changeDateCriterionList);

        document.querySelectorAll(".page-active").forEach(el => {

            el.addEventListener("click", changeMevcutSayfa);

        });

    }

    const windowLoad = function() {

        var height = document.documentElement.clientHeight;

        UIctrl.scrollDesign(height);

    }

    const GraphicSettings = function() {

        //GRAFİK 1

        const ctx = document.getElementById('myChart');

        const values = document.getElementById('values');

        let val = values.value;

        let datas = [];

        let newDatas = [];

        datas = val.split("_");

        datas.forEach(el => {
            newDatas.push(parseInt(el));
        })

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Benzin',
                    'Dizel',
                    'Lpg',
                    'Elektrik',
                    'Hibrit'
                ],
                datasets: [{
                    label: ' Araç sayısı',
                    data: newDatas,
                    backgroundColor: [
                        '#dc3545',
                        '#0d6efd',
                        '#0dcaf0',
                        '#198754',
                        '#ffc107'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        //GRAFİK 4

        const ctx3 = document.getElementById('myChart3');

        const kiraValues = document.getElementById('kiraValues');

        let kiraVal = kiraValues.value;

        let kiraDatas = [];

        let newKiraDatas = [];

        kiraDatas = kiraVal.split("_");

        kiraDatas.forEach(el => {
            newKiraDatas.push(parseInt(el));
        })

        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: [
                    'Boşta',
                    'Kirada',
                ],
                datasets: [{
                    label: ' Araç sayısı',
                    data: newKiraDatas,
                    backgroundColor: [
                        '#0d6efd',
                        '#198754',
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // GRAFİK 2

        const textValues = document.getElementById('textValues').value;

        const ctx1 = document.getElementById('myChart1');

        const araclar = document.getElementById('plakaGraphic');

        const yillar = document.getElementById('yilGraphic');

        const toplamKira = document.getElementById('toplamKira');

        let sorgu = true;

        let toplam = 0;

        let sonuc = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        let textArray = ucretArray = ucretArrayInt = tarihArray = aracArray = [];

        textArray = textValues.split("||");

        ucretArray = textArray[0].split("_");

        tarihArray = textArray[1].split("_");

        aracArray = textArray[2].split("_");

        ucretArray.forEach(element => {
            ucretArrayInt.push(parseInt(element));
        });

        tarihArray.forEach((element, key) => {
            sorgu = araclar.value=="tumu" ? element.split("-")[0]==yillar.value : element.split("-")[0]==yillar.value && aracArray[key]==genel;
            if(sorgu) {
                toplam += ucretArrayInt[key];
                switch (element.split("-")[1]) {
                    case '01': sonuc[0] += ucretArrayInt[key]; break;
                    case '02': sonuc[1] += ucretArrayInt[key]; break;
                    case '03': sonuc[2] += ucretArrayInt[key]; break;
                    case '04': sonuc[3] += ucretArrayInt[key]; break;
                    case '05': sonuc[4] += ucretArrayInt[key]; break;
                    case '06': sonuc[5] += ucretArrayInt[key]; break;
                    case '07': sonuc[6] += ucretArrayInt[key]; break;
                    case '08': sonuc[7] += ucretArrayInt[key]; break;
                    case '09': sonuc[8] += ucretArrayInt[key]; break;
                    case '10': sonuc[9] += ucretArrayInt[key]; break;
                    case '11': sonuc[10] += ucretArrayInt[key]; break;
                    case '12': sonuc[11] += ucretArrayInt[key]; break;
                }
            }
        });

        toplamKira.innerHTML = toplam + " TL";

        let myChart = new Chart(ctx1, {
            type: 'bar',
            data : {
                labels: ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
                datasets: [{
                  label: ' Kira geliri',
                  data: sonuc,
                  backgroundColor: [
                    'rgba(82, 0, 71, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(179, 197, 242, 0.2)',
                    'rgba(175, 39, 0, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgb(66, 109, 71, 0.2)',
                    'rgba(159, 116, 115, 0.2)',
                  ],
                  borderColor: [
                    'rgb(82, 0, 71)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(179, 197, 242)',
                    'rgb(175, 39, 0)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    'rgb(66, 109, 71)',
                    'rgb(159, 116, 115)',
                  ],
                  borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        araclar.addEventListener("change", (e) => {
            sonuc = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            toplam = 0;
            tarihArray.forEach((element, key) => {
                sorgu = e.target.value=="tumu" ? element.split("-")[0]==yillar.value : element.split("-")[0]==yillar.value && aracArray[key]==e.target.value;
                if(sorgu) {
                    toplam += ucretArrayInt[key];
                    switch (element.split("-")[1]) {
                        case '01': sonuc[0] += ucretArrayInt[key]; break;
                        case '02': sonuc[1] += ucretArrayInt[key]; break;
                        case '03': sonuc[2] += ucretArrayInt[key]; break;
                        case '04': sonuc[3] += ucretArrayInt[key]; break;
                        case '05': sonuc[4] += ucretArrayInt[key]; break;
                        case '06': sonuc[5] += ucretArrayInt[key]; break;
                        case '07': sonuc[6] += ucretArrayInt[key]; break;
                        case '08': sonuc[7] += ucretArrayInt[key]; break;
                        case '09': sonuc[8] += ucretArrayInt[key]; break;
                        case '10': sonuc[9] += ucretArrayInt[key]; break;
                        case '11': sonuc[10] += ucretArrayInt[key]; break;
                        case '12': sonuc[11] += ucretArrayInt[key]; break;
                    }
                }
            });

            toplamKira.innerHTML = toplam + " TL";

            myChart.destroy();

            myChart = new Chart(ctx1, {
                type: 'bar',
                data : {
                    labels: ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
                    datasets: [{
                    label: ' Kira geliri',
                    data: sonuc,
                    backgroundColor: [
                        'rgba(82, 0, 71, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(179, 197, 242, 0.2)',
                        'rgba(175, 39, 0, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgb(66, 109, 71, 0.2)',
                        'rgba(159, 116, 115, 0.2)',
                    ],
                    borderColor: [
                        'rgb(82, 0, 71)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(179, 197, 242)',
                        'rgb(175, 39, 0)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                        'rgb(66, 109, 71)',
                        'rgb(159, 116, 115)',
                    ],
                    borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })

        yillar.addEventListener("change", (e) => {
            sonuc = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            toplam = 0;
            tarihArray.forEach((element, key) => {
                sorgu = araclar.value=="tumu" ? element.split("-")[0]==e.target.value : element.split("-")[0]==e.target.value && aracArray[key]==araclar.value;
                if(sorgu) {
                    toplam += ucretArrayInt[key];
                    switch (element.split("-")[1]) {
                        case '01': sonuc[0] += ucretArrayInt[key]; break;
                        case '02': sonuc[1] += ucretArrayInt[key]; break;
                        case '03': sonuc[2] += ucretArrayInt[key]; break;
                        case '04': sonuc[3] += ucretArrayInt[key]; break;
                        case '05': sonuc[4] += ucretArrayInt[key]; break;
                        case '06': sonuc[5] += ucretArrayInt[key]; break;
                        case '07': sonuc[6] += ucretArrayInt[key]; break;
                        case '08': sonuc[7] += ucretArrayInt[key]; break;
                        case '09': sonuc[8] += ucretArrayInt[key]; break;
                        case '10': sonuc[9] += ucretArrayInt[key]; break;
                        case '11': sonuc[10] += ucretArrayInt[key]; break;
                        case '12': sonuc[11] += ucretArrayInt[key]; break;
                    }
                }
            });

            toplamKira.innerHTML = toplam + " TL";

            myChart.destroy();

            myChart = new Chart(ctx1, {
                type: 'bar',
                data : {
                    labels: ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
                    datasets: [{
                    label: ' Kira geliri',
                    data: sonuc,
                    backgroundColor: [
                        'rgba(82, 0, 71, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(179, 197, 242, 0.2)',
                        'rgba(175, 39, 0, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgb(66, 109, 71, 0.2)',
                        'rgba(159, 116, 115, 0.2)',
                    ],
                    borderColor: [
                        'rgb(82, 0, 71)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(179, 197, 242)',
                        'rgb(175, 39, 0)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                        'rgb(66, 109, 71)',
                        'rgb(159, 116, 115)',
                    ],
                    borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        
        // GRAFİK 3

        const ctx2 = document.getElementById('myChart2');

        const araclarkm = document.getElementById('plakaGraphicKm');

        const yillarkm = document.getElementById('yilGraphicKm');

        const toplamKM = document.getElementById('toplamKM');

        let sorgukm = true;

        let toplamkm = 0;

        let sonuckm = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        let kmArray = kmArrayInt = [];

        kmArray = textArray[3].split("_");

        kmArray.forEach(element => {
            kmArrayInt.push(parseInt(element));
        });

        tarihArray.forEach((element, key) => {
            sorgukm = araclar.value=="tumu" ? element.split("-")[0]==yillar.value : element.split("-")[0]==yillar.value && aracArray[key]==genel;
            if(sorgukm) {
                toplamkm += kmArrayInt[key];
                switch (element.split("-")[1]) {
                    case '01': sonuckm[0] += kmArrayInt[key]; break;
                    case '02': sonuckm[1] += kmArrayInt[key]; break;
                    case '03': sonuckm[2] += kmArrayInt[key]; break;
                    case '04': sonuckm[3] += kmArrayInt[key]; break;
                    case '05': sonuckm[4] += kmArrayInt[key]; break;
                    case '06': sonuckm[5] += kmArrayInt[key]; break;
                    case '07': sonuckm[6] += kmArrayInt[key]; break;
                    case '08': sonuckm[7] += kmArrayInt[key]; break;
                    case '09': sonuckm[8] += kmArrayInt[key]; break;
                    case '10': sonuckm[9] += kmArrayInt[key]; break;
                    case '11': sonuckm[10] += kmArrayInt[key]; break;
                    case '12': sonuckm[11] += kmArrayInt[key]; break;
                }
            }
        });

        toplamKM.innerHTML = toplamkm + " KM";

        let myChart2 = new Chart(ctx2, {
            type: 'bar',
            data : {
                labels: ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
                datasets: [{
                  label: ' Katedilen Kilometre',
                  data: sonuckm,
                  backgroundColor: [
                    'rgba(82, 0, 71, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(179, 197, 242, 0.2)',
                    'rgba(175, 39, 0, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgb(66, 109, 71, 0.2)',
                    'rgba(159, 116, 115, 0.2)',
                  ],
                  borderColor: [
                    'rgb(82, 0, 71)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(179, 197, 242)',
                    'rgb(175, 39, 0)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    'rgb(66, 109, 71)',
                    'rgb(159, 116, 115)',
                  ],
                  borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        araclarkm.addEventListener("change", (e) => {
            sonuckm = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            toplamkm = 0;
            tarihArray.forEach((element, key) => {
                sorgukm = e.target.value=="tumu" ? element.split("-")[0]==yillarkm.value : element.split("-")[0]==yillarkm.value && aracArray[key]==e.target.value;
                if(sorgukm) {
                    toplamkm += kmArrayInt[key];
                    switch (element.split("-")[1]) {
                        case '01': sonuckm[0] += kmArrayInt[key]; break;
                        case '02': sonuckm[1] += kmArrayInt[key]; break;
                        case '03': sonuckm[2] += kmArrayInt[key]; break;
                        case '04': sonuckm[3] += kmArrayInt[key]; break;
                        case '05': sonuckm[4] += kmArrayInt[key]; break;
                        case '06': sonuckm[5] += kmArrayInt[key]; break;
                        case '07': sonuckm[6] += kmArrayInt[key]; break;
                        case '08': sonuckm[7] += kmArrayInt[key]; break;
                        case '09': sonuckm[8] += kmArrayInt[key]; break;
                        case '10': sonuckm[9] += kmArrayInt[key]; break;
                        case '11': sonuckm[10] += kmArrayInt[key]; break;
                        case '12': sonuckm[11] += kmArrayInt[key]; break;
                    }
                }
            });

            console.log(sonuckm);

            toplamKM.innerHTML = toplamkm + " KM";

            myChart2.destroy();

            myChart2 = new Chart(ctx2, {
                type: 'bar',
                data : {
                    labels: ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
                    datasets: [{
                    label: ' Katedilen Kilometre',
                    data: sonuckm,
                    backgroundColor: [
                        'rgba(82, 0, 71, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(179, 197, 242, 0.2)',
                        'rgba(175, 39, 0, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgb(66, 109, 71, 0.2)',
                        'rgba(159, 116, 115, 0.2)',
                    ],
                    borderColor: [
                        'rgb(82, 0, 71)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(179, 197, 242)',
                        'rgb(175, 39, 0)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                        'rgb(66, 109, 71)',
                        'rgb(159, 116, 115)',
                    ],
                    borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

        yillarkm.addEventListener("change", (e) => {
            sonuckm = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            toplamkm = 0;
            tarihArray.forEach((element, key) => {
                sorgukm = araclarkm.value=="tumu" ? element.split("-")[0]==e.target.value : element.split("-")[0]==e.target.value && aracArray[key]==araclarkm.value;
                if(sorgukm) {
                    toplamkm += kmArrayInt[key];
                    switch (element.split("-")[1]) {
                        case '01': sonuckm[0] += kmArrayInt[key]; break;
                        case '02': sonuckm[1] += kmArrayInt[key]; break;
                        case '03': sonuckm[2] += kmArrayInt[key]; break;
                        case '04': sonuckm[3] += kmArrayInt[key]; break;
                        case '05': sonuckm[4] += kmArrayInt[key]; break;
                        case '06': sonuckm[5] += kmArrayInt[key]; break;
                        case '07': sonuckm[6] += kmArrayInt[key]; break;
                        case '08': sonuckm[7] += kmArrayInt[key]; break;
                        case '09': sonuckm[8] += kmArrayInt[key]; break;
                        case '10': sonuckm[9] += kmArrayInt[key]; break;
                        case '11': sonuckm[10] += kmArrayInt[key]; break;
                        case '12': sonuckm[11] += kmArrayInt[key]; break;
                    }
                }
            });

            toplamKM.innerHTML = toplamkm + " KM";

            myChart2.destroy();

            myChart2 = new Chart(ctx2, {
                type: 'bar',
                data : {
                    labels: ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
                    datasets: [{
                    label: ' Katedilen Kilometre',
                    data: sonuckm,
                    backgroundColor: [
                        'rgba(82, 0, 71, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(179, 197, 242, 0.2)',
                        'rgba(175, 39, 0, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgb(66, 109, 71, 0.2)',
                        'rgba(159, 116, 115, 0.2)',
                    ],
                    borderColor: [
                        'rgb(82, 0, 71)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(179, 197, 242)',
                        'rgb(175, 39, 0)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                        'rgb(66, 109, 71)',
                        'rgb(159, 116, 115)',
                    ],
                    borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

    }

    const LoadDateNotifications = function () {

        Pagination.mevcutSayfa = 1;

        const list_main = document.querySelector(".list-main");

        var geneltext = document.querySelector("#datestext").value;

        var cezageneltext = document.querySelector("#cezadatestext").value;

        var kirageneltext = document.querySelector("#kiradatestext").value;

        plakalar = geneltext.split("||")[0].split("_");

        trafik_bitis = geneltext.split("||")[1].split("_");

        kasko_bitis = geneltext.split("||")[2].split("_");

        imm_bitis = geneltext.split("||")[3].split("_");

        cezaplakalar = cezageneltext.split("||")[0].split("_");
        
        ceza_son_odeme = cezageneltext.split("||")[1].split("_");

        kiraplakalar = kirageneltext.split("||")[0].split("_");
        
        kirasozbit = kirageneltext.split("||")[1].split("_");

        for (let i = 0; i < plakalar.length; i++) {
            const plaka = plakalar[i];
            if(trafik_bitis[i] < 0) {
                trafik_bitis[i] = trafik_bitis[i] * -1;
                listValues.push("<li class='list-group-item list-group-item-action'>"+plaka+" plakalı aracın sigorta bitiş tarihi "+trafik_bitis[i]+" gün geçmiştir!</li>");
            } 
            if(kasko_bitis[i] < 0) {
                kasko_bitis[i] = kasko_bitis[i] * -1;
                listValues.push("<li class='list-group-item list-group-item-action'>"+plaka+" plakalı aracın kasko bitiş tarihi "+kasko_bitis[i]+" gün geçmiştir!</li>");
            } 
        }

        for (let j = 0; j < cezaplakalar.length; j++) {
            if(ceza_son_odeme[j] < 0) {
                ceza_son_odeme[j] = ceza_son_odeme[j] * -1;
                listValues.push("<li class='list-group-item list-group-item-action'>"+cezaplakalar[j]+" plakalı aracın trafik ceza son ödeme tarihi "+ceza_son_odeme[j]+" gün geçmiştir!</li>");
            } 
        }

        for (let t = 0; t < kiraplakalar.length; t++) {
            if(kirasozbit[t] < 0) {
                kirasozbit[t] = kirasozbit[t] * -1;
                listValues.push("<li class='list-group-item list-group-item-action'>"+kiraplakalar[t]+" plakalı aracın kira sözleşme bitiş tarihine tarihine "+kirasozbit[t]+" gün kalmıştır.</li>");
            } 
        }
        
        const pagination = document.querySelector(".pagination");

        Pagination.toplamVeri = listValues.length;

        if(listValues.length===0) {
           
            list_main.innerHTML = '<div class="alert alert-primary text-center" style="background-color: rgb(230, 242, 255) !important; border: none !important" role="alert">Bu kriterlere Uygun Herhangi Bir Veri Bulunamadı.</div>';
        
            pagination.innerHTML = "";
        
        } else {

            for (let i = (Pagination.adet * Pagination.mevcutSayfa) - Pagination.adet; i < (Pagination.adet * Pagination.mevcutSayfa); i++) {
                list_main.innerHTML += listValues.length > i ? listValues[i] : ""; 
            }

            pagination.innerHTML = '<li class="page-item"><a class="page-link page-control" style="cursor: pointer" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';

            for (let j = 0; j < Pagination.sayfaAdet; j++) {
                pagination.innerHTML += Pagination.mevcutSayfa===j+1 ? 
                '<li class="page-item"><a class="page-link page-active active" style="cursor: pointer">'+(j+1)+'</a></li>' :
                '<li class="page-item"><a class="page-link page-active" style="cursor: pointer">'+(j+1)+'</a></li>';
            }
    
            pagination.innerHTML += '<li class="page-item"><a class="page-link page-control" style="cursor: pointer" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        
        }

        document.querySelectorAll(".page-active").forEach(el => {

            el.addEventListener("click", changeMevcutSayfa);

        });

        document.querySelectorAll(".page-control").forEach(el => {

            el.addEventListener("click", prevNextMevcutSayfa);

        });

        let hiddenValue = "";

        listValues.forEach(element => {
            hiddenValue += element + "||";
        });

        document.querySelector("#listmailgonderhidden").value = hiddenValue;

    }

    const changePlakaList = function (e) {

        changeListDeign();

    }

    const changeDateRangeList = function (e) {

        changeListDeign();

    }

    const changeDateCriterionList = function (e) {

        changeListDeign();

    }

    const changeListDeign = function () {

        listValues = [];

        Pagination.mevcutSayfa = 1;

        const list_main = document.querySelector(".list-main");

        const dateRange = document.querySelector("#dateRangeList");

        const plaka = document.querySelector("#plakaList");

        const dateCriterion = document.querySelector("#dateCriterionList");
        
        let dateCriterionVal =  dateCriterion.options[dateCriterion.selectedIndex].value;

        let dateRangeVal =  parseInt(dateRange.options[dateRange.selectedIndex].value);

        let plakaVal =  plaka.options[plaka.selectedIndex].value;

        var geneltext = document.querySelector("#datestext").value;
    
        var cezageneltext = document.querySelector("#cezadatestext").value;

        var kirageneltext = document.querySelector("#kiradatestext").value;

        plakalar = geneltext.split("||")[0].split("_");

        trafik_bitis = geneltext.split("||")[1].split("_");

        kasko_bitis = geneltext.split("||")[2].split("_");

        imm_bitis = geneltext.split("||")[3].split("_");

        cezaplakalar = cezageneltext.split("||")[0].split("_");
        
        ceza_son_odeme = cezageneltext.split("||")[1].split("_");

        kiraplakalar = kirageneltext.split("||")[0].split("_");
        
        kirasozbit = kirageneltext.split("||")[1].split("_");

        sorgu = true;

        sorgu2 = true;

        console.log(geneltext);

        list_main.innerHTML = "";

        for (let i = 0; i < plakalar.length; i++) {
            if(plakaVal==="tumu") {
                sorgu = true;
            } else {
                sorgu = plakaVal === plakalar[i];
            }
            if(dateCriterionVal==="tumu") {
                sorgu2 = true;
            } else {
                sorgu2 = plakaVal === plakalar[i];
            }
            if(sorgu) {
                trafik_bitis[i] = parseInt(trafik_bitis[i]);
                kasko_bitis[i] = parseInt(kasko_bitis[i]);
                if(dateRangeVal == 0) {
                    if(dateCriterionVal==="tumu") {
                        if(trafik_bitis[i] < dateRangeVal) {
                            trafik_bitis[i] = trafik_bitis[i] * -1;
                            listValues.push("<li class='list-group-item list-group-item-action'>"+plakalar[i]+" plakalı aracın sigorta bitiş tarihi "+trafik_bitis[i]+" gün geçmiştir!</li>") ;
                        }
                        if(kasko_bitis[i] < dateRangeVal) {
                            kasko_bitis[i] = kasko_bitis[i] * -1;
                            listValues.push("<li class='list-group-item list-group-item-action'>"+plakalar[i]+" plakalı aracın kasko bitiş tarihi "+kasko_bitis[i]+" gün geçmiştir!</li>") ;
                        }
                    } else {
                        if(dateCriterionVal==="trafik_bitis" && trafik_bitis[i] < dateRangeVal) {
                            trafik_bitis[i] = trafik_bitis[i] * -1;
                            listValues.push("<li class='list-group-item list-group-item-action'>"+plakalar[i]+" plakalı aracın sigorta bitiş tarihi "+trafik_bitis[i]+" gün geçmiştir!</li>") ;
                        } else if(dateCriterionVal==="kasko_bitis" && kasko_bitis[i] < dateRangeVal) {
                            kasko_bitis[i] = kasko_bitis[i] * -1;
                            listValues.push("<li class='list-group-item list-group-item-action'>"+plakalar[i]+" plakalı aracın kasko bitiş tarihi "+kasko_bitis[i]+" gün geçmiştir!</li>") ;
                        }
                    }
                } else {
                    if(dateCriterionVal==="tumu") {
                        if(trafik_bitis[i] > 0 && trafik_bitis[i] <= dateRangeVal) {
                            listValues.push("<li class='list-group-item list-group-item-action'>"+plakalar[i]+" plakalı aracın sigorta bitiş tarihine "+trafik_bitis[i]+" gün kalmıştır.</li>") ;
                        }
                        if(kasko_bitis[i] > 0 && kasko_bitis[i] <= dateRangeVal) {
                            listValues.push("<li class='list-group-item list-group-item-action'>"+plakalar[i]+" plakalı aracın kasko bitiş tarihine "+kasko_bitis[i]+" gün kalmıştır.</li>") ;
                        }
                    } else {
                        if(dateCriterionVal==="trafik_bitis" && trafik_bitis[i] > 0 && trafik_bitis[i] <= dateRangeVal) {
                            listValues.push("<li class='list-group-item list-group-item-action'>"+plakalar[i]+" plakalı aracın sigorta bitiş tarihine "+trafik_bitis[i]+" gün kalmıştır.</li>") ;
                        } else if(dateCriterionVal==="kasko_bitis" && kasko_bitis[i] > 0 && kasko_bitis[i] <= dateRangeVal) {
                            listValues.push("<li class='list-group-item list-group-item-action'>"+plakalar[i]+" plakalı aracın kasko bitiş tarihine "+kasko_bitis[i]+" gün kalmıştır.</li>") ;
                        }
                    }
                }
            } 
        }

        for (let j = 0; j < cezaplakalar.length; j++) {
            if(plakaVal==="tumu") {
                sorgu = true;
            } else {
                sorgu = plakaVal === cezaplakalar[j];
            }
            if(sorgu) {
                ceza_son_odeme[j] = parseInt(ceza_son_odeme[j]);
                if(dateRangeVal == 0) {
                    if(dateCriterionVal==="ceza_son_odeme" || dateCriterionVal==="tumu") {
                        if(ceza_son_odeme[j] < dateRangeVal) {
                            ceza_son_odeme[j] = ceza_son_odeme[j] * -1;
                            listValues.push("<li class='list-group-item list-group-item-action'>"+cezaplakalar[j]+" plakalı aracın trafik cezası son ödeme tarihi "+ceza_son_odeme[j]+" gün geçmiştir!</li>");
                        }
                    }
                } else {
                    if(dateCriterionVal==="ceza_son_odeme" || dateCriterionVal==="tumu") {
                        if(ceza_son_odeme[j] > 0 && ceza_son_odeme[j] <= dateRangeVal) {
                            listValues.push("<li class='list-group-item list-group-item-action'>"+cezaplakalar[j]+" plakalı aracın trafik cezası son ödeme tarihine "+ceza_son_odeme[j]+" gün kalmıştır.</li>");
                        }
                    }
                }
            } 
        }

        for (let t = 0; t < kiraplakalar.length; t++) {
            if(plakaVal==="tumu") {
                sorgu = true;
            } else {
                sorgu = plakaVal === kiraplakalar[t];
            }
            if(sorgu) {
                kirasozbit[t] = parseInt(kirasozbit[t]);
                if(dateRangeVal == 0) {
                    if(dateCriterionVal==="kira_soz_bitis" || dateCriterionVal==="tumu") {
                        if(kirasozbit[t] < dateRangeVal) {
                            kirasozbit[t] = kirasozbit[t] * -1;
                            listValues.push("<li class='list-group-item list-group-item-action'>"+kiraplakalar[t]+" plakalı aracın kira sözleşme bitiş tarihi tarihi "+kirasozbit[t]+" gün geçmiştir!</li>");
                        }
                    }
                } else {
                    if(dateCriterionVal==="kira_soz_bitis" || dateCriterionVal==="tumu") {
                        if(kirasozbit[t] > 0 && kirasozbit[t] <= dateRangeVal) {
                            listValues.push("<li class='list-group-item list-group-item-action'>"+kiraplakalar[t]+" plakalı aracın kira sözleşme bitiş tarihine tarihine "+kirasozbit[t]+" gün kalmıştır.</li>");
                        }
                    }
                }
            } 
        }

        const pagination = document.querySelector(".pagination");

        Pagination.toplamVeri = listValues.length;
        
        for (let j = 0; j < Pagination.sayfaAdet; j++) {

            pagination.innerHTML += Pagination.mevcutSayfa===j+1 ? 
            '<li class="page-item"><a class="page-link page-active active">'+(j+1)+'</a></li>' :
            '<li class="page-item"><a class="page-link page-active">'+(j+1)+'</a></li>';

        }

        if(listValues.length===0) {
           
            list_main.innerHTML = '<div class="alert alert-primary text-center" style="background-color: rgb(230, 242, 255) !important; border: none !important" role="alert">Bu kriterlere Uygun Herhangi Bir Veri Bulunamadı.</div>';
        
            pagination.innerHTML = "";
        
        } else {

            for (let i = (Pagination.adet * Pagination.mevcutSayfa) - Pagination.adet; i < (Pagination.adet * Pagination.mevcutSayfa); i++) {
                list_main.innerHTML += listValues.length > i ? listValues[i] : ""; 
            }

            pagination.innerHTML = '<li class="page-item"><a class="page-link page-control" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';

            for (let j = 0; j < Pagination.sayfaAdet; j++) {
                pagination.innerHTML += Pagination.mevcutSayfa===j+1 ? 
                '<li class="page-item"><a class="page-link page-active active">'+(j+1)+'</a></li>' :
                '<li class="page-item"><a class="page-link page-active">'+(j+1)+'</a></li>';
            }
    
            pagination.innerHTML += '<li class="page-item"><a class="page-link page-control" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        
        }

        document.querySelectorAll(".page-active").forEach(el => {

            el.addEventListener("click", changeMevcutSayfa);

        });

        document.querySelectorAll(".page-control").forEach(el => {

            el.addEventListener("click", prevNextMevcutSayfa);

        });

        let hiddenValue = "";

        listValues.forEach(element => {
            hiddenValue += element + "||";
        });

        document.querySelector("#listmailgonderhidden").value = hiddenValue;
    }

    const changeMevcutSayfa = function (e) {

        const list_main = document.querySelector(".list-main");

        list_main.innerHTML = "";

        const pagelinks = document.querySelectorAll(".page-active");

        pagelinks.forEach(el => {
            el.classList.contains("active") && el.classList.remove("active");
        });

        let element = e.target.classList.contains("page-active") ? e.target : e.target.parentElement;

        element.classList.contains("page-active") && element.classList.add("active");

        console.log(element.innerHTML);

        Pagination.mevcutSayfa = parseInt(element.innerHTML);

        console.log(listValues);

        for (let i = (Pagination.adet * Pagination.mevcutSayfa) - Pagination.adet; i < (Pagination.adet * Pagination.mevcutSayfa); i++) {
            list_main.innerHTML += listValues.length > i ? listValues[i] : ""; 
        }

    }

    const prevNextMevcutSayfa = function (e) {

        let element = e.target.classList.contains("page-control") ? e.target : e.target.parentElement;

        const list_main = document.querySelector(".list-main");

        const pagelinks = document.querySelectorAll(".page-active");

        list_main.innerHTML = "";

        console.log(element.ariaLabel);

        if(element.ariaLabel==="Next") {
            Pagination.mevcutSayfa = Pagination.mevcutSayfa < Pagination.sayfaAdet ? Pagination.mevcutSayfa + 1 : Pagination.mevcutSayfa;
        } else {
            Pagination.mevcutSayfa = Pagination.mevcutSayfa > 1 ? Pagination.mevcutSayfa - 1 : Pagination.mevcutSayfa;
        }

        pagelinks.forEach(el => {
            if(parseInt(el.innerHTML)===Pagination.mevcutSayfa) {
                el.classList.add("active");
            } else {
                 el.classList.remove("active");
            }
        });

        console.log(Pagination.mevcutSayfa);

        // Pagination.mevcutSayfa = parseInt(element.innerHTML);

        // console.log(listValues);

        for (let i = (Pagination.adet * Pagination.mevcutSayfa) - Pagination.adet; i < (Pagination.adet * Pagination.mevcutSayfa); i++) {
            list_main.innerHTML += listValues.length > i ? listValues[i] : ""; 
        }

    }

    return{

        init: function(){

            console.log('starting...');

            LoadEventListeners();

            GraphicSettings();

            LoadDateNotifications();

        }
        
    }

})(UIcontroller)

App.init();