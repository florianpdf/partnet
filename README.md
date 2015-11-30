P@rtnet'emploi du Perche
======================


Installation en clonant le projet :
-----------------
Installation auto :

    $ git clone https://github.com/WildCodeSchool/partnet.git
    $ cd partnet
    $ sh install

Installation manuelle :

    $ git clone https://github.com/WildCodeSchool/partnet.git
    $ cd partnet
    $ git checkout develop
    $ composer install
    $ php app/console doctrine:database:create
    $ php app/console doctrine:schema:update --force
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




