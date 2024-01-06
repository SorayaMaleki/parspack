<?php

const PATH = '/opt/myprogram/product_comments';

/** this function add  Product name: Total number of comments
 *
 * @param  string  $productTitle  The name of the product.
 *
 * @return void
 */
function addCommentCount(string $productTitle)
{
    $newContent = $productTitle.":"."0";
    exec("echo ".addslashes($newContent)." >> ".PATH);
}

/**
 * This function update  Product name: Total number of comments.
 *
 * @param  string  $productTitle  The name of the product.
 *
 * @return void
 */
function updateCommentCount(string $productTitle)
{
    $oldContent = "$productTitle:";
    $oldCount = shell_exec("grep -E '^$oldContent' ".PATH." | cut -d':' -f2");
    $newContent = "$productTitle:".$oldCount + 1;
    exec("sed -i 's/^".$oldContent.".*$/".$newContent."/g' ".PATH);
}

/** This function check if os is linux base
 *
 * @return bool
 */
function osIsLinux(): bool
{
    return in_array(strtoupper(PHP_OS), ["LINUX-LIKE", "LINUX"]);
}
