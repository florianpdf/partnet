P@rtnet'emploi du Perche
======================


Installation :
-----------------
En clonant le projet :

    $ git clone https://github.com/WildCodeSchool/partnet.git
    $ cd partnet
    $ git checkout develop
    $ composer install
    $ php app/console doctrine:database:create
    $ php app/console doctrine:schema:update
    $ php app/console doctrine:fixtures:load
    $ sudo sh bash/chmod.sh
    $ sudo npm install
    $ grunt


----------
Indispensables :
----------------------
PHP Composer :
[- Installation sous Linux](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

Node JS : (pour le fonctionnement de Grunt)
[- Installation sous Ubuntu ](http://doc.ubuntu-fr.org/nodejs)




