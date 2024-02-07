# Matcha

Dating website using PHP.

## 1. Install

```sh
# build Docker containers
make build

# install dependencies
make install

```

## 2. Use

```sh
make run
```

## 3. Logs

```sh
make logs
```

## 4. Stop

```sh
make stop
```

## 5. docker-machine

```sh
docker-machine create Matcha
eval $(docker-machine env Matcha)
make re
```
