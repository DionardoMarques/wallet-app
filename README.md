# Rodando o projeto
Pré-requisitos: [Docker Desktop](https://www.docker.com/products/docker-desktop/)

> Este passo a passo leva em consideração comandos Linux.

1. Clonar este repositório:
   
   ```bash
   git clone https://github.com/DionardoMarques/wallet-app
   ```
2. Acessar o diretório:
   
   ```bash
   seu_diretorio/wallet-app
   ```
3. Criar a pasta `vendor` e instalar as dependências necessárias via Docker container:

   ```bash
   docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
   ```
4. Copiar o arquivo `.env.example` para `.env`:

   ```bash
   cp .env.example .env
   ```
5. Rodar o container utilizando o `Laravel Sail`:
   
   ```bash
   ./vendor/bin/sail up -d
   ```
6. Gerar a chave da aplicação `Laravel`:

   ```bash
   ./vendor/bin/sail artisan key:generate
   ```
# Criando e alimentando o banco de dados
Ainda dentro do diretório do projeto, por exemplo: `seu_diretorio/wallet-app`

1. Rodar as migrations:

   ```bash
   ./vendor/bin/sail artisan migrate
   ```
2. Rodar as seeds:

   ```bash
   ./vendor/bin/sail artisan db:seed
   ```
# Documentação API
Após estar com o projeto rodando, é possível acessar o Swagger para a realização de requisições aos endpoints.

[Endpoints wallet-app](http://localhost/api/documentation)
