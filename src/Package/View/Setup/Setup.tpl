{{R3M}}
### Setup
{{$class = 'System.Installation'}}
{{$options = [
    'where' => 'name === r3m_io/node'
]}}
{{$response = R3m.Io.Node:Data:record(
$class,
R3m.Io.Node:Role:role_system(),
$options
)}}
{{if(is.empty($response))}}
{{$output = execute(binary() + ' install r3m_io/node')}}
{{$output}}
{{else}}
- Skipping r3m_io/node installation
{{/if}}