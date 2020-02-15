<?php 
class Config {
    /**
     * Database config
     */
    const DB_DSN = 'mysql:host=127.0.0.1;dbname=tickets_appels;charset=latin1';
    const DB_USER = '';
    const DB_PASS = '';
   
    const TEMPLATE_DIR = BASE_DIR .'/../templates';
    const TMP_PATH = BASE_DIR . '/../tmp';
    const CSV_SEPARATOR = ';';
    
    /**
    * in case you setup the application outside the docroot
    * eg: if your access it like: http://localhost/path/to/
    * then the value should be : path/to
    */
    const APP_BASEPATH = '';
}