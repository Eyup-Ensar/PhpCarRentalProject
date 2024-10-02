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
        scrollDesign: function(e) {
            const nav = document.querySelector('.dashboard-nav-list');
            nav.style.height = (e - 92) + "px";
        }
    }
}())

const App = (function(UIctrl) {

    const UIselectors = UIcontroller.getSelects();

    const LoadEventListeners = function(){

        window.addEventListener("load", windowLoad);

    }

    const windowLoad = function() {
        
        var height = document.documentElement.clientHeight;

        UIctrl.scrollDesign(height);

    }

    return{

        init: function(){

            console.log('starting...');

            LoadEventListeners();

        }
        
    }

})(UIcontroller)

App.init();