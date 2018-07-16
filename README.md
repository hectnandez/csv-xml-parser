# Parser csv-xml
Simple php console application to parse csv files data into XML with a possibility to declare privates fields through a 
config.json file.

## Install application
1. Clone the reposotiry:
    ```
    git clone https://github.com/hectnandez/csv-xml-parser.git
    ```
2. Go to the root directory of the proyect and install composer dependencies:
    ```
    composer install
    ```
    
## How to use?
Open your console, go to the root directory of the proyect and type:
```
php console csv-xml:parse -f dirToYour.csv
```
When -f if the complete path of your .csv file to parse .


###### Template of the sites.json configuration file
```
{
    "private_fields": [
      "email",
      "address",
      "phone"
    ]
}
```