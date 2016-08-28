# xls-woles [![Build Status](https://travis-ci.org/ahmadpriatama/xls-woles.svg?branch=master)](https://travis-ci.org/ahmadpriatama/xls-woles)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). 

### Install

Either run

```
$ php composer.phar require ahmadpriatama/xls-woles "*"
```

or add

```
"ahmadpriatama/xls-woles": "*"
```

to the ```require``` section of your `composer.json` file.

## Demo
see folder ```demo```

## Usage Example
We have a list of children book in `Book1.xlsx` as shown below

![alt tag](https://raw.githubusercontent.com/ahmadpriatama/xls-woles/master/demo/Book1.png)
    
And your supervisor want clean data to be imported with specs:
   1. Book name must stored in lower case string
   2. Must split author name into first name and last name
   3. ISBN must stored in format XXX-X-XX-XXXXXX-X
   4. Language must stored in constant value ex: `Book::LANG_EN = 1` or `Book::LANG_NON_EN = 2`
   
  
and this is your script

    $config = json_decode(file_get_contents($fileConfig), true);
    $data = \XLSWoles\Reader::load($fileInput)
        ->setSheetName('Sheet1')
        ->setColumnConfig($config['columns'])
        ->setDataRange('a2:e6')
        ->fetch();
        
column-config.json:

    {
      "columns" : {
        "book-name": {
          "filters": [
            "string-lowercase"
          ]
        },
        "author-name": {
          "filters":[
            "SplitNameFilter"
          ]
        },
        "publisher": {},
        "isbn": {
          "filters": [
            "regex||-||",
            "regex||(\\d{3})(\\d{1})(\\d{2})(\\d{6})(\\d{1})||$1-$2-$3-$4-$5"
          ]
        },
        "language": {
          "filters": [
            "string-lowercase",
            "regex||english||1"
          ]
        }
      }
    }
   
 you see that `author-name` field has `SplitNameFilter` which is a custom filter which source code as shown below:
 
     <?php
     
     /**
      * Class SplitNameFilter
      * @author Ahmad Priatama <ahmad.priatama@gmail.com>
      * @since 2016.08.28
      */
     class SplitNameFilter
     {
     
         /**
          * @param string $input Input String
          * @return array
          */
         public function process($input)
         {
             $arr = explode(' ', $input);
             $count = count($arr);
             if ($count == 1) {
                 return [
                     'first-name' => $arr[0],
                     'last-name' => null,
                 ];
             } else {
                 return [
                     'first-name' => implode(' ', array_slice($arr, 0, $count-1)),
                     'last-name' => $arr[$count-1],
                 ];
             }
         }
     }
    
`print_r($data);` should give you

    Array
    (
        [0] => Array
            (
                [book-name] => where the wild things are
                [author-name] => Array
                    (
                        [first-name] => Maurice
                        [last-name] => Sendak
                    )
    
                [publisher] => HarperCollins
                [isbn] => 978-0-06-443178-1
                [language] => 1
            )
    
        [1] => Array
            (
                [book-name] => the snowy day
                [author-name] => Array
                    (
                        [first-name] => Ezra Jack
                        [last-name] => Keats
                    )
    
                [publisher] => Puffin Books
                [isbn] => 978-0-14-050182-7
                [language] => 1
            )
    
        [2] => Array
            (
                [book-name] => goodnight moon
                [author-name] => Array
                    (
                        [first-name] => Margaret Wise
                        [last-name] => Brown
                    )
    
                [publisher] => HarperCollins
                [isbn] => 978-0-06-443017-3
                [language] => 1
            )
    
        [3] => Array
            (
                [book-name] => owl moon
                [author-name] => Array
                    (
                        [first-name] => Jane
                        [last-name] => Yolen
                    )
    
                [publisher] => Philomel Books
                [isbn] => 978-0-39-921457-8
                [language] => 1
            )
    
        [4] => Array
            (
                [book-name] => the giving tree
                [author-name] => Array
                    (
                        [first-name] => Shel
                        [last-name] => Silverstein
                    )
    
                [publisher] => Harper & Row
                [isbn] => 978-0-06-025665-4
                [language] => 1
            )
    
    )
    
## Built-in Filters
1. Regex Replace
2. String Lowercase
3. String Uppercase
4. String to Time
5. Default Value
6. Null on Empty