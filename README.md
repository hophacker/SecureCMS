SecureCMS
========
Generally, I found two classes of exploits in *SecureCMS*.

SQL Injection
--------
In order to sanitize input data and prevent SQL Injection, I patched all the previous SQL execution sequences into codes using functions **prepare()** and **bind_param()**. 

Then, I learned and made some changes from a piece of code online, which can detect SQL injections(*The reason I did not implement one all by myself since intrusion detection has so many edge cases, one can't consider them all, especiall for a newbie like me*).

The code is in *"checkInput.php"*. It takes all the arrays from *$_GET*, *$_POST*, *$_COOKIE* and check the values recursively. Then, for each value, *testHelper()* function delievers the value to *test()* function, then by checking all the rules of (*SQL Injection violation*)in *test()* function, *test()* returns a value which indicates how many rules has been violated by the value. Finally, if the *rule-voilated-times* is bigger than some limit, that means there's probably SQL *Injection* *testHelper()*, then it will write down the message together with related value into apache2 log.

In order to further monitor the behavior of the attacker, I seperated a database named "SecureCMSCorrupt" from "SecureCMS" for direct excution of user input SQL sequence. Thus, everytime, there's a SQL execution, the program will execute both sanitized SQL and malicious SQL.

Cross-Site Script(XSS)
---------
To prevent XSS attack, I integrated input checktng with *OWASP encoding project*. Then I patched all the code which is vulnerable to XSS attack in *SecureCMS* by calling *checkXSS()* function in *"checkInput.php"*. That function will return sanitized input by doing work like encoding special html characters, striping suspicious tags, etc.
 
Vulnerable code I have patched
---------
(1)
```php
//logBegin
checkSQLInput($article_id);
//logEnd
//logBegin
checkSQLInput($comment_id);
//logEnd
//logBegin
$title = checkXSS($title);
$content = checkXSS($content);
//logEnd
//logBegin
$name = checkXSS($name);
$welcome = checkXSS($welcome);
//logEnd
//logBegin
checkHTMLInput($name);
checkHTMLInput($welcome);
//logEnd
//VulBegin: SQL Injection
/*Original Code:
  $query = "INSERT INTO article (title,content,author_id) VALUES ('$title','$content','$authorid')"; 
  if (!mysqli_query($con,$query))
  {
  die('Error: ' . mysqli_error($con));
  }
 */
//Patch Code:
$stmt = $con->prepare("INSERT INTO article (title,content,author_id) VALUES (?,?,?)");
$stmt->bind_param('sss', $title, $content, $author_id);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
```
(2)
```php
//VulBegin: SQL Injection
/*Original Code:
  $query = "INSERT INTO comments (user_id,article_id,comment) VALUES ('$authorid','$articleid','$comment')"; 
  echo $query;

  if (!mysqli_query($con,$query))
  {
  die('Error: ' . mysqli_error($con));
  }
 */
//Patch Code:
$query = "INSERT INTO comments (user_id,article_id,comment) VALUES ('$authorid','$articleid','$comment')"; 
if (!mysqli_query($con,$query))
{
    die('Error: ' . mysqli_error($con));
}

mysqli_select_db("SecureCMS", $con);
$stmt = $con->prepare("INSERT INTO comments (user_id,article_id,comment) VALUES (?,?,?)");
$stmt->bind_param('sss', $authorid, $articleid, $comment);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
```
(3)
```php
//VulBegin: XSS
/*Original Code:
  echo "<b><a href='index.php?page=view_article&article_id=" . $row['aid'] . "'>" . $row['title'] . "</a></b> by " . $row['user_name'] . "<br/><br/>";
 */
//Patch Code:
echo "<b><a href='index.php?page=view_article&article_id=" . checkXSS($row['aid']) . "'>" . checkXSS($row['title']) . "</a></b> by " . checkXSS($row['user_name']) . "<br/><br/>";
//VulEnd
```
(4)
```php
//VulBegin: SQL Injection
/*Original Code:
  mysqli_query($con,"DELETE FROM article WHERE id='$articleid'");
 */
//Patch Code:
$con_corrupt = conC();
$con = conN();
mysqli_query($con_corrupt, "DELETE FROM article WHERE id='$articleid'");

$stmt = $con->prepare("DELETE FROM article WHERE id=?");
$stmt->bind_param('s', $articleid);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
//VulBegin: SQL Injection
/*Original Code:
  mysqli_query($con,"DELETE FROM comments WHERE id='$commentid'");
 */
//Patch Code:
$con_corrupt = conC();
$con = conN();
mysqli_query($con_corrupt, "DELETE FROM comments WHERE id='$commentid'");
$stmt = $con->prepare("DELETE FROM comments WHERE id=?");
$stmt->bind_param('s', $commentid);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
```
(5)
```php
//VulBegin: SQL Injection
/*Original Code:
  $query = "UPDATE article SET title='$title',content='$content' WHERE id='$articleid'"; 
  if (!mysqli_query($con,$query))
  {
  die('Error: ' . mysqli_error($con));
  }
 */
//Patch Code:
$con_corrupt = conC();
$con = conN();
$query = "UPDATE article SET title='$title',content='$content' WHERE id='$articleid'"; 
if (!mysqli_query($con_corrupt,$query))
{
    die('Error: ' . mysqli_error($con_corrupt));
}

$stmt = $con->prepare( "UPDATE article SET title=?,content=? WHERE id=?");
$stmt->bind_param('sss', $title, $content, $articleid);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
```
(6)
```php
//VulBegin: 
//Patch Code: Cross Site Scripting (XSS)
$title = htmlspecialchars($title, ENT_QUOTES);
$content = htmlspecialchars($content, ENT_QUOTES);
//logBegin
$title = checkXSS($title);
$content = checkXSS($content);
//logEnd
//VulEnd
//VulBegin: SQL Injection
/*Original Code:
  $query = "INSERT INTO settings (site_name,welcome) VALUES ('$name','$welcome')";
  mysqli_query($con,$query);
 */
//Patch Code:
$con_corrupt = conC();
$con = conN();
$query = "INSERT INTO settings (site_name,welcome) VALUES ('$name','$welcome')";
mysqli_query($con_corrupt,$query);
$stmt = $con->prepare( "INSERT INTO settings (site_name,welcome) VALUES (?,?)");
$stmt->bind_param('ss', $name, $welcome);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
```
(7)
```php
//VulBegin: 
//Patch Code: Cross Site Scripting (XSS)
$name = htmlspecialchars($name, ENT_QUOTES);
$welcome = htmlspecialchars($welcome, ENT_QUOTES);
//VulEnd
```
(8)
```php
//VulBegin: SQL Injection
/*Original Code:
  $q = "SELECT * FROM users WHERE user_name='$username' AND password='$password'";
  $result = mysqli_query($con,$q);
  if($result == NULL){
//No results found! Must be wrong user
echo "Error: Wrong username/password.";	
}
 */
//Patch Code:
$con_corrupt = conC();
$q = "SELECT * FROM users WHERE user_name='$username' AND password='$password'";
$result = mysqli_query($con_corrupt ,$q);
if($result == NULL){
    //No results found! Must be wrong user
    echo "Error: Wrong username/password.";	
}

$con = conN();
$stmt = $con->prepare("SELECT * FROM users WHERE user_name=? AND password=?");
$stmt->bind_param('ss', $username, $password);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
```
(9)
```php
//VulBegin: XSS
/*Original Code:
  echo "Welcome, " . $_SESSION['username'];	
 */
//Patch Code:
echo "Welcome, " . checkXSS($_SESSION['username']);	
//VulEnd
```
(10)
```php
//VulBegin: SQL Injection
/*Original Code:
  $query = "INSERT INTO users (user_name,email,password,is_admin) VALUES ('$username','$email','$password',false)"; 
  if (!mysqli_query($con,$query))
  {
  die('Error: ' . mysqli_error($con));
  }
 */
//Patch Code:
$con = conN();
$query = "INSERT INTO users (user_name,email,password,is_admin) VALUES ('$username','$email','$password',false)"; 
if (!mysqli_query($con,$query))
{
    die('Error: ' . mysqli_error($con));
}

$con = conC();
$stmt = $con->prepare("INSERT INTO users (user_name,email,password,is_admin) VALUES (?,?,?,false)"); 
$stmt->bind_param('sss', $username, $email, $password);
if ($stmt->execute() != 1)
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
```
(11)
```php
//VulBegin: SQL Injection
/*Original Code:
  $result = mysqli_query($con,"SELECT title,user_name,article.id as aid FROM article,users WHERE title LIKE '%$term%' AND article.author_id=users.id");
 */
//Patch Code:
$con_corrupt = conC();
$con = conN();
$result = mysqli_query($con_corrupt,"SELECT title,user_name,article.id as aid FROM article,users WHERE title LIKE '%$term%' AND article.author_id=users.id");
$stmt = $con->prepare("SELECT title,user_name,article.id as aid FROM article,users WHERE title LIKE '%?%' AND article.author_id=users.id");
$stmt->bind_param('s', $term);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
```
(12)
```php
//VulBegin: SQL Injection
/*Original Code:
  echo "<b><a href='index.php?page=view_article&article_id=" . $row['aid'] . "'>" . $row['title'] . "</a></b> by " . $row['user_name']. "<br/><br/>";
 */
//Patch Code:
echo "<b><a href='index.php?page=view_article&article_id=" . checkXSS($row['aid']) . "'>" . checkXSS($row['title']) . "</a></b> by " . checkXSS($row['user_name']). "<br/><br/>";
//VulEnd
```
(13)
```php
//VulBegin: SQL Injection
/*Original Code:
  $result = mysqli_query($con,"SELECT * FROM article,users WHERE article.author_id=users.id AND article.id='$articleid'");
 */
//Patch Code:
$con_corrupt = conC();
$con = conN();
$result = mysqli_query($con_corrupt,"SELECT * FROM article,users WHERE article.author_id=users.id AND article.id='$articleid'");

$stmt = $con->prepare("SELECT * FROM article,users WHERE article.author_id=users.id AND article.id='?'");
$stmt->bind_param('s', $articleid);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
```
(14)
```php
//VulBegin: XSS Injection
/*Original Code:
  while($row = mysqli_fetch_array($result)){
  echo "<b>" . $row['title'] . "</b> by " . $row['user_name'] . "<br/><br/>";
  echo nl2br($row['content']);
  echo "<br/><br/>";
  if($_SESSION['is_admin'] == 1){
  echo "<a href='index.php?page=edit_article&article_id=" . $articleid . "'>Edit</a> ";	
  echo "<a href='index.php?page=delete_article&article_id=" . $articleid . "'>Delete</a>";	

  }
  }	
 */
//Patch Code:
while($row = mysqli_fetch_array($result)){
    echo "<b>" . checkXSS($row['title']) . "</b> by " . checkXSS($row['user_name']) . "<br/><br/>";
    echo nl2br(checkXSS($row['content']));
    echo "<br/><br/>";
    if($_SESSION['is_admin'] == 1){
        echo "<a href='index.php?page=edit_article&article_id=" . checkXSS($articleid) . "'>Edit</a> ";	
        echo "<a href='index.php?page=delete_article&article_id=" . checkXSS($articleid) . "'>Delete</a>";	
    }
}	
//VulEnd
```
(15)
```php
//VulBegin: SQL Injection
/*Original Code:
  $result = mysqli_query($con,"SELECT comments.id as cid,comment,user_name,time FROM comments,users WHERE comments.user_id=users.id AND comments.article_id='$articleid'");
 */
//Patch Code:
$con_corrupt = conC();
$con = conN();
$result = mysqli_query($con_corrupt,"SELECT comments.id as cid,comment,user_name,time FROM comments,users WHERE comments.user_id=users.id AND comments.article_id='$articleid'");
$stmt = $con->prepare("SELECT comments.id as cid,comment,user_name,time FROM comments,users WHERE comments.user_id=users.id AND comments.article_id='?'");
$stmt->bind_param('s',  $articleid);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
```
(16)
```php
//VulBegin: XSS
/*Original Code:
  while($row = mysqli_fetch_array($result)){
  echo $row['user_name'] . " said:<br/>" . nl2br($row['comment']);
//If an admin is logged in, give them the option to delete it
if($_SESSION['is_admin'] == 1){
echo "<a href='index.php?page=delete_comment&comment_id=" . $row['cid'] . "'>Delete</a>";	
}
echo "<br/><br/>";
}	
 */
//Patch Code:
while($row = mysqli_fetch_array($result)){
    echo checkXSS($row['user_name']) . " said:<br/>" . checkXSS(nl2br($row['comment']));
    //If an admin is logged in, give them the option to delete it
    if($_SESSION['is_admin'] == 1){
        echo "<a href='index.php?page=delete_comment&comment_id=" . checkXSS($row['cid']) . "'>Delete</a>";	
    }
    echo "<br/><br/>";
}	
//VulEnd
```
(17)
```php
//VulBegin: XSS
/*Original Code:
  while($row = mysqli_fetch_array($result)){
  echo "<tr><td>" . $row['id'] . "</td><td>" . $row['user_name'] . "</td><td>" . $row['email'] . "</td></tr>";
  }	
 */
//Patch Code:
while($row = mysqli_fetch_array($result)){
    echo "<tr><td>" . checkXSS($row['id']) . "</td><td>" . checkXSS($row['user_name']) . "</td><td>" . checkXSS($row['email']) . "</td></tr>";
}	
//VulEnd

