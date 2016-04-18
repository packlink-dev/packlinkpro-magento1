#!/usr/bin/env bash
# Copyright 2016 OMI Europa S.L (Packlink)
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#  http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

VERSION="0.1"
BUILD_NAME="packlink-magento-1.x_v${VERSION}"

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
BUILD_BASE="${DIR}/build"
BUILD_DIR="${BUILD_BASE}/${BUILD_NAME}"
EXT_DIR="${BUILD_DIR}/app/code/community/Packlink/Magento1"
ETC_DIR="${BUILD_DIR}/app/etc/modules"
LIB_DIR="${BUILD_DIR}/lib/Packlink"

# remove old
rm -rf ${BUILD_BASE}

# extension
mkdir -p ${EXT_DIR}
cp -R ${DIR}/Packlink/Magento1/* ${EXT_DIR}
cp ${DIR}/LICENSE ${EXT_DIR}
mkdir -p ${ETC_DIR}
cp ${DIR}/Packlink_Magento1.xml ${ETC_DIR}

# lib
mkdir -p ${LIB_DIR}
cp -R ${DIR}/api-php-sdk/Packlink/* ${LIB_DIR}

TAR=`which tar`
# create TAR archive(s)
if [[ -x ${TAR} ]] ; then
    pushd ${BUILD_BASE} >/dev/null
    ${TAR} -czvf ${BUILD_NAME}.tar.gz ${BUILD_NAME}/ >/dev/null
    ${TAR} -cjvf ${BUILD_NAME}.tar.bz2 ${BUILD_NAME}/ >/dev/null
    popd >/dev/null
else
    echo "tar command not found."
fi

ZIP=`which zip`
# create ZIP archive
if [[ -x ${ZIP} ]] ; then
    pushd ${BUILD_BASE} >/dev/null
    ${ZIP} -r ${BUILD_NAME}.zip ${BUILD_NAME}/ >/dev/null
    popd >/dev/null
else
    echo "zip command not found."
fi

echo "Done, archives are stored in ${BUILD_BASE}"
