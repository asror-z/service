<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\service\tests;


use zetsoft\dbitem\ALL\ZAppItem;
use zetsoft\dbitem\wdg\MenuItem;
use zetsoft\dbitem\core\NormServiceItem;
use zetsoft\models\shop\ShopCategory;
use zetsoft\service\cores\Category;
use zetsoft\service\utility\File;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZFileHelper;
use zetsoft\system\helpers\ZTest;
use zetsoft\system\kernels\ZFrame;
use zetsoft\widgets\navigat\ZNestable2Widget;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

class Serializer extends ZFrame
{
    public function assertTest(){
        ZTest::assertEquals(1, 2);
    }
    public function resSerializer($data, $type)
    {
        $serializer  =  JMS\Serializer\SerializerBuilder::create()->build();
        $jsonContent  =  $serializer->serialize($data,'json');


        /*$serializer = JMS\Serializer\SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($data, $type); //$type = 'json'|'xml'|'yaml';
        return $jsonContent; // or return it in a Response*/
    }

    public function resDeserializer($jsonData, $type)
    {
        /*$serializer = JMS\Serializer\SerializerBuilder::create()->build();
        $object = $serializer->deserialize($jsonData, 'MyNamespace\MyObject', $type); //$type = 'json'|'xml'|'yaml';
        return $object;*/
    }
   

    #region Core


    private function load($app)
    {
        $isTest = true;

        if ($isTest)
            $this->rootDir = Root . '\storing\testing';
        else $this->rootDir = Root;

        $items[] = function (ZAppItem $item) use ($app) {

            $item->templatePath = "/excmd/";
            $item->generate = "/excmd/$app/asrorz.php";
            $item->generatePath = "\\execut\\cmd\\$app";
            $item->replace = [
                '{app}' => $app,
            ];

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->templatePath = "/exrest/";
            $item->generate = "/exrest/$app/index_product.php";
            $item->generatePath = "/exrest/$app";
            $item->replace = [
                '{app}' => $app,
            ];

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/exweb/$app/.gitkeep";
            $item->generatePath = "/exweb/$app";

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->templatePath = "/configs/cmd/";
            $item->generate = "/configs/cmd/$app.php";
            $item->generatePath = "/configs/cmd";

            $item->affectFileOnly = true;

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->templatePath = "/configs/data/";
            $item->generate = "/configs/data/$app.php";
            $item->generatePath = "/configs/data";
            $item->replace = [
                '{app}' => $app,
            ];

            $item->affectFileOnly = true;

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->template = "Azk.env";
            $item->templatePath = "/configs/env/";
            $item->generate = "/configs/env/$app.env";
            $item->generatePath = "/configs/env";
            $item->replace = [
                '{app}' => $app,
            ];

            $item->affectFileOnly = true;

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->templatePath = "/configs/api/core/";
            $item->generate = "/configs/api/core/$app.php";
            $item->generatePath = "/configs/rest";

            $item->affectFileOnly = true;

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->templatePath = "/configs/web/";
            $item->generate = "/configs/web/$app.php";
            $item->generatePath = "/configs/web";

            $item->affectFileOnly = true;

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/control/env/$app/.gitkeep";
            $item->generatePath = "/control/env/$app";

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/control/api/core/$app/.gitkeep";
            $item->generatePath = "/control/api/core/$app";

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/cnweb/$app/.gitkeep";
            $item->generatePath = "/cnweb/$app";

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/former/$app/.gitkeep";
            $item->generatePath = "/former/$app";

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/models/$app/.gitkeep";
            $item->generatePath = "/models/$app";

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/layouts/$app/.gitkeep";
            $item->generatePath = "/layouts/$app";

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/inserts/$app/.gitkeep";
            $item->generatePath = "/inserts/$app";

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/project/$app/.gitkeep";
            $item->generatePath = "/project/$app";

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/service/App/$app/Test.php";
            $item->generatePath = "/service/App/$app";

            $item->template = "Test.php";
            $item->templatePath = "/service/App/Azk/";
            $item->replace = [
                'Azk' => $app,
            ];

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $class = ucfirst($app);
            $item->generate = "/service/App/ALL/$class.php"; //"/service/App/ALL/$app.php", // register new service in ALL/App.php as property
            $item->generatePath = "/service/App/ALL";

            $item->templatePath = "/service/App/ALL/";
            $item->replace = [
                'ZApp' => $app,
                'Azk' => $class,
            ];

            $item->affectFileOnly = true;

            // init with cruds/norms/service --class=App

            return $item;
        };

        $items[] = function (ZAppItem $item) use ($app) {

            $item->generate = "/webhtm/$app/.gitkeep";
            $item->generatePath = "/webhtm/$app";

            return $item;
        };

        foreach ($items as $item) {
            $this->data[] = $item(new ZAppItem());
        }
    }

