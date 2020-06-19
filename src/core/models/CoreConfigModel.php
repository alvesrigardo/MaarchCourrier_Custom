<?php

/**
* Copyright Maarch since 2008 under licence GPLv3.
* See LICENCE.txt file at the root folder for more details.
* This file is part of Maarch software.
*
*/

/**
* @brief Core Config Model
* @author dev@maarch.org
* @ingroup core
*/

namespace SrcCore\models;

class CoreConfigModel
{
    public static function getCustomId()
    {
        static $customId;

        if ($customId !== null) {
            return $customId;
        }

        // Use for script
        if (!empty($GLOBALS['customId'])) {
            $customId = $GLOBALS['customId'];
            return $customId;
        }

        if (!is_file('custom/custom.json') || empty($_SERVER['SCRIPT_NAME']) || empty($_SERVER['SERVER_ADDR'])) {
            $customId = '';
            return $customId;
        }

        $explodeUrl = explode('/', $_SERVER['SCRIPT_NAME']);

        $path = $explodeUrl[count($explodeUrl) - 3];

        $jsonFile = file_get_contents('custom/custom.json');
        $jsonFile = json_decode($jsonFile, true);
        foreach ($jsonFile as $value) {
            if (!empty($value['path']) && $value['path'] == $path) {
                $customId = $value['id'];
                return $customId;
            } elseif ($value['uri'] == $_SERVER['HTTP_HOST'] || ($_SERVER['HTTP_HOST'] == $_SERVER['SERVER_ADDR'] && $value['uri'] == $_SERVER['SERVER_ADDR'])) {
                $customId = $value['id'];
                return $customId;
            }
        }

        $customId = '';
        return $customId;
    }

    public static function getConfigPath()
    {
        $customId = CoreConfigModel::getCustomId();
        if (!empty($customId) && is_file("custom/{$customId}/apps/maarch_entreprise/xml/config.json")) {
            $path = "custom/{$customId}/apps/maarch_entreprise/xml/config.json";
        } else {
            $path = 'apps/maarch_entreprise/xml/config.json';
        }

        return $path;
    }

    public static function getApplicationName()
    {
        static $applicationName;

        if ($applicationName !== null) {
            return $applicationName;
        }

        $file = CoreConfigModel::getJsonLoaded(['path' => 'apps/maarch_entreprise/xml/config.json']);

        if (!empty($file['config']['applicationName'])) {
            $applicationName = $file['config']['applicationName'];
            return $applicationName;
        }

        $applicationName = 'Maarch Courrier';
        return $applicationName;
    }

    public static function getApplicationVersion()
    {
        $file = file_get_contents('package.json');
        $file = json_decode($file, true);

        return $file['version'];
    }

    public static function getLanguage()
    {
        $availableLanguages = ['en', 'fr', 'nl'];

        $file = CoreConfigModel::getJsonLoaded(['path' => 'apps/maarch_entreprise/xml/config.json']);

        if ($file) {
            $lang = $file['config']['lang'];
            if (in_array($lang, $availableLanguages)) {
                return $lang;
            }
        }

        return 'en';
    }

    public static function getCustomLanguage($aArgs = [])
    {
        $customId = CoreConfigModel::getCustomId();
        if (file_exists('custom/' . $customId . '/lang/lang-'.$aArgs['lang'].'.ts')) {
            $fileContent = file_get_contents('custom/' . $customId . '/lang/lang-'.$aArgs['lang'].'.ts');
            $fileContent = str_replace("\n", "", $fileContent);

            $strpos = strpos($fileContent, "=");
            $substr = substr(trim($fileContent), $strpos + 2, -1);

            $trimmed = rtrim($substr, ',}');
            $trimmed .= '}';
            $decode = json_decode($trimmed);

            return $decode;
        }

        return '';
    }

    /**
     * Get the timezone
     *
     * @return string
     */
    public static function getTimezone()
    {
        $timezone = 'Europe/Paris';

        $file = CoreConfigModel::getJsonLoaded(['path' => 'apps/maarch_entreprise/xml/config.json']);

        if ($file) {
            if (!empty($file['config']['timezone'])) {
                $timezone = $file['config']['timezone'];
            }
        }

        return $timezone;
    }

