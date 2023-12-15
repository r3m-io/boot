{{R3M}}
### Setup
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
{{$output = execute($command , 'notification')}}
{{if(is.array($output))}}
{{implode("\n", $output)}}

{{/if}}

{{if(!is.empty($notification))}}
- {{$notification}}

{{/if}}
{{else}}
- Skipping {{$package}} installation
{{/if}}
{{/for.each}}
{{/if}}