# PHP The Great

PHP is a great language. Here's why:

```php
if (isset($_GET['part1'])) {
  if (strcmp($part1, CONSTANT_1) == 0) {
    echo FLAG_1 . "\n";
    die();
  }
}
```
Here we don't know the value of `CONSTANT_1`. But we need to make the if condition true. So, we need to make `strcmp` return `0`. Or do we? We can just pass an array instead of a string to `strcmp`, so that it returns NULL (invalid comparison). Now, due to type juggling, which is allowed when comparisons are done with `==`, it'll implicitly convert the `NULL` to `0` for us and bypass the if statement.

```php
if (isset($_POST['part2'])) {
  $part2 = trim($part2);
  if ($part2 == '5.5e5' && $part2 !== '5.5e5') {
    echo FLAG_2 . "\n";
    die();
  }
}
```
Here we need a string which is `'5.5e5'`, but is also not `'5.5e5'`. Due to type juggling, `'5.5e5'` is no longer a string, but rather the scientific notation of the number `550000` (5.5 x 10^5). So we can pass `550000`, or some variation of the scientific notation like `55e4` or `550e3`, etc. to bypass the if statement.

```php
if (isset($_COOKIE['part3'])) {
  if ($part3 == 42 && $part3 !== '42' && $part3 !== 42 && strlen(trim($part3)) == 2) {
    echo FLAG_3 . "\n";
    die();
  }
}
```
Here we need the number `42`, which is not the number `42` or the string `'42'` and has length 2. But since the strlen function is called after passing through a `trim`, we can add more whitespace to the left or right of 42. We can send something like ` 42` or `42 `, which will be implicitly converted to the number 42 due to type juggling.


```php
if (isset($_GET['part4'])) {
  # Magic
  if (hash('md4', $part4) == 0) {
    echo FLAG_4 . "\n";
    die();
  }
}
```
Here we need a string whose MD4 hash is equal to 0. Again we know that if a string begins with `0e`, then it is interpreted as `0 x 10^n`, which is always 0. So we need to find a string with md4 hash that begins with `0e`. We can write a script to do this or we can get these "magic hashes" from the internet (https://github.com/spaze/hashes/blob/master/md4.md).

Note: The way to communicate with the server is through GET or POST requests, or cookie values. So use a command line tool like curl or some scripting language like python to send the requests to the server.

## Exploits

![](https://i.imgur.com/0gzvbGf.png)
