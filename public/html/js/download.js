'use strict'

let download = {
    //inits event handler preventing default download on link action
    //so that before it will be started downlaod constraints are checked
    //whether user don't used all available downloads during given period of
    //time(60 minutes default)
    initStartDownloadClick : function()
    {
        $(".downloadBtn > a").click( (e) => {
            e.preventDefault();
            this.checkMaxNumDownloadsConstraint();
        });
    },

    //displays warning alert with hh:mm:ss time which user have to wait before
    //starting next download
    openUsedAllNumOfDownloadsAlert : function(numSecondsWait)
    {
        //get HH:MM:SS format
        let wait = new Date(numSecondsWait * 1000).toISOString().substr(11, 8);
        $("#usedAllDownloadsAlert").css("visibility", "visible")
            .children("span").html(wait);
    },

    //sends request to server with question if limit of number of downloads
    //wasn't reached
    //if not download will be started
    //else alert is displayed that user have to wait
    checkMaxNumDownloadsConstraint : function()
    {
        $.get(API_PATH + '/file/download/wait/get.php')
        .done( (json) => {
            if (json.secondsToWait != 0)
                this.openUsedAllNumOfDownloadsAlert(json.secondsToWait);
            else
                this.download();
        })
        .fail( (xhr) => {
            request.fail(xhr);
        });
    },

    //redirects to download link(browser will open download dialog)
    download : function()
    {
        window.location = $(".downloadBtn > a").attr("href");
    }
};

$(document).ready( () => {
    download.initStartDownloadClick();
});