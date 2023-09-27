## **MAGENTO CUSTOM COMMAND THAT IMPORTS DATA FROM FILE AND STORES IT IN DB**

* * *

##  **ETA: 24hrs(3 days)**

**We want you to write code that supports importing customers. The requirement is to import from a sample CSV or JSON at present**

1.First we will create a custom command that will take 2 inputs as arguements->[profile(what type of file you want to input) and the file path]

Initially we will have json,csv formats

&nbsp;

&nbsp;**however the code should be written to support importing from other sources in the future.**

Here to solve this issue and involve loose coupling we will implement an interface which is currently implemented by CsvProfile and JsonProfile and these to classes will import the files

* * *

# **IMPLEMENTATION**

**1.FIRST WE WILL CREATE A CUSTOM COMMAND LINE ARGUEMENT.**

**2.IMPLEMENT AN INTERFACE WHICH HAS IMPORT FUNCTION TO IMPORT FILES**

**3.IMPLEMENT THE CLASSES FOR THE INTERFACE**

&nbsp;         3.1 Use the Csv importer from Magento\Framework\File\Csv

&nbsp;         3.2 use getData  to read and process the csv file

&nbsp;         3.3 Push that data into database

&nbsp;                       3.3.1 Here you will have CustomerFactory , which is the model and CustomerRepository, which                          is  the Resource model to set and save the data

&nbsp;        3.4 Show output whether it is successful or not , if successful -> output that it was a success and if not, then display the error message.

**4.View the content from the admin panel**
