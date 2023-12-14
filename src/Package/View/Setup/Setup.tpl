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
{{$response|json.encode:'JSON_PRETTY_PRINT'}}


- record system.Installation where -name=r3m_io/node
- found then skip or add force