Тестовая задача: создать REST API для учета кошек

* Про каждую кошку мы знаем кличку, пол и возраст(в годах). 
* Нужно чтобы была возможность добавлять, редактировать и удалять кошек из БД. 
* Нужна возможность фильтровать кошек по возрасту и полу. 
* У кошек периодически появляется потомство. 
* Необходимо иметь возможность указывать мать нового котенка и, в связи с особенностями поведения кошачьих, множество возможных отцов.

Дополнение:
1. Добавлена валидация пола матери и отца
2. Добавлена валидация возраста матери (Мать не должна быть младше котенка)
3. Нельзя удалить кота/кошку у которых есть потомство

Инструкция:
1. git clone https://github.com/aleks-shar/cats_on_laravel_12.git
2. docker run --rm \
   -u "$(id -u):$(id -g)" \
   -v "$(pwd):/var/www/html" \
   -w /var/www/html \
   laravelsail/php84-composer:latest \
   composer install --ignore-platform-reqs
3. cp .env.example .env
4. /vendor/bin/sail build --no-cache
5. /vendor/bin/sail up -d
6. /vendor/bin/sail artisan key:generate
7. /vendor/bin/sail artisan migrate
8. /vendor/bin/sail artisan db:seed --class=CatsSeeder
