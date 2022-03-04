# Local setup

### 1.Build images and start containers

```
docker-compose up -d --build
```
or
```
make start
```

### 2.Run migrations
```
docker-compose exec php bin/console doctrine:migrations:migrate
```
or
```
make migrate
```

### 3.Load fixtures
```
docker-compose exec php bin/console doctrine:fixtures:load
```
or
```
make fixture
```


### Need running cron once a day on route /rate/add 