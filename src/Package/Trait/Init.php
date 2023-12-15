<?php
namespace Package\R3m\Io\Boot\Trait;

use R3m\Io\Module\Core;
use R3m\Io\Module\File;

use R3m\Io\Node\Model\Node;
trait Init {

    public function installation (): void
    {
        $object = $this->object();
        $url_package = $object->config('project.dir.vendor') . 'r3m_io/boot/Data/Package.json';
        $class = File::basename($url_package, $object->config('extension.json'));
        $packages = $object->data_read($url_package);
        $node = new Node($object);
        if($packages){
            foreach($packages->data($class) as $nr => $package){
                $options = [
                    'where' => 'name === "' . $package  . '"'
                ];
                $response = $node->record(
                    'System.Installation',
                    $node->role_system(),
                    $options
                );
                if(!$response){
                    $command = Core::binary($object) . ' install ' . $package;
                    Core::execute($object, $command);
                } else {
                    echo 'Skipping ' . $package . ' installation...' . PHP_EOL;
                }
            }
        }
    }
}