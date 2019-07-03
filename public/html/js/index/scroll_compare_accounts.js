'use strict'

//object for handling link click event within uploadTextFrame
//scrolls down smoothly to compare accounts table
let compareTableScroller = {
    init : function()
    {
        $("#uploadTextFrame a").click( (e) => {
            e.preventDefault();
            this.scrollToTable();
        });
    },

    scrollToTable : function()
    {
        let yOffset = $("#compareAccountsSection")[0].offsetTop;
        window.scrollTo({
            top: yOffset,
            behavior: 'smooth'
        });
    }
}

$(document).ready( () => {
    compareTableScroller.init();
});