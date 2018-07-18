<?php

/**
 * UploadField
 * 
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 * @copyright 2018 Swift DevLabs
 * @package SwiftDevLabs\FrontendUploadField\Form
 */

namespace SwiftDevLabs\FrontendUploadField\Form;

use SilverStripe\AssetAdmin\Controller\AssetAdmin;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Forms\FileField;
use SilverStripe\View\Requirements;

class UploadField extends \SilverStripe\AssetAdmin\Forms\UploadField
{
    private static $allowed_actions = [
        'upload',
    ];

    public function __construct($name, $title = null, SS_List $items = null)
    {
        parent::__construct($name, $title, $items);

        $this->setAttribute('data-schema', '');
        $this->setAttribute('data-state', '');
        $this->setAttribute('name', $name);

        Requirements::customScript("Dropzone.autoDiscover = false;");
        Requirements::javascript('jinjie/silverstripe-frontenduploadfield: res/javascript/dropzone.js');
        Requirements::css('jinjie/silverstripe-frontenduploadfield: /res/css/dropzone.css');
        Requirements::css('jinjie/silverstripe-frontenduploadfield: /res/css/custom.css');
    }

    public function Type()
    {
        return "frontenduploadfield uploadfield";
    }

    public function upload(HTTPRequest $request)
    {
        if ($this->isDisabled() || $this->isReadonly()) {
            return $this->httpError(403);
        }

        // CSRF check
        $token = $this->getForm()->getSecurityToken();
        if (!$token->checkRequest($request)) {
            return $this->httpError(400);
        }

        $tmpFile = $request->postVar('file');
        /** @var File $file */
        $file = $this->saveTemporaryFile($tmpFile, $error);

        // Prepare result
        if ($error) {
            $result = [
                'error' => $error,
            ];
            $this->getUpload()->clearErrors();
            return (new HTTPResponse(json_encode($result), 400))
                ->addHeader('Content-Type', 'application/json');
        }

        // Return success response
        $result = [
            AssetAdmin::singleton()->getObjectFromData($file)
        ];

        // Don't discard pre-generated client side canvas thumbnail
        if ($result[0]['category'] === 'image') {
            unset($result[0]['thumbnail']);
        }
        $this->getUpload()->clearErrors();
        return (new HTTPResponse(json_encode($result)))
            ->addHeader('Content-Type', 'application/json');
    }

    public function getAttributes()
    {
        $attributes = parent::getAttributes();

        unset($attributes['type']);

        return $attributes;
    }
}