<script type="text/javascript">
<?php $timestamp = time();?>
$(function() {
    $('#file_upload').uploadify({
        'formData'     : {
            'timestamp' : '<?php echo $timestamp;?>',
            'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
        },
        'swf'      : '../uploadify/uploadify.swf',
        'uploader' : '../uploadify/uploadify.php'
    });
});
</script>
<?php
Functions::Check_User_Permissions_Redirect("Staff");
?>
<div class='ContentHeader'>File Upload</div><hr>

<input type="file" name="file_upload" id="file_upload" multiple="true"/>

<br>

<script>
window.setInterval("reloadIFrame();", 8000);
function reloadIFrame() {
 document.getElementById("uploadedFiles").src="http://dustinhendrickson.com:8080/uploads/";
}
</script>

<b>Files currently uploaded</b><br>
<iframe id="uploadedFiles" src="http://dustinhendrickson.com:8080/uploads/" width="100%" height="70%"></iframe>
