<?php
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$text = urlencode("نوای حسین"); //text for search
$dom -> loadHTML('<!DOCTYPE html>' .file_get_contents("https://kashoob.com/search?q=$text"));
$finder = new DOMXPath($dom);
$classname = "content-item";
$org = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
$data = [];
foreach($org as $key){
    $data[] = [
        "link" => $key->childNodes->item(1) -> attributes -> getNamedItem("href") -> textContent,
        "image" => $key->childNodes->item(1) -> childNodes -> item(1) -> attributes -> getNamedItem("src") -> textContent,
        "title" => $key->childNodes->item(1) -> childNodes -> item(3) -> childNodes -> item(1) -> textContent ,
        "subject" => $key->childNodes->item(1) -> childNodes -> item(3) -> childNodes -> item(3) -> childNodes -> item(1)-> textContent 

    ];
    /*
    print_r($key->childNodes->item(1) -> attributes -> getNamedItem("href") -> textContent ); // link
    print_r($key->childNodes->item(1) -> childNodes -> item(1) -> attributes -> getNamedItem("src") -> textContent); // image
    print_r($key->childNodes->item(1) -> childNodes -> item(3) -> childNodes -> item(1) -> textContent  ); //title
    print_r($key->childNodes->item(1) -> childNodes -> item(3) -> childNodes -> item(3) -> childNodes -> item(1)-> textContent  ); //subject
    */
}
file_put_contents("search.json" , json_encode($data , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
