<form id="fileupload" action="<?php if(isset($upload_action)) echo $upload_action; ?>" method="POST" enctype="multipart/form-data">
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row-fluid fileupload-buttonbar">
        <!-- The fileinput-button span is used to style the file input field as button -->
        <div class="slide_right">
            <span rel="customtip" title="Select empty room images from your computer to upload" class="fileinput-button file-upload-doc">
                <i class="fa fa-cloud-upload"></i>
                <input type="file" name="fileImage[]" <?php if (!Yii::app()->user_agent->is_browser('Safari')) {
    echo 'multiple="multiple"';
}
?> />
                <span>Select images</span>
            </span>
            <div class="file-drop-wrapper">
                Drop files here
            </div>
            
            <!--button rel="customtip" title="After selecting images, click here to start upload" type="submit" class="start">
                <i class="fa fa-check-circle-o"></i>
                Start upload
            </button>
            <button rel="customtip" title="Click here to cancel image upload" type="reset" class="cancel">
                <i class="fa fa-times-circle-o"></i>
                Cancel upload
            </button>
            <a  rel="customtip" title="Click here to clear upload panel, None of uploaded images will be deleted" class="clear_all" href="#">
                <i class="fa fa-times"></i>
            </a-->

        </div>

    </div>
    <!-- The loading indicator is shown during image processing -->
    <div class="fileupload-loading"></div>
    <div class="upload-status-cont row-fluid">
    <!-- The table listing the files available for upload/download -->
    <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </div>
</form>