    /**
     * Get the tmp dir
     *
     * @return string
     */
    public static function getTmpPath()
    {
        if (isset($_SERVER['MAARCH_TMP_DIR'])) {
            $tmpDir = $_SERVER['MAARCH_TMP_DIR'];
        } elseif (isset($_SERVER['REDIRECT_MAARCH_TMP_DIR'])) {
            $tmpDir = $_SERVER['REDIRECT_MAARCH_TMP_DIR'];
        } else {
            $tmpDir = sys_get_temp_dir();
        }

        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0755);
        }

        return $tmpDir . '/';
    }

    /**
     * Get the Encrypt Key
     *
     * @return string
     */
    public static function getEncryptKey()
    {
        if (isset($_SERVER['MAARCH_ENCRYPT_KEY'])) {
            $encryptKey = $_SERVER['MAARCH_ENCRYPT_KEY'];
        } elseif (isset($_SERVER['REDIRECT_MAARCH_ENCRYPT_KEY'])) {
            $encryptKey = $_SERVER['REDIRECT_MAARCH_ENCRYPT_KEY'];
        } else {
            $encryptKey = "Security Key Maarch Courrier #2008";
        }

        return $encryptKey;
    }

    public static function getLibrariesDirectory()
    {
        if (isset($_SERVER['LIBRARIES_DIR'])) {
            $librariesDirectory = rtrim($_SERVER['LIBRARIES_DIR'], '/') . '/';
        } elseif (isset($_SERVER['REDIRECT_LIBRARIES_DIR'])) {
            $librariesDirectory = rtrim($_SERVER['REDIRECT_LIBRARIES_DIR'], '/') . '/';
        } else {
            $librariesDirectory = null;
        }

        return $librariesDirectory;
    }

    public static function getLoggingMethod()
    {
        $loadedXml = CoreConfigModel::getXmlLoaded(['path' => 'apps/maarch_entreprise/xml/login_method.xml']);

        $loggingMethod = [];
        if ($loadedXml) {
            foreach ($loadedXml->METHOD as $value) {
                if ((string)$value->ENABLED == 'true') {
                    $loggingMethod['id']        = (string)$value->ID;
                    $loggingMethod['name']      = (string)$value->NAME;
                    $loggingMethod['script']    = (string)$value->SCRIPT;
                }
            }
        }

        return $loggingMethod;
    }

    public static function getMailevaConfiguration()
    {
        $loadedXml = CoreConfigModel::getXmlLoaded(['path' => 'apps/maarch_entreprise/xml/mailevaConfig.xml']);

        $mailevaConfig = [];
        if ($loadedXml) {
            $mailevaConfig['enabled']       = filter_var((string)$loadedXml->ENABLED, FILTER_VALIDATE_BOOLEAN);
            $mailevaConfig['connectionUri'] = (string)$loadedXml->CONNECTION_URI;
            $mailevaConfig['uri']           = (string)$loadedXml->URI;
            $mailevaConfig['clientId']      = (string)$loadedXml->CLIENT_ID;
            $mailevaConfig['clientSecret']  = (string)$loadedXml->CLIENT_SECRET;
        }

        return $mailevaConfig;
    }

    public static function getXmlLoaded(array $args)
    {
        ValidatorModel::notEmpty($args, ['path']);
        ValidatorModel::stringType($args, ['path']);

        $customId = CoreConfigModel::getCustomId();

        if (!empty($customId) && is_file("custom/{$customId}/{$args['path']}")) {
            $path = "custom/{$customId}/{$args['path']}";
        } else {
            $path = $args['path'];
        }

        $xmlfile = null;
        if (file_exists($path)) {
            $xmlfile = simplexml_load_file($path);
        }

        return $xmlfile;
    }

    public static function getJsonLoaded(array $args)
    {
        ValidatorModel::notEmpty($args, ['path']);
        ValidatorModel::stringType($args, ['path']);

        $customId = CoreConfigModel::getCustomId();

        if (!empty($customId) && is_file("custom/{$customId}/{$args['path']}")) {
            $path = "custom/{$customId}/{$args['path']}";
        } else {
            $path = $args['path'];
        }

        $file = null;
        if (file_exists($path)) {
            $file = file_get_contents($path);
            $file = json_decode($file, true);
        }

        return $file;
    }

    /**
     * Database Unique Id Function
     *
     * @return string $uniqueId
     */
    public static function uniqueId()
    {
        $parts = explode('.', microtime(true));
        $sec = $parts[0];
        if (!isset($parts[1])) {
            $msec = 0;
        } else {
            $msec = $parts[1];
        }

        $uniqueId = str_pad(base_convert($sec, 10, 36), 6, '0', STR_PAD_LEFT);
        $uniqueId .= str_pad(base_convert($msec, 10, 16), 4, '0', STR_PAD_LEFT);
        $uniqueId .= str_pad(base_convert(mt_rand(), 10, 36), 6, '0', STR_PAD_LEFT);

        return $uniqueId;
    }

    public static function getKeycloakConfiguration(array $aArgs = [])
    {
        ValidatorModel::stringType($aArgs, ['customId']);

        $customId = CoreConfigModel::getCustomId();
        if (!empty($aArgs['customId'])) {
            $customId = $aArgs['customId'];
        }

        if (file_exists("custom/{$customId}/apps/maarch_entreprise/xml/keycloakConfig.xml")) {
            $path = "custom/{$customId}/apps/maarch_entreprise/xml/keycloakConfig.xml";
        } else {
            $path = 'apps/maarch_entreprise/xml/keycloakConfig.xml';
        }

        $keycloakConfig = [];
        if (file_exists($path)) {
            $loadedXml = simplexml_load_file($path);
            if ($loadedXml) {
                $keycloakConfig['authServerUrl']       = (string)$loadedXml->AUTH_SERVER_URL;
                $keycloakConfig['realm']               = (string)$loadedXml->REALM;
                $keycloakConfig['clientId']            = (string)$loadedXml->CLIENT_ID;
                $keycloakConfig['clientSecret']        = (string)$loadedXml->CLIENT_SECRET;
                $keycloakConfig['redirectUri']         = (string)$loadedXml->REDIRECT_URI;
                $keycloakConfig['encryptionAlgorithm'] = (string)$loadedXml->ENCRYPTION_ALGORITHM;
                $keycloakConfig['encryptionKeyPath']   = (string)$loadedXml->ENCRYPTION_KEY_PATH;
                $keycloakConfig['encryptionKey']       = (string)$loadedXml->ENCRYPTION_KEY;
            }
        }

        return $keycloakConfig;
    }

    public static function getColumns(array $args)
    {
        ValidatorModel::notEmpty($args, ['table']);
        ValidatorModel::stringType($args, ['table']);

        $columns = DatabaseModel::getColumns(['table' => $args['table']]);

        return $columns;
    }
}
