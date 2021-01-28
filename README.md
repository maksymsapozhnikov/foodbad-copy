# FoodBud
The home for find food near you.

# Installation
1. Clone the project from the Git repository;
2. Run command "composer install";
3. Run "php init" command;
4. Add configuration data for connecting to the database in the file "common/config/main-local.php"
5. Run command "php yii migrate";

# Getting data from Diggernaut Api
Run the command "php yii diggernaut/get-data"
Run the command "php yii diggernaut/create-restaurant"
After executing the script, run next command "php yii diggernaut/categories-init"