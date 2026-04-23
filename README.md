# Название вашего проекта: vik-crovlia-test

## 🚀 Быстрый старт

### Требования
- Установленные Docker и Docker Compose
- Git

### 1. Клонирование репозитория
\`\`\`bash
git clone https://github.com/KaidorS/vik-crovlia-test.git
cd vik-crovlia-test
\`\`\`

### 2. Настройка окружения
Скопируйте и настройте файл с переменными окружения:
\`\`\`bash
cp src/.env.example src/.env
\`\`\`

### 3. Запуск контейнеров
Соберите и запустите все сервисы:
\`\`\`bash
docker-compose up -d --build
\`\`\`

### 4. Установка зависимостей PHP (Composer)
\`\`\`bash
docker-compose exec php composer install
\`\`\`

### 5. Генерация ключа приложения
\`\`\`bash
docker-compose exec php php artisan key:generate
\`\`\`

### 6. Установка зависимостей Node.js и сборка фронтенда
\`\`\`bash
docker-compose exec php npm install
docker-compose exec php npm run build
\`\`\`

### 7. Миграция базы данных
\`\`\`bash
docker-compose exec php php artisan migrate
\`\`\`

## 🗄️ Доступ к сервисам после запуска
- **Сайт:** [http://localhost:83](http://localhost:83)
- **Админка Filament:** [http://localhost:83/admin](http://localhost:83/admin)
- **phpMyAdmin:** [http://localhost:8084](http://localhost:8084) (Сервер: `mysql`, Пользователь: `laravel`, Пароль: `secret`)

## 👤 Создание пользователя админки
\`\`\`bash
docker-compose exec php php artisan make:filament-user
\`\`\`





<br><br><br><br><br><br><br><br>
<h3>================== Черновик ===================</h4>
<p>Вместо bootstrap используется tailwind. Ниже черновой алгоритм развертывания</p>

1. docker-compose up -d
2. (добавить vendor + .env в src)
3. docker-compose exec php php artisan key:generate
4. docker-compose exec php composer require filament/filament:"^5.0"
5. docker-compose exec --user root php chown -R 33:33 /var/www/.npm (если папки нет создайте)
6. docker-compose exec php npm install
7. docker-compose exec php php artisan migrate --force
8. docker-compose exec php npm run dev


<h3>======= php =======</h3>
<p>
docker-compose exec php sh
$ cat /etc/os-release
PRETTY_NAME="Debian GNU/Linux 13 (trixie)"
NAME="Debian GNU/Linux"
VERSION_ID="13"
VERSION="13 (trixie)"
VERSION_CODENAME=trixie
DEBIAN_VERSION_FULL=13.4
ID=debian
HOME_URL="https://www.debian.org/"
SUPPORT_URL="https://www.debian.org/support"
BUG_REPORT_URL="https://bugs.debian.org/"
</p>

<h3>======= nginx =======</h3>
<p>
docker-compose exec nginx sh
/ # cat /etc/os-release
NAME="Alpine Linux"
ID=alpine
VERSION_ID=3.23.3
PRETTY_NAME="Alpine Linux v3.23"
HOME_URL="https://alpinelinux.org/"
BUG_REPORT_URL="https://gitlab.alpinelinux.org/alpine/aports/-/issues"
</p>

<h3>======= mysql  =======</h3>
<p>
docker-compose exec mysql bash
bash-5.1# cat /etc/os-release
NAME="Oracle Linux Server"
VERSION="9.7"
ID="ol"
ID_LIKE="fedora"
VARIANT="Server"
VARIANT_ID="server"
VERSION_ID="9.7"
PLATFORM_ID="platform:el9"
PRETTY_NAME="Oracle Linux Server 9.7"
ANSI_COLOR="0;31"
CPE_NAME="cpe:/o:oracle:linux:9:7:server"
HOME_URL="https://linux.oracle.com/"
BUG_REPORT_URL="https://github.com/oracle/oracle-linux"

ORACLE_BUGZILLA_PRODUCT="Oracle Linux 9"
ORACLE_BUGZILLA_PRODUCT_VERSION=9.7
ORACLE_SUPPORT_PRODUCT="Oracle Linux"
ORACLE_SUPPORT_PRODUCT_VERSION=9.7
</p>