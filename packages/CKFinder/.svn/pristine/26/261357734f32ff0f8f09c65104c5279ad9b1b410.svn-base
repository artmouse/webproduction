<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.com.ua>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU LESSER GENERAL PUBLIC LICENSE
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 */

if (class_exists('XCMSE')) {
    XCMSE::GetPackages()->registerAutoloadPath(dirname(__FILE__));
} elseif (class_exists('PackageLoader')) {
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/CKFinder_Configuration.class.php');
} else {
    include_once(dirname(__FILE__).'/CKFinder_Configuration.class.php');
}