    private function generatePath()
    {

    }

    private function move($app, $delete = false, $useTheSamePath = false, $pathToCopy = null)
    {
        $boot = new \Boot();
        foreach ($this->data as $n => $data) {

            $path = $this->rootDir;

            if (!empty($pathToCopy))
                $destination = $pathToCopy;
            else {
                if ($useTheSamePath)
                    $destination = '';
                else $destination = Root . $data->trashPath;
            }
            $destination .= '\\' . $app;

            $p = 0;

            if ($data->affectFileOnly) {

                $pathToMove = $destination . $data->generatePath;
                $boot->mkdir($pathToMove);

                $path .= $data->generate;
                $destination .= $data->generate;
                $c = 0;
                copy($path, $destination);

                if ($delete)
                    ZFileHelper::unlink($path);

            } else {
                $path .= $data->generatePath;
                $destination .= $data->generatePath;
                ZFileHelper::copyDirectory($path, $destination);

                if ($delete)
                    ZFileHelper::removeDir($path);

            }

            Az::debug($n, '$n');
            $p = 1;
            //$file = $this->rootDir . $data->generate;

        }
    }

    #endregion


    #region Create

    public function create($app, $appN = null)
    {

        if (strlen($app) > 5) vdd('App name must be less than 5 chars');

        $boot = new \Boot();

        $boot->eol(1);
        $boot->echo('Adding Project: ' . $app);

        $this->load($app); // fills this->datas array

        foreach ($this->data as $n => $data) {

            $path = $this->rootDir . $data->generatePath;
            $file = $this->rootDir . $data->generate;

            $content = '';
            if (!empty($data->templatePath)) {

                $content = file_get_contents($this->rootDir . $data->templatePath . $data->template);

                if (!empty($data->replace)) {
                    $content = strtr($content, $data->replace);
                }
            }


            $t = 1;
            if (!is_dir($path))
                $boot->mkdir($path);

            file_put_contents($file, $content);
        }

        // updating /service/ALL/App.php and
        // launch norms
        Az::$app->smart->norms->serviceAdd($app);

        // updating /scripts/initer/App.txt
        $appTxt = $this->rootDir . '/scripts/initer/App.txt';
        file_put_contents($appTxt, "$app\r\n", FILE_APPEND);
    }

    #endregion


    #region Remove

    public function remove($app)
    {
        $this->load($app);

        if (strlen($app) > 5) vdd('App name must be less than 5 chars');

        $boot = new \Boot();
        $boot->eol(1);
        $boot->echo('Removing Project: ' . $app);

        $this->move($app, true,);

        Az::$app->smart->norms->serviceRemove($app);

        // updating /scripts/initer/App.txt
        $appTxt = $this->rootDir . '/scripts/initer/App.txt';
        $appNames = Az::$app->utility->file->readByLine($appTxt);
        $appNames = Az::$app->utility->file->removeString($app, $appNames, true, true);
        Az::$app->utility->file->arrToFile($appTxt, $appNames);
    }

    #endregion


    #region Clone

    private function appCopy($app, $newApp)
    {

    }

    public function clone($app, $newApp)
    {
        $this->load($app);
        $this->appCopy($app, $newApp);

        // updating /service/ALL/App.php and
        // launch norms
        Az::$app->smart->norms->serviceAdd($newApp);

        // updating /scripts/initer/App.txt
        $appTxt = $this->rootDir . '/scripts/initer/App.txt';
        file_put_contents($appTxt, "$app\r\n", FILE_APPEND);
    }

    #endregion


    #region Extract

    public function extract($app, $destination)
    {

    }

    #endregion

    #region Test
//    public function test()
//    {
////        $this->load($app);
//        $this->testCreate();
//        //$this->testClone();
//        // $this->testRemove();
//    }


    public function testCreate()
    {
        Az::debug('checking created files', ' Process: ');

        foreach ($this->data as $n => $item) {

            $file = $this->rootDir . $item->generate;
            $fileExists = file_exists($file);

            if ($fileExists)
                Az::debug($file, $n . ' Ok ');
            else
                Az::warning($file, $n . ' Not found ');
        }
        //$this->testCreateApp();
    }

    private function testCreateApp()
    {

    }


    public function testRemove()
    {
        $this->testRemoveApp('test');
    }


    public function testClone()
    {
        $this->testCloneApp('test');
    }


    #endregion
}
