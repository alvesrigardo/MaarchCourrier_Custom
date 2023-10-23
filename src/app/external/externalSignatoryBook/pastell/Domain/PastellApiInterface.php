<?php

/**
 * Copyright Maarch since 2008 under licence GPLv3.
 * See LICENCE.txt file at the root folder for more details.
 * This file is part of Maarch software.
 *
 */

declare(strict_types=1);

namespace ExternalSignatoryBook\pastell\Domain;

interface PastellApiInterface
{
    /**
     * @param PastellConfig $config
     * @return array
     */
    public function getVersion(PastellConfig $config): array;

    /**
     * @param PastellConfig $config
     * @return array
     */
    public function getEntity(PastellConfig $config): array;

    /**
     * @param PastellConfig $config
     * @return array
     */
    public function getConnector(PastellConfig $config): array;

    /**
     * @param PastellConfig $config
     * @return array
     */
    public function getFolderType(PastellConfig $config): array;

    /**
     * @param PastellConfig $config
     * @return array
     */
    public function getIparapheurType(PastellConfig $config): array;

    /**
     * @param PastellConfig $config
     * @return array
     */
    public function createFolder(PastellConfig $config): array;

    /**
     * @param PastellConfig $config
     * @param string $idFolder
     * @return array
     */
    public function getIparapheurSousType(PastellConfig $config, string $idFolder): array;

    /**
     * @param PastellConfig $config
     * @param string $idFolder
     * @param string $title
     * @return array
     */
    public function editFolder(PastellConfig $config, string $idFolder, string $title): array;

    /**
     * @param PastellConfig $config
     * @param string $idFolder
     * @return array
     */
    public function uploadMainFile(PastellConfig $config, string $idFolder): array;

    /**
     * @param PastellConfig $config
     * @param string $idFolder
     * @return array
     */
    public function getFolderDetail(PastellConfig $config, string $idFolder): array;

    public function getXmlDetail(PastellConfig $config, string $idFolder): object;
    public function downloadFile(PastellConfig $config, string $idDocument): array;

    public function verificationIParapheur(PastellConfig $config, string $idDocument): bool;
}
