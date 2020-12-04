<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://www.facebook.com/asror.zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\service\smart;


use yii\base\Component;
use yii\helpers\ArrayHelper;
use zetsoft\dbitem\core\NormServiceItem;
use zetsoft\dbitem\data\ALLApp;
use zetsoft\dbitem\data\Settings;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\helpers\ZFileHelper;
use zetsoft\system\helpers\ZStringHelper;
use zetsoft\system\kernels\ZFrame;

class Tester extends ZFrame
{
    #region Vars
    public $dev = false;
    public const devdata = [
        'dir' => 'zetsoft/storing/testing/service/',
        'use' => 'zetsoft\storing\testing\service\\',
    ];
    public const proddata = [
        'dir' => 'zetsoft/service/',
        'use' => 'zetsoft\service\\',
    ];
    private $utd;
    private $fl;


    /* @var ALLApp $allApp */
    public $allApp;

    /* @var Settings $proper */
    public $setter;

    private $path;
    private $pathAll;

    /**
     *
     * Services
     */

    private $properties;
    private $uses;

    private $pathServiceAll;
    private $pathService;

    public $hasOne = [];
    public $hasMulti = [];
    public $hasMany = [];

    /**
     *
     * Constants
     */

    public const Path = [


        /*'aliasServisePath' => '@zetsoft/service/App/ALL',
        'aliasServiseAllPath' => '@zetsoft/service/ALL',*/

        'aliasServisePath' => '@zetsoft/service/App',
        'aliasServiseAllPath' => '@zetsoft/service'
    ];

#endregion

#region ALL

    public function init()
    {

        parent::init(); // TODO: Change the autogenerated stub
        /**
         *
         * Path Fixes
         */

        $this->pathService = \Yii::getAlias(self::Path['aliasServisePath']);
        $this->pathServiceAll = \Yii::getAlias(self::Path['aliasServiseAllPath']);
    }


    #endregion


#region Service

    public function run()
    {
        $allItems = $this->pathScan();
        if (!empty($allItems)) {
            Az::$app->params['successTests'] = 0;
            Az::$app->params['failedTests'] = 0;
            $runList = Az::$app->utility->pregs->refMethodListTest($allItems);
            $folder = ZArrayHelper::getValue($this->paramGet('smartFolder'), [0]);
            foreach ($runList as $key => $funcName) {
                foreach ($funcName as $func) {
                    $name = $func->name;
                    $gg = Az::$app->$folder->$key->$name();
                }
            }  
            Az::$app->utility->execs->exec('echo [32mSuccess: [39m' . Az::$app->params['successTests'] . ', [31mFailure: [39m' . Az::$app->params['failedTests'] . EOL);
        } else {
            Az::error($this->paramGet('smartFolder'), 'Paths does not exist');
        }
    }

    public function pathScan($rootService = true)
    {
        if ($rootService) {
            $pathAll = ZFileHelper::scanFolder($this->pathServiceAll, false);
            $path = $this->pathServiceAll;
        } else {
            $pathAll = ZFileHelper::scanFolder($this->pathService, false);
            $path = $this->pathService;
        }

        $return = [];
        $gg = $this->paramGet('smartFolder');
        foreach ($pathAll as $pathKey => $pathVal) {
            $pathName = bname($pathVal);
            if (!empty($this->paramGet('smartFolder'))) {
                if (ZArrayHelper::isIn($pathName, $this->paramGet('smartFolder'))) {
                    $filesAll = ZFileHelper::scanFilesPHP($pathVal);
                    foreach ($filesAll as $file) {
                        $return[] = str_replace('.php', '', bname($file));
                    }
                }
            }
        }
        return $return;
    }

    public function clearTrace($trace)
    {
        $array = null;
        foreach ($trace as $item) {
            if (ZArrayHelper::keyExists('file', $item) && ZArrayHelper::keyExists('type', $item))
                if (!ZStringHelper::find($item['file'], 'zetsoft\system\helpers') && !ZStringHelper::find($item['file'], 'zetsoft\system') && !ZStringHelper::find($item['file'], 'vendor\\') && !ZStringHelper::find($item['file'], 'excmd') && !ZStringHelper::find($item['type'], '->') && \count($item) !== 3 && !ZStringHelper::find($item['class'], 'PHPUnit\Framework\Assert') ) {
                    $array[] = $item;
                }
        }
        return $array;
    }
}