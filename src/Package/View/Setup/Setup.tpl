{{R3M}}
### Setup BootX2
{{d(request())}}
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