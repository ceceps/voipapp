# CRM VOIP

Mini CRM App that emulated VOIP State
Create with Laravel 12 as API Server,and Vue 2 as Frontend also using MySQL  

## Instalation 
## Without Docker

### Install Backend
```
cd backend
composer install 
cp .env.example .env 
```
Configure Connection MySQL on your machine, then run: 

```
php artisan migrate --seed
```
Run Serve

```
php artisan serve
```

### Install Frontend 

run command at root project 
```
cd frontend
pnpm install 
pnpm serve
```
Run Web Application on Browser

```
http://localhost:8080

```
### Test URL

```
/contacts
/call-logs
```