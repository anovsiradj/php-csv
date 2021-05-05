# PHP CSV Library

## Help/Debug/Development

/tests/states.csv
https://gist.github.com/VictorDu/fbd642275a936c99c90c

## Todos

1. Generator callback, for manipulating output data. (example something like):

```php
foreach($csv->stream(N,N, 'myCallbackFn') as $n) {
}
```
