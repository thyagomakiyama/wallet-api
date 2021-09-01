# Wallet API

Projeto para colocar em prática aprendizados sobre arquitetura hexagonal e DDD.

O namespace Application representam os inbounds e Infrastructure representam os outbounds, Domain representa o Core Application.

## Configurar projeto localmente
```bash
git clone https://github.com/thyagomakiyama/wallet-api.git -- clonar repositório

cd wallet-api
cp -p .env.exemple .env

docker-compose up -d -- subir o banco de dados local

composer install -- instalar dependencias do projeto

php -S localhost:8000 -t public -- subir servidor local
```

## Testes
```bash
vendor/bin/phpunit
```
