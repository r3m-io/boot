<?php
namespace Package\R3m\Io\Boot\Trait;

use R3m\Io\Module\Core;
trait Init {

    public function installation (){
        $object = $this->object();
        $url_package = $object->config('project.dir.vendor') . 'r3m_io/boot/Data/Package.json';
        $packages = $object->data_read($url_package);
        ddd($packages);
        if($packages){
            foreach($packages as $nr => $package){
                $options = [
                    'where' => 'name === "' . $package  . '"'
                ];
                $response = $object->data_record(
                    'System.Installation',
                    $object->role_system(),
                    $options
                );
                if(!$response){
                    $command = Core::binary($object) . ' install ' . $package;
                    Core::execute($object, $command, $output);
                    d($output);
                }
            }
        }
    }

    /*
{{$installation = 'System.Installation'}}
{{$packages = array.read(config('project.dir.vendor') + 'r3m_io/boot/Data/Package.json' )}}
{{if(!is.empty($packages))}}
{{for.each($packages as $nr => $package)}}
{{$options = [
    'where' => 'name === "' + $package  + '"'
]}}
{{$response = R3m.Io.Node:Data:record(
$installation,
R3m.Io.Node:Role:role.system(),
$options
)}}
{{if(is.empty($response))}}
{{$command = binary() + ' install ' + $package}}
{{$command}}

- Installing {{$package}} ...

{{$output = execute($command)}}
{{if(is.array($output))}}
{{implode("\n", $output)}}
{{/if}}

{{else}}
- Skipping {{$package}} installation
{{/if}}
{{/for.each}}
{{/if}}
*/
}