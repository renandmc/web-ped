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
    <a href="https://laravel.com" target="_blank" title="Laravel 8">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" height="50">
    </a>
    <a href="https://getbootstrap.com/" target="_blank" title="Bootstrap">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b2/Bootstrap_logo.svg" height="50">
    </a>
</p>

## Instalação

Necessário: 

PHP versão 7.3 ou superior

MySQL/MariaDB

NodeJS

- Clonar projeto, acessar pasta e abrir VS Code na pasta
```
git clone https://github.com/renandmc/web-ped.git

cd web-ped

code .
```
- Instalar dependências do projeto
```
composer install

npm install
```
- Criar banco de dados e alterar configuração arquivo .env (DB_DATABASE)
```
cp .env.example .env
```
- Criar tabelas do banco (migrations)
```
php artisan migrate
```
- Criar chave do aplicativo (Utilizada para funções internas de segurança)
```
php artisan key:generate
```
- Rodar projeto
```
php artisan serve
```
- Acessar URL http://localhost:8000
