# on 20.06.2021 is hosted http://rupro.tw1.ru,  be planned run onto HelioHost 

1. composer install

2. which mysql && mysql --user="root" --password="password" --host="localhost" "NAME_OF_BASE" < "install.sql"

3. apache cfg

       <VirtualHost *:80>
           DocumentRoot "/full_path/mvc_taskmanage/public"
           ServerName mvc_taskmanage

         <Directory /full_path/mvc_taskmanage/public>
           RewriteEngine On
           RewriteBase /
           RewriteCond %{REQUEST_FILENAME} !-d
           RewriteCond %{REQUEST_FILENAME} !-f
           RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
         </Directory>
       </VirtualHost>
 
 4. (!vds?) ln -s ~/имя_директории/public ~/имя_директории/public_html
