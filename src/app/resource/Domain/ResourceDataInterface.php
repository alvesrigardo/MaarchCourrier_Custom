<?php

/**
 * Copyright Maarch since 2008 under licence GPLv3.
 * See LICENCE.txt file at the root folder for more details.
 * This file is part of Maarch software.
 *
 */

/**
 * @brief Resource Data Interface
 * @author dev@maarch.org
 */

namespace Resource\Domain;

interface ResourceDataInterface
{
    public const ERROR_RESOURCE_DOES_NOT_EXIST = 'Document does not exist';
    public const ERROR_RESOURCE_HAS_NO_FILE = 'Document has no file';
    public const ERROR_RESOURCE_DOCSERVER_DOES_NOT_EXIST = 'Docserver does not exist';

    /**
     * @param   int     $resId
     * @param   array   $select, default value is ['*']
     * @return  array
     */
    public function getMainResourceData(int $resId, array $select = ['*']): array;

    /**
     * @param   int     $resId
     * @param   int     $version
     * @param   array   $select, default value is ['*']
     * @return  array
     */
    public function getSignResourceData(int $resId, int $version, array $select = ['*']): array;

    /**
     * @param   string  $docserverId
     * @param   array   $select, default value is ['*']
     * @return  array
     */
    public function getDocserverDataByDocserverId(string $docserverId, array $select = ['*']): array;

    /**
     * Update resource fingerprint
     * 
     * @param   int     $resId
     * @param   string  $fingerprint
     * @return  void
     */
    public function updateFingerprint(int $resId, string $fingerprint): void;

    /**
     * @param   string  $name
     * @return  string
     */
    public function formatFilename(string $name): string;
}
