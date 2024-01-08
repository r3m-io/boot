<?php
namespace Package\R3m\Io\Boot\Trait;

use R3m\Io\App;

use R3m\Io\Config;
use R3m\Io\Module\Core;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;

use R3m\Io\Node\Model\Node;

use Exception;

use R3m\Io\Exception\FileWriteException;
use R3m\Io\Exception\ObjectException;

trait Init {

    /**
     * @throws ObjectException
     * @throws FileWriteException
     * @throws Exception
     */
    public function installation (): void
    {
        Core::interactive();
        $object = $this->object();
        $options = App::options($object);
        $url_package = $object->config('project.dir.vendor') . 'r3m_io/boot/Data/Package.json';
        $class = File::basename($url_package, $object->config('extension.json'));
        $packages = $object->data_read($url_package);
        $node = new Node($object);
        $is_install = false;
        if($packages){
            foreach($packages->data($class) as $nr => $package){
                $record_options = [
                    'where' => [
                        [
                            'value' => $package,
                            'attribute' => 'name',
                            'operator' => '===',
                        ]
                    ],
                    'process' => true
                ];
                $response = $node->record(
                    'System.Installation',
                    $node->role_system(),
                    $record_options
                );
                $command_options = [];
                foreach($options as $option => $value){
                    if($value === false){
                        $command_options[] = '-' . $option . '=false';
                    }
                    elseif($value === true){
                        $command_options[] = '-' . $option . '=true';
                    }
                    elseif($value === null){
                        $command_options[] = '-' . $option . '=null';
                    }
                    elseif(is_numeric($value)){
                        $command_options[] = '-' . $option . '=' . $value;
                    } else {
                        $command_options[] = '-' . $option . '=\'' . $value . '\'';
                    }
                }
                if(property_exists($options, 'force')){
                    $command = Core::binary($object) . ' install ' . $package;
                    if(!empty($command_options)){
                        $command = $command . ' ' . implode(' ', $command_options);
                    }
                    Core::execute($object, $command, $output, $notification);
                    if(!empty($output)){
                        echo rtrim($output, PHP_EOL) . PHP_EOL;
                    }
                    if(!empty($notification)){
                        echo rtrim($notification, PHP_EOL) . PHP_EOL;
                    }
                    $is_install = true;
                }
                elseif(!$response){
                    $command = Core::binary($object) . ' install ' . $package;
                    if(!empty($command_options)){
                        $command = $command . ' ' . implode(' ', $command_options);
                    }
                    Core::execute($object, $command, $output, $notification);
                    if(!empty($output)){
                        echo rtrim($output, PHP_EOL) . PHP_EOL;
                    }
                    if(!empty($notification)){
                        echo rtrim($notification, PHP_EOL) . PHP_EOL;
                    }
                    $is_install = true;
                } else {
                    echo 'Skipping ' . $package . ' installation...' . PHP_EOL;
                }
            }
        }
        if($is_install){
//            Config::configure($object);
            $environment = $object->config('framework.environment');
            d($environment);
            if(empty($environment)) {
                $environment = Config::MODE_DEVELOPMENT;
            }
            switch($environment){
                case Config::MODE_DEVELOPMENT:
                    $command = Core::binary($object) . ' r3m_io/config framework environment '. $environment . ' -enable-file-permission';
                    Core::execute($object, $command, $output, $notification);
                    if(!empty($output)){
                        echo rtrim($output, PHP_EOL) . PHP_EOL;
                    }
                    if(!empty($notification)){
                        echo rtrim($notification, PHP_EOL) . PHP_EOL;
                    }
                    break;
                default:
                    $command = Core::binary($object) . ' r3m_io/config framework environment '. $environment;
                    Core::execute($object, $command, $output, $notification);
                    if(!empty($output)){
                        echo rtrim($output, PHP_EOL) . PHP_EOL;
                    }
                    if(!empty($notification)){
                        echo rtrim($notification, PHP_EOL) . PHP_EOL;
                    }
                    break;
            }
        }
    }
}