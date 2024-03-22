# mrpeasy

# **PHP Developer Assignment**

## **Installation**

1. run `composer dump-autoload`
2. run `composer install`

## **Requirements**

1. PHP >v7.2
2. Sqlite3 - download the latest version https://www.sqlite.org/download.html

## **Tasks**


### **Parse Tags**

1. `cd mrpeasy`
2. run `./vendor/bin/phpunit --verbose console/tests` OR use ConsoleController


### **Last versions**

**Create one SQL query for selecting last versions of content**

1. `cd mrepasy/storage`
2. `cat MaxContentQuery.txt`


### **Counter web application**

Since no framework was specified I decided to build the core functionality
by myself and do not use libraries and frameworks for this web application.
######**Such approach advantages:**
1. No redundant functionality in the codebase
2. Challenge myself writing things from the scratch
######**Disadvantages:**
1. Time-consuming, using the framework thing would go several times faster.

1. `cd mrpeasy/public`
2. `php -S localhost:9999`
