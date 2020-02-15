## Prerequisite

It is supposed that you've already have :
- LAMP server
- User with db creation in Mysql

## Setup
A few steps to setup this challange: 

1- Clone the repository

```
cd %{DOC_ROOT}% && git clone https://github.com/daheda/gac.git && cd gac
```

2- Import the data structure
```
mysql -u%{DB_USER}% -p < ./data/init.sql
```

## Configuration

Before runing the application, it might need to change values in './config/config.php'

## Credits
- https://www.php-fig.org/psr/psr-4/examples/
- https://getbootstrap.com/docs/4.4/examples/starter-template/


## Thank you