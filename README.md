# WEB-PED - Sistema para tiragem de pedidos online

Sistema desenvolvido para TCC do curso de Análise e Desenvolvimento de sistemas da <a href="https://www.fatecourinhos.edu.br/" target="_blank">Fatec Ourinhos</a>

## Desenvolvido por:

<table>    
    <tr>
        <td>
            <a href="https://github.com/mmb97" target="_blank">
                <img src="https://avatars.githubusercontent.com/u/78830257" height="100" />
            </a>
            <br />
            Marlon
        </td>
        <td>
            <a href="https://github.com/renandmc" target="_blank">
                <img src="https://avatars.githubusercontent.com/u/4171539" height="100" />
            </a>
            <br />
            Renan
        </td>
    </tr>
</table>

## Desenvolvido com:

<p>
    <a href="https://laravel.com" target="_blank" title="Laravel 12">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" height="50">
    </a>
    <a href="https://getbootstrap.com/" target="_blank" title="Bootstrap">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b2/Bootstrap_logo.svg" height="50">
    </a>
</p>

Laravel 12, PHP 8.3, MariaDB/MySQL, AdminLTE, Bootstrap 4 e Vite.

## Executando o projeto

Há duas formas de executar: com **Docker (Laravel Sail)**, que já traz PHP, banco e Node, ou **localmente**, instalando as ferramentas na sua máquina.

### Opção 1: Docker (Laravel Sail)

Necessário: [Docker](https://www.docker.com/) com Docker Compose. No Windows, use o Docker Desktop com WSL 2 e execute os comandos dentro do WSL (o projeto fica muito mais rápido dentro do sistema de arquivos do WSL do que em `C:\`).

1. Clonar o projeto
```
git clone https://github.com/renandmc/web-ped.git

cd web-ped
```
2. Criar o arquivo de configuração
```
cp .env.example .env
```
3. Ajustar o banco no `.env` para o container (o serviço do banco se chama `mariadb`) e definir uma senha
```
DB_HOST=mariadb
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```
4. Instalar as dependências PHP. Como o `vendor/` ainda não existe, use um container temporário do Composer
```
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html composer:latest composer install --ignore-platform-reqs
```
5. Subir os containers (a primeira vez demora, pois constrói a imagem)
```
WWWUSER=$(id -u) WWWGROUP=$(id -g) docker compose up -d
```
6. Gerar a chave do aplicativo e criar as tabelas com dados de exemplo
```
docker compose exec laravel.test php artisan key:generate

docker compose exec laravel.test php artisan migrate --seed
```
7. Instalar as dependências JavaScript e gerar os assets
```
docker compose exec laravel.test npm install

docker compose exec laravel.test npm run build
```
8. Acessar http://localhost

Para parar os containers: `docker compose down`.

### Opção 2: Local

Necessário:

- PHP 8.2 ou superior (recomendado 8.3), com as extensões usuais do Laravel (`mbstring`, `xml`, `curl`, `pdo_mysql`, `zip`, `bcmath`)
- [Composer](https://getcomposer.org/)
- MySQL ou MariaDB
- Node.js 20.19 ou superior (ou 22.12+) e npm

1. Clonar o projeto
```
git clone https://github.com/renandmc/web-ped.git

cd web-ped
```
2. Instalar as dependências
```
composer install

npm install
```
3. Criar o arquivo de configuração e a chave do aplicativo
```
cp .env.example .env

php artisan key:generate
```
4. Criar um banco de dados vazio e ajustar no `.env` as variáveis `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`
5. Criar as tabelas e os dados de exemplo
```
php artisan migrate --seed
```
6. Gerar os assets (ou usar `npm run dev` para recarregar automaticamente durante o desenvolvimento)
```
npm run build
```
7. Rodar o projeto
```
php artisan serve
```
8. Acessar http://localhost:8000

### Usuário de exemplo

O seeder cria um usuário administrador. Os dados vêm das variáveis `SEED_USER_NAME`, `SEED_USER_EMAIL` e `SEED_USER_PASSWORD` do `.env` (por padrão `admin@example.com` / `password`). Altere-as antes de rodar o `migrate --seed` e **não use esses valores em produção**.

## Testes

Os testes usam um banco separado chamado `testing`, para nunca apagar os dados do banco de desenvolvimento.

- Com Sail, esse banco já é criado automaticamente pelo container do MariaDB.
- Localmente, crie um banco vazio chamado `testing` no mesmo servidor configurado no `.env`.

```
php artisan test
```

Com Sail: `docker compose exec laravel.test php artisan test`

## Deploy

O deploy no Heroku é feito pelos workflows em `.github/workflows` (`master` e `develop`). O `heroku-postbuild` roda `npm run build`, que gera os assets do Vite em `public/build`.
