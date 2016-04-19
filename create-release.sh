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

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

VERSION=$(grep -oPm1 "(?<=<version>)[^<]+" ${DIR}/Packlink/Magento1/etc/config.xml)
NAME="Packlink_Magento1"
BUILD_NAME="${NAME}"

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
cp ${DIR}/LICENSE.txt ${EXT_DIR}
mkdir -p ${ETC_DIR}
cp ${DIR}/Packlink_Magento1.xml ${ETC_DIR}

# locale
mkdir -p ${BUILD_DIR}/app/locale
cp -R ${DIR}/locale/* ${BUILD_DIR}/app/locale

# lib
# clone fresh copy from github
GIT=`which git`
if [[ -x ${GIT} ]] ; then
    pushd ${BUILD_BASE} >/dev/null
    ${GIT} clone git@github.com:packlink-dev/api-php-sdk.git
    mkdir -p ${LIB_DIR}
    cp -R api-php-sdk/Packlink/* ${LIB_DIR}
    popd >/dev/null
else
    echo "git command not found, unable to continue"
    exit 1
fi

TAR=`which tar`
# create TAR archive(s)
if [[ -x ${TAR} ]] ; then
    pushd ${BUILD_BASE} >/dev/null
    ${TAR} -cvf ${BUILD_NAME}.tar ${BUILD_NAME}/ >/dev/null # for the Magento connect archive creation
    ${TAR} -czvf ${BUILD_NAME}-${VERSION}.tar.gz ${BUILD_NAME}/ >/dev/null
    ${TAR} -cjvf ${BUILD_NAME}-${VERSION}.tar.bz2 ${BUILD_NAME}/ >/dev/null
    popd >/dev/null
else
    echo "tar command not found."
    exit 1
fi

ZIP=`which zip`
# create ZIP archive
if [[ -x ${ZIP} ]] ; then
    pushd ${BUILD_BASE} >/dev/null
    ${ZIP} -r ${BUILD_NAME}-${VERSION}.zip ${BUILD_NAME}/ >/dev/null
    popd >/dev/null
else
    echo "zip command not found."
fi

# Connect

# find magento-tar-to-connect.phar
MTC=`which magento-tar-to-connect.phar`
if [[ ! -x ${MTC} ]] ; then
    # not in $PATH, try current folder
    MTC="${DIR}/magento-tar-to-connect.phar"
fi

# create connect file
if [[ -x ${MTC} ]] ; then
    TPL="${DIR}/magento-tar-to-connect.config-template.php"
    OUT="${DIR}/magento-tar-to-connect.config.php"
    cp ${TPL} ${OUT}
    sed -i "s/{NAME}/${NAME}/g" "${OUT}"
    sed -i "s/{VERSION}/${VERSION}/g" "${OUT}"
    sed -i "s%{BUILD}%${BUILD_BASE}%g" "${OUT}"
    echo -n "$(basename ${MTC}) running ... "
    ${MTC} >/dev/null
    echo "done."
else
    echo
    echo "'magento-tar-to-connect.phar' command not found, no connect archives created."
    echo "Please go to https://github.com/astorm/MagentoTarToConnect"
    echo "and follow instructions how to install it."
    echo
    echo "'magento-tar-to-connect.phar' should be in PATH or in ${DIR}."
    echo
    echo "Normal archives are created and stored under ${BUILD_BASE}"
    exit 2
fi

echo "All done, archives are stored in ${BUILD_BASE}"
