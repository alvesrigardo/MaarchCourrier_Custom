<?php

/**
 * Copyright Maarch since 2008 under licence GPLv3.
 * See LICENCE.txt file at the root folder for more details.
 * This file is part of Maarch software.
 *
 */

/**
 * @brief Resource data DB
 * @author dev@maarch.org
 */

namespace Resource\Infrastructure;

use Convert\controllers\ConvertPdfController;
use Convert\models\AdrModel;
use Docserver\models\DocserverModel;
use Resource\controllers\ResController;
use Resource\Domain\Models\Docserver;
use Resource\Domain\Exceptions\ExceptionParameterCanNotBeEmpty;
use Resource\Domain\Exceptions\ExceptionParameterCanNotBeEmptyAndShould;
use Resource\Domain\Exceptions\ExceptionParameterMustBeGreaterThan;
use Resource\Domain\Exceptions\ExceptionResourceDocserverDoesNotExist;
use Resource\Domain\Exceptions\ExceptionResourceDoesNotExist;
use Resource\Domain\Exceptions\ExecptionConvertedResult;
use Resource\Domain\Models\Resource;
use Resource\Domain\Models\ResourceConverted;
use Resource\Domain\Interfaces\ResourceDataInterface;
use Resource\models\ResModel;
use SrcCore\models\TextFormatModel;

class ResourceData implements ResourceDataInterface
{
    /**
     * @param   int     $resId
     * 
     * @return  Resource
     * 
     * @throws  ExceptionParameterMustBeGreaterThan|ExceptionResourceDoesNotExist
     */
    public function getMainResourceData(int $resId): Resource
    {
        if ($resId <= 0) {
            throw new ExceptionParameterMustBeGreaterThan('resId', 0);
        }

        $resource = ResModel::getById(['resId'  => $resId, 'select' => ['*']]);

        if (empty($resource)) {
            throw new ExceptionResourceDoesNotExist();
        }

        return new Resource(
            $resource['res_id'],
            $resource['subject'],
            $resource['docserver_id'],
            $resource['path'],
            $resource['filename'],
            $resource['version'],
            $resource['fingerprint'],
            $resource['format'],
            $resource['typist']
        );
    }

    /**
     * @param   int     $resId
     * @param   int     $version
     * 
     * @return  ResourceConverted
     * 
     * @throws  ExceptionParameterMustBeGreaterThan|ExceptionResourceDoesNotExist
     */
    public function getSignResourceData(int $resId, int $version): ResourceConverted
    {
        if ($resId <= 0) {
            throw new ExceptionParameterMustBeGreaterThan('resId', 0);
        }
        if ($version <= 0) {
            throw new ExceptionParameterMustBeGreaterThan('version', 0);
        }

        $resource = AdrModel::getDocuments([
            'select' => ['*'],
            'where'  => ['res_id = ?', 'type = ?', 'version = ?'],
            'data'   => [$resId, 'SIGN', $version],
            'limit'  => 1
        ]);

        if (empty($resource[0])) {
            throw new ExceptionResourceDoesNotExist();
        }

        return new ResourceConverted(
            $resource[0]['id'],
            $resource[0]['res_id'],
            $resource[0]['type'],
            $resource[0]['version'],
            $resource[0]['docserver_id'],
            $resource[0]['path'],
            $resource[0]['filename'],
            $resource[0]['fingerprint']
        );
    }

    /**
     * @param   string  $docserverId
     * 
     * @return  Docserver
     * 
     * @throws  ExceptionParameterCanNotBeEmpty|ExceptionResourceDocserverDoesNotExist
     */
    public function getDocserverDataByDocserverId(string $docserverId): Docserver
    {
        if (empty($docserverId)) {
            throw new ExceptionParameterCanNotBeEmpty('docserverId');
        }

        $docserver = DocserverModel::getByDocserverId(['docserverId' => $docserverId, 'select' => ['*']]);

        if (empty($docserver)) {
            throw new ExceptionResourceDocserverDoesNotExist();
        }

        return new Docserver(
            $docserver['id'],
            $docserver['docserver_id'],
            $docserver['docserver_type_id'],
            $docserver['path_template'],
            $docserver['is_encrypted']
        );
    }

    /**
     * Update resource fingerprint
     * 
     * @param   int     $resId
     * @param   string  $fingerprint
     * 
     * @return  void
     */
    public function updateFingerprint(int $resId, string $fingerprint): void
    {
        ResModel::update(['set' => ['fingerprint' => $fingerprint], 'where' => ['res_id = ?'], 'data' => [$resId]]);
    }

    /**
     * @param   string  $name
     * @param   int     $maxLength  Default value is 250 length
     * 
     * @return  string
     */
    public function formatFilename(string $name, int $maxLength = 250): string
    {
        return TextFormatModel::formatFilename(['filename' => $name, 'maxLength' => 250]);
    }

