<?php

    namespace FW\Command;

    use FW\Command\Helper;
    use FW\Command\Argv\Serve;
    use FW\Command\Argv\Build;
    use FW\Command\Argv\Make;
    use FW\Command\Argv\Help;

    require "Helper.php";
    require "Argv/Serve.php";
    require "Argv/Build.php";
    require "Argv/Make.php";
    require "Argv/Help.php";

    /**
     * Class Execution
     */
    class Execution {

        public static function run($argc, $argv) {
            $docRoot = str_replace("\\", "/", dirname(__DIR__, 2));

            if ($argc > 1) {
                switch ($argv[1]) {
                    case "serve":
                        Serve::run(Helper::class, $docRoot);
                        break;
                    case "build":
                        Build::run(Helper::class, "build", $docRoot);
                        break;
                    case "update":
                        Build::run(Helper::class, "update", $docRoot);
                        break;
                    case "help":
                        Help::run(Helper::class, $docRoot);
                        break;
                    default:
                            if (strpos($argv[1], "make") === 0) {
                                Make::init(Helper::class, $argv, $docRoot);
                                Make::run();
                            } else {
                                Helper::label("Error")
                                    ->font("red", "", "bold")
                                    ->exec("Cannot find command: '" . htmlspecialchars($argv[1]) . "'.");
                            }
                        break;
                }
            } else {
                Helper::label("Error")
                    ->font("red", "", "bold")
                    ->exec("Cannot find command.");
            }
        }

    }
