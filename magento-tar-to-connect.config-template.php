<?php
/**
 * Copyright 2016 Packlink
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

return array(

//The base_dir and archive_file path are combined to point to your tar archive
//The basic idea is a separate process builds the tar file, then this finds it
    'base_dir'               => __DIR__ . DIRECTORY_SEPARATOR . 'build',
    'archive_files'          => '{NAME}.tar',

//The Magento Connect extension name.  Must be unique on Magento Connect
//Has no relation to your code module name.  Will be the Connect extension name
    'extension_name'         => '{NAME}',

//Your extension version.  By default, if you're creating an extension from a 
//single Magento module, the tar-to-connect script will look to make sure this
//matches the module version.  You can skip this check by setting the 
//skip_version_compare value to true
    'extension_version'      => '{VERSION}',
    'skip_version_compare'   => false,

//You can also have the package script use the version in the module you 
//are packaging with. 
    'auto_detect_version'   => false,

//Where on your local system you'd like to build the files to
    'path_output'            => '{BUILD}',

//Magento Connect license value. 
    'stability'              => 'beta',

//Magento Connect license value 
    'license'                => 'Apache Software License (ASL)',

//Magento Connect channel value.  This should almost always (always?) be community
    'channel'                => 'community',

//Magento Connect information fields.
    'summary'                => '!SUMMARY!',
    'description'            => '!DESCRIPTION!',
    'notes'                  => '!NOTES!',

//Magento Connect author information. If author_email is foo@example.com, script will
//prompt you for the correct name.  Should match your http://www.magentocommerce.com/
//login email address
    'author_name'            => 'Packlink',
    'author_user'            => 'packlink',
    'author_email'           => 'ecommerce@packlink.com',

//PHP min/max fields for Connect.  I don't know if anyone uses these, but you should
//probably check that they're accurate
    'php_min'                => '5.3.0',
    'php_max'                => '6.0.0'
);
