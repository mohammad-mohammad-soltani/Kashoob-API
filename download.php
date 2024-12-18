<?php
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$link = ""; //put your link from search json file
$dom -> loadHTML('<!DOCTYPE html>' .file_get_contents("$link"));
$finder = new DOMXPath($dom);

$data = [
    "image" => $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' thumbnail ')]") -> item(0) -> attributes -> getNamedItem("src") -> textContent,
    "title" => $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' title ')]") -> item(0)  -> textContent,
    "file" => $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' audio-page-player ')]") -> item(0) -> attributes -> getNamedItem("src")  -> textContent,
    "signer" => $finder->query("/html/body/div[2]/div[2]/div/div/article/div[2]/h2/span/a") -> item(0)  -> textContent,
    "subject" => $finder->query("/html/body/div[2]/div[2]/div/div/article/div[2]/span[2]/a") -> item(0) -> textContent,
    "published_at" => $finder -> query("/html/body/div[2]/div[2]/div/div/article/div[3]/time") -> item(0) -> textContent,
    "type" => $finder -> query("/html/body/div[2]/div[2]/div/div/article/div[3]/span[2]/a") -> item(0) -> textContent
];
file_put_contents("download.json" , json_encode($data , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
