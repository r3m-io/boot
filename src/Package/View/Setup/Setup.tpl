{{R3M}}
### Setup
{{$installation = 'System.Installation'}}

{{$packages = array.read(config('project.dir.vendor') + 'r3m_io/boot/Data/Package.json' )}}
{{if(!is.empty($packages))}}

{/if}
{{dd($packages)}}

{{$options = [
    'where' => 'name === r3m_io/node'
]}}
{{$response = R3m.Io.Node:Data:record(
$installation,
R3m.Io.Node:Role:role_system(),
$options
)}}
{{if(is.empty($response))}}
{{$output = execute(binary() + ' install r3m_io/node')}}
{{$output}}
{{else}}
- Skipping r3m_io/node installation
{{/if}}