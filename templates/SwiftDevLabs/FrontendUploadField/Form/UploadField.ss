<div class="dropzone">
    <div class="{$ID}-dropzone droparea">
        <span>Drop files here or <a>click here to select files</a></span>
    </div>
    <div class="{$ID}-previews-container dz-previews-container">
    </div>
</div>
<script>
var {$ID}_Dropzone = new Dropzone(".{$ID}-dropzone", {
    previewsContainer: '.{$ID}-previews-container',
    params: {
        SecurityID: '$Form.SecurityToken.SecurityID'
    },
    <% if Not $IsMultiUpload %>
    maxFiles: 1,
    <% end_if %>
    url: '$Link/upload',
    clickable: '.{$ID}-dropzone a'
});
</script>