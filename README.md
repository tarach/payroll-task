# Installation
```
./bin/console doctrine:database:create \
&& ./bin/console --no-interaction doctrine:migration:migrate \
&& ./bin/console --no-interaction doctrine:fixtures:load
```

# Run tests
```
./bin/phpunit
```