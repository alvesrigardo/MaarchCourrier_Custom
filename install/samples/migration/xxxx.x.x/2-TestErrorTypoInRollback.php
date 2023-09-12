<?php

require 'vendor/autoload.php';

use SrcCore\interfaces\AutoUpdateInterface;
use SrcCore\models\CoreConfigModel;

return new class implements AutoUpdateInterface
{
    private static $testConfigPath = 'config/config.json.backup';
    private static $originalConfigPath = 'config/config.json';

    public function backup(): void
    {
        try {
            $config = CoreConfigModel::getJsonLoaded(['path' => self::$originalConfigPath]);
            file_put_contents(self::$testConfigPath, json_encode($config), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update(): void
    {
        try {
            $config = CoreConfigModel::getJsonLoaded(['path' => self::$originalConfigPath]);
            $config['PhpUnitTest'] = [
                'hello'     => 'world',
                'maarch'    => 'courrier'
            ];

            // simulate en error
            file_put_contents(self::$testConfigPath_, json_encode($config), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function rollback(): void
    {
        try {
            $config = CoreConfigModel::getJsonLoaded(['path' => self::$testConfigPath]);
            file_put_contents(self::$originalConfigPath, json_encode($config), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            unlink(self::$testConfigPath);

            // simulate en error
            unlink(self::$testConfigPath_);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
};