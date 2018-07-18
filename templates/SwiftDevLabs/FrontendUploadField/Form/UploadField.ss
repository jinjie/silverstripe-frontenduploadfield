<input $AttributesHTML <% include SilverStripe/Forms/AriaAttributes %> />
<div class="{$ID}-preview"></div>
<script>
var {$ID}_Dropzone = new Dropzone("input#{$ID}", {
    previewsContainer: '.{$ID}-preview',
    params: {
        SecurityID: '$Form.SecurityToken.SecurityID'
    },
    <% if Not $IsMultiUpload %>
    maxFiles: 1,
    <% end_if %>
    url: '$Link/upload'
});
</script>