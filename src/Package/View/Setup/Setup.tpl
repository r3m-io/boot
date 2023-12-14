{{R3M}}
### Setup
{{$installation = 'System.Installation'}}

{{$packages = array.read(config('project.dir.vendor') + 'r3m_io/boot/Data/Package.json' )}}
{{if(!is.empty($packages))}}
{{for.each($packages as $package)}}
{{$options = [
    'where' => 'name === ' + $package.name
]}}
{{$response = R3m.Io.Node:Data:record(
$installation,
R3m.Io.Node:Role:role_system(),
$options
)}}
{{if(is.empty($response))}}
{{$output = execute(binary() + ' install ' + $package)}}
{{$output}}
{{else}}
- Skipping {{$package}} installation

{{/if}}
{{/for.each}}
{{/if}}