    /**
     * Return the converted pdf from resource
     * 
     * @param   int     $resId  Resource id
     * @param   string  $collId Resource type id : letterbox_coll or attachments_coll
     * 
     * @return  ResourceConverted
     * 
     * @throws  ExceptionParameterMustBeGreaterThan|ExceptionParameterCanNotBeEmptyAndShould|ExecptionConvertedResult
     */
    public function getConvertedPdfById(int $resId, string $collId): ResourceConverted
    {
        if ($resId <= 0) {
            throw new ExceptionParameterMustBeGreaterThan('resId', 0);
        }
        if (empty($collId) || ($collId !== 'letterbox_coll' && $collId !== 'attachments_coll')) {
            throw new ExceptionParameterCanNotBeEmptyAndShould('collId', "'letterbox_coll' or 'attachments_coll'");
        }

        $convertedDocument = ConvertPdfController::getConvertedPdfById(['resId' => $resId, 'collId' => $collId]);
        if (!empty($convertedDocument['errors'])) {
            throw new ExecptionConvertedResult('Conversion error', $convertedDocument['errors']);
        }

        return new ResourceConverted(
            $convertedDocument['id'],
            $resId,
            '',
            0,
            $convertedDocument['docserver_id'],
            $convertedDocument['path'],
            $convertedDocument['filename'],
            $convertedDocument['fingerprint']
        );
    }

    /**
     * @param   int     $resId      Resource id
     * @param   string  $type       Resource converted format
     * @param   int     $version    Resource version
     * 
     * @return  ?ResourceConverted
     * 
     * @throws  ExceptionParameterMustBeGreaterThan|ExceptionParameterCanNotBeEmptyAndShould
     */
    public function getResourceVersion(int $resId, string $type, int $version): ?ResourceConverted
    {
        if ($resId <= 0) {
            throw new ExceptionParameterMustBeGreaterThan('resId', 0);
        }
        $checkThumbnailPageType = ctype_digit(str_replace('TNL', '', $type));
        if (empty($type) || (!in_array($type, $this::ADR_RESOURCE_TYPES) && !$checkThumbnailPageType)) {
            throw new ExceptionParameterCanNotBeEmptyAndShould('type', implode(', ', $this::ADR_RESOURCE_TYPES) . " or thumbnail page 'TNL*'");
        }
        if ($version <= 0) {
            throw new ExceptionParameterMustBeGreaterThan('version', 0);
        }

        $document = AdrModel::getDocuments([
            'select'    => ['id', 'docserver_id', 'path', 'filename', 'fingerprint'],
            'where'     => ['res_id = ?', 'type = ?', 'version = ?'],
            'data'      => [$resId, $type, $version]
        ]);

        if (empty($document[0])) {
            return null;
        }

        $document = new ResourceConverted(
            $document[0]['id'],
            $resId,
            $type,
            $version,
            $document[0]['docserver_id'],
            $document[0]['path'],
            $document[0]['filename'],
            $document[0]['fingerprint']
        );
        return $document;
    }

    /**
     * @param   int     $resId  Resource id
     * @param   string  $type   Resource converted format
     * 
     * @return  ResourceConverted
     * 
     * @throws  ExceptionParameterMustBeGreaterThan|ExceptionParameterCanNotBeEmptyAndShould|ExceptionResourceDoesNotExist
     */
    public function getLatestResourceVersion(int $resId, string $type): ResourceConverted
    {
        if ($resId <= 0) {
            throw new ExceptionParameterMustBeGreaterThan('resId', 0);
        }
        if (empty($type) || !in_array($type, $this::ADR_RESOURCE_TYPES)) {
            throw new ExceptionParameterCanNotBeEmptyAndShould('type', implode(', ', $this::ADR_RESOURCE_TYPES));
        }
        
        $document = AdrModel::getDocuments([
            'select'    => ['id', 'version', 'docserver_id', 'path', 'filename', 'fingerprint'],
            'where'     => ['res_id = ?', 'type = ?'],
            'data'      => [$resId, $type],
            'orderBy'   => ['version desc']
        ]);

        if (empty($document[0])) {
            throw new ExceptionResourceDoesNotExist();
        }

        return new ResourceConverted(
            $document[0]['id'],
            $resId,
            $type,
            $document[0]['version'],
            $document[0]['docserver_id'],
            $document[0]['path'],
            $document[0]['filename'],
            $document[0]['fingerprint']
        );
    }

    /**
     * Check if user has rights over the resource
     * 
     * @param   int     $resId      Resource id
     * @param   int     $userId     User id
     * 
     * @return  bool
     */
    public function hasRightByResId(int $resId, int $userId): bool
    {
        return ResController::hasRightByResId(['resId' => [$resId], 'userId' => $userId]);
    }
}
