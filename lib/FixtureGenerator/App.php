<?php

namespace FixtureGenerator;

require_once('Interfaces.php');

defined('SYSTEM_PATH') or define('SYSTEM_PATH', dirname(__DIR__));

class App
{
    /**
     * @var App
     */
    private static $_app;

    private $_options = array();

    protected $_basePath,
        $_configPath = 'config',
        $_fixturePath = 'fixture',
        $_sourcePath = 'source';

    public static function instance()
    {
        return self::$_app;
    }

    public static function createApp($options = array())
    {
        if (!self::$_app)
            self::$_app = new self($options);
        else
            throw new Exception('Application can only be created once.');
        return self::instance();
    }

    protected function __construct($options)
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    public function getBasePath()
    {
        return $this->_basePath;
    }

    public function setBasePath($path)
    {
        if (($this->_basePath = realpath($path)) === false || !is_dir($this->_basePath))
            throw new Exception("Application base path '$path' is not a valid directory.");
    }

    public function setSourcePath($path)
    {
        $this->_sourcePath = $path;
        if ((realpath($this->getSourcePath())) === false || !is_dir($this->getSourcePath()))
            throw new Exception("Application source path '$path' is not a valid path.");
    }

    public function setConfigPath($path)
    {
        $this->_configPath = $path;
        if ((realpath($this->getConfigPath())) === false || !is_dir($this->getConfigPath()))
            throw new Exception("Application config path '$path' is not a valid path.");
    }

    public function getConfigPath()
    {
        return $this->_basePath . DIRECTORY_SEPARATOR . $this->_configPath;
    }

    public function getFixturePath()
    {
        return $this->_basePath . DIRECTORY_SEPARATOR . $this->_fixturePath;
    }

    public function getSourcePath()
    {
        return $this->_basePath . DIRECTORY_SEPARATOR . $this->_sourcePath;
    }

    public function run()
    {
        if (!isset($this->_options['database']) || isset($this->_options['help']))
            exit($this->getHelp());
        if (isset($this->_options['basePath']))
            $basePath = $this->_options['basePath'];
        else
            $basePath = SYSTEM_PATH . DIRECTORY_SEPARATOR . '/..';
        $this->setBasePath($basePath);
        $configFile = $this->getConfigPath() . DIRECTORY_SEPARATOR . $this->_options['database'] . '.php';
        if (!file_exists($configFile))
            throw new \Exception("Config file for table {$this->_options['database']} doesn't exist in $configFile.");
        $this->_options['tables'] = include_once($configFile);
        /** @var $class DbGenerator */
        if (!isset($this->_options['class']))
            $this->_options['class'] = '\FixtureGenerator\DbGenerator';
        $database = $this->_options['database'];
        unset($this->_options['database']);
        $class = Factory::create($database, $this->_options);
        $class->generate();
        $class->export();
        echo "all done...\n";
    }

    public function init($options = array())
    {
        $this->initCliOptions();
        $this->_options = array_merge($this->_options, $options);

    }

    public function initCliOptions()
    {
        if (!$this->_options) {
            $longopts = array(
                'd:' => 'database:',
                'h' => 'help'
            );
            $options = getopt(
                join('', array_keys($longopts)),
                $longopts
            );
            $opts = array();
            foreach ($longopts as $k => $v) {
                $opts[rtrim($k, ':')] = rtrim($v, ':');
            }
            if ($options)
                foreach ($options as $key => $value) {
                    if (strlen($key) == 1)
                        $this->_options[$opts[$key]] = $value;
                    else
                        $this->_options[$key] = $value;
                }
        }
        return $this->_options;
    }

    public static function autoload($className)
    {
        $path = str_replace('\\', '/', $className);
        include_once(SYSTEM_PATH . DIRECTORY_SEPARATOR . $path . '.php');
    }

    public function getHelp()
    {
        return <<<TEXT
Fixture Generator v1.0
Please, report bugs on jiminy96@gmail.com

Usage: generator [options]

\t -h, --help     \t\t display this help
\t -d, --database \t\t database name

\t -p, --path     \t\t base path, default to "/fixture/generator/path/../../"
\t -c, --config   \t\t config path, default to "config"
\t -f, --fixture  \t\t fixture path, default to "fixture"
\t -s, --source   \t\t source path, default to "source"
\t

TEXT;
    }
}
