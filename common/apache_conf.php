<VirtualHost *:80>
    ServerName blog.com
    DocumentRoot "/var/www/html/advanced/frontend/web/"

    <Directory "/var/www/html/advanced/frontend/web/">
    # use mod_rewrite for pretty URL support
    RewriteEngine on
    # If a directory or a file exists, use the request directly
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    # Otherwise forward the request to index.php
    RewriteRule . index.php

    # use index.php as index file
    DirectoryIndex index.php

    # ...other settings...
    # Apache 2.4
    Require all granted

    ## Apache 2.2
    # Order allow,deny
    # Allow from all
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    ServerName admin.blog.com
    DocumentRoot "/var/www/html/advanced/backend/web/"

    <Directory "/var/www/html/advanced/backend/web/">
    # use mod_rewrite for pretty URL support
    RewriteEngine on
    # If a directory or a file exists, use the request directly
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    # Otherwise forward the request to index.php
    RewriteRule . index.php

    # use index.php as index file
    DirectoryIndex index.php

    # ...other settings...
    # Apache 2.4
    Require all granted

    ## Apache 2.2
    # Order allow,deny
    # Allow from all
    </Directory>
</VirtualHost>