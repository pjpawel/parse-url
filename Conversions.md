# List of conversion
|Uri|parse_url() output|Our output|
|---|---|---|
|file://var/log|false|scheme:'file', path: '/var/log'|
|file:/var/log|false|scheme:'file', path: '/var/log'|
|file:var/log|false|scheme:'file', path: '/var/log'|
|www.abc.com|path: 'www.abc.pl'|host: 'www.abc.com'|
|abc.com|path: 'www.abc.pl'|host: 'abc.com'|
