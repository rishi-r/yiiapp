$(function(){
    'use strict';
        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload({
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                autoUpload:true,
                dropZone:$(".file-drop-wrapper"),
                start: function(e)
                {
                    //blockcont("body",'Please wait while uploading....');
                    //on start - disable:
                    //  .btn-primary.start
                    //  .btnupload
                },
                stop: function(e)
                {
                    //unblockcont("body");
                    //on start - disable:
                    //  .btn-primary.start
                    //  .btnupload
                },
                completed: function(e, a)
                {
                    /*for(var i in a.result)
                    {
                        if((a.result)[i].image_id !=undefined)
                        {
                            
                        }
                    }*/
                }
        });
});