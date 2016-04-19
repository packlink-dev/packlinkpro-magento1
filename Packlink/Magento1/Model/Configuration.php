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
final class Packlink_Magento1_Model_Configuration
{
    /**
     * @return string
     */
    public function getLogFileName()
    {
        return 'packlink.log';
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return Mage::getStoreConfig('Packlink_Magento1/general/service_url');
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return Mage::getStoreConfig('Packlink_Magento1/general/api_key');
    }

    /**
     * @return array
     */
    public function getSender()
    {
        return Mage::getStoreConfig('Packlink_Magento1/sender');
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return Mage::getStoreConfigFlag('Packlink_Magento1/general/enabled');
    }
}
