<?php

namespace FW\Command\Argv;

class Make {

    private static $argv;
    private static $helper;
    private static $docRoot;

    public static function init($helper, $argv, $docRoot) {
        self::$argv = $argv;
        self::$helper = $helper;
        self::$docRoot = rtrim($docRoot, '/');
    }

    public static function run() {
        $rawArgv = isset(self::$argv[1]) ? explode(":", self::$argv[1]) : false;

        if ($rawArgv) {
            switch ($rawArgv[1]) {
                case "controller":
                    self::makeController();
                    break;
                case "model":
                    self::makeModel();
                    break;
                case "middleware":
                    self::makeMiddleware();
                    break;
                case "service":
                    self::makeService();
                    break;
                default:
                    self::showError("Unrecognized 'make:?' command. Please check the syntax.");
            }
        } else {
            self::showError("Unrecognized 'make:?' command. Please check the syntax.");
        }
    }

    private static function showError($message) {
        self::$helper::label("Error")
            ->font("red", "", "bold")
            ->exec($message);
        exit();
    }

    private static function makeController() {
        self::makeFile("controller", "Controllers", "Controller", "DefaultController.txt");
    }

    private static function makeModel() {
        self::makeFile("model", "Models", "Model", "DefaultModel.txt");
    }

    private static function makeMiddleware() {
        self::makeFile("middleware", "Middlewares", "Middleware", "DefaultMiddleware.txt");
    }

    private static function makeService() {
        self::makeFile("service", "Services", "Service", "DefaultService.txt");
    }

    private static function makeFile($type, $folder, $suffix, $templateFile) {
        $name = self::$argv[2] ?? null;
        if (empty($name)) {
            self::showError(ucfirst($type) . " name is required.");
        }

        $location = self::buildLocation($folder);
        $className = ucwords($name);
        $filePath = "{$location}/{$className}.php";
        
        self::$helper::label("Make:$suffix")
            ->font("blue", "", "bold")
            ->exec("Creating directory '$location' for $suffix '$className'.");

        self::createDirectory($location, "Make:$suffix");
        self::createFileFromTemplate($filePath, $templateFile, $location, $className, "Make:$suffix");
    }

    private static function buildLocation($folder) {
        $subPath = self::$argv[3] ?? "";
        return self::$docRoot . "/app/$folder" . self::formattedLocation($subPath);
    }

    private static function createFileFromTemplate($filePath, $templateFile, $location, $className, $command) {
        if (!file_exists($filePath)) {
            $template = file_get_contents(self::$docRoot . "/system/Template/$templateFile");
            $template = str_replace("[__namespace__]", self::getNamespace($location), $template);
            $template = str_replace("[__classname__]", $className, $template);
            file_put_contents($filePath, $template);
            self::$helper::label($command)
                ->font("green", "", "bold")
                ->exec("Successfully created file '$filePath'.");
        } else {
            self::$helper::label($command)
                ->font("yellow", "", "bold")
                ->exec("File '$filePath' already exists.");
        }
    }

    private static function createDirectory($location, $command) {
        if (!is_dir($location) && mkdir($location, 0777, true)) {
            self::$helper::label($command)
                ->font("green", "", "bold")
                ->exec("Successfully created directory '$location'.");
        }
    }

    private static function formattedLocation($location) {
        return str_replace("/", DIRECTORY_SEPARATOR, "/". trim($location, "/"));
    }

    private static function getNamespace($location) {
        $namespace = str_replace([self::$docRoot . "/app/", DIRECTORY_SEPARATOR], ["", "\\"], $location);
        return rtrim("FW\\App\\" . $namespace, "\\");
    }
    
}
