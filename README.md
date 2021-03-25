# Installation
```
./bin/console doctrine:database:create \
&& ./bin/console --no-interaction doctrine:migration:migrate \
&& ./bin/console --no-interaction doctrine:fixtures:load
```

# Running command
```
./bin/console payroll:report
```
![image](https://user-images.githubusercontent.com/351514/112408761-ac09ff80-8d18-11eb-9d97-35f8c875a954.png)
![image](https://user-images.githubusercontent.com/351514/112408700-909ef480-8d18-11eb-83da-5de6fc412646.png)

# Run tests
```
./bin/phpunit
```
