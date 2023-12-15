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
                    'where' => [
                        [
                            'value' => $package,
                            'attribute' => 'name',
                            'operator' => '===',
                        ]
                    ]
                ];
                $response = $node->record(
                    'System.Installation',
                    $node->role_system(),
                    $options
                );
                d($package);
                d($response);
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