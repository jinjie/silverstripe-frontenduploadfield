# UploadField for SilverStripe 4 Frontend with Dropzonejs

UploadField by silverstripe/silverstripe-asset-admin does not work on frontend. So I extended `\SilverStripe\AssetAdmin\Forms\UploadField` for frontend file uploads.

This was developed under a couple hours. Please help to contribute further!

```php
use SwiftDevLabs\FrontendUploadField\Form\UploadField;
...
$field = UploadField::create('File', 'Upload Your File');
$fields->push($field);
```