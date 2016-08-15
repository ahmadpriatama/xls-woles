# xls-woles

build [![Build Status](https://travis-ci.org/ahmadpriatama/xls-woles.svg?branch=master)](https://travis-ci.org/ahmadpriatama/xls-woles)

example:

| Book Name   	| Author           	| Publisher 	| ISBN          	| English 	| Non English 	|
|-------------	|------------------	|-----------	|---------------	|---------	|-------------	|
| Span        	| Betty Reed       	| Flashspan 	| 7184082155430 	| X       	|             	|
| Bytecard    	| Roy Warren       	| Skipstorm 	| 5753711080260 	| X       	|             	|
| Keylex      	| Anthony Black    	| Katz      	| 3039624528740 	| X       	|             	|
| Aerified    	| Mildred Crawford 	| Gigashots 	| 1716325845670 	|         	| X           	|
| Solarbreeze 	| Lois Hunter      	| Eabox     	| 5054483477940 	|         	| X           	|
    

usage:

    $config = json_decode(file_get_contents('column-config.json'), true);
    $this->xlsInstance = \XLSWoles\Reader::load('input.xls');
    $data = $this->xlsInstance->setSheetName('sheet1')
        ->setColumnConfig($config)
        ->setDataRange('a1:e5')
        ->fetch();
        
column-config.json:

    {
        "book-name": {
            "filters": [
                "string-lowercase"
            ]
        },
        "author": {},
        "publisher": {},
        "isbn": {
            "filters": [
                "regex||[^0-9\\-]*([0-9\\-]+).*||$1",
                "regex||(\d{3})(\d{1})(\d{2})(\d{6})(\d{1})||$1-$2-$3-$4-$5"
            ]
        },
        "is-english": {
            "type": "multiColumn",
            "columnCount": 2,
            "translate": ["Y", "N"]
        }
    }
    
output:

    Array
    (
        [0] => Array
            (
                [book-name] => span
                [author] => Betty Reed
                [publisher] => Flashspan
                [isbn] => 718-4-08-215543-0
                [is-english] => Y
            )
        [1] => Array
            (
                [book-name] => bytecard
                [author] => Roy Warren
                [publisher] => Skipstorm
                [isbn] => 575-3-71-108026-0
                [is-english] => Y
            )
        [2] => Array
            (
                [book-name] => keylex
                [author] => Anthony Black
                [publisher] => Katz
                [isbn] => 303-9-62-452874-0
                [is-english] => Y
            )
        [3] => Array
            (
                [book-name] => aerified
                [author] => Mildred Crawford
                [publisher] => Gigashots
                [isbn] => 171-6-32-584567-0
                [is-english] => N
            )
        [4] => Array
            (
                [book-name] => solarbreeze
                [author] => Lois Hunter
                [publisher] => Eabox
                [isbn] => 505-4-48-347794-0
                [is-english] => N
            )
    )

similar to:

| book-name   	| author           	| publisher 	| isbn               	| is-english 	|
|-------------	|------------------	|-----------	|-------------------	|-----------	|
| span        	| Betty Reed       	| Flashspan 	| 718-4-08-215543-0 	| Y         	|
| bytecard    	| Roy Warren       	| Skipstorm 	| 575-3-71-108026-0 	| Y         	|
| keylex      	| Anthony Black    	| Katz      	| 303-9-62-452874-0 	| Y         	|
| aerified    	| Mildred Crawford 	| Gigashots 	| 171-6-32-584567-0 	| N         	|
| solarbreeze 	| Lois Hunter      	| Eabox     	| 505-4-48-347794-0 	| N         	|