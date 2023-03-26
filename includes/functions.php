<?php



function usernameExists($username,mysqli $conn): bool{
    $stmt = "SELECT userId FROM users WHERE userName='$username'";
    $result = $conn->query($stmt);
    return ! empty($result->fetch_array());
    }


function isUserBlocked(string $username,mysqli $conn): bool{
    $stmt = "SELECT userStatus from users WHERE userName='$username'";
    $result = $conn->query($stmt)->fetch_assoc();
    return  $result['userStatus'] === 'BLOCKED';
}

function createUser($username,$password ,mysqli $conn):bool|string{
    // Create folder
    $folder_path = $_SERVER['DOCUMENT_ROOT'] . '/users-photos/' . $username;
    if (is_dir($folder_path)){
        return "folderExistsError";
    }

    if (! mkdir($folder_path, 0777)){
        return "folder_creation_error";
    };

    // Set user in DB
    $password = hash("md5",$password);
    $stmt = "INSERT INTO users (userName,userPwd,userFolder) VALUES (?,?,?)";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param('sss',$username,$password,$folder_path);
    if (! $stmt->execute()){
        return "dbCreateError";
    }

    // TODO?: delete folder if stmt is false
    return true;
}

function compare_passwords($username, $password , mysqli $conn):bool{
    $stmt = "SELECT userPwd FROM users WHERE userName='$username'";
    $result = $conn->query($stmt);
    $result = $result->fetch_array();
    if ($result['userPwd'] != hash("md5",$password)){
        return false;
    }
    return true;
}

function get_user($username, mysqli $conn):array{
    $stmt = "SELECT userId, userName,userStatus, userArticlesIds, userFolder FROM users WHERE userName='$username'";
    $result = $conn->query($stmt);
    return $result->fetch_assoc();
}


/**
 * @throws Exception
 */
function save_img($username):string{
    $target_dir = '/users-photos/' . $username . '/';
    $total = count($_FILES['article_images']['name']);
    $paths = [];

    for( $i=0 ; $i < $total ; $i++ ) {
        $tmp_file_path = $_FILES['article_images']['tmp_name'][$i];
        $new_file_path = $target_dir . $_FILES['article_images']['name'][$i];


        if($tmp_file_path == ''){
            throw new Exception('tmpPathError - ' . $i);
        }

        $allowed = array('gif', 'png', 'jpg');
        $ext = pathinfo($_FILES['article_images']['name'][$i], PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            throw new Exception("fileFormatError");
        }

        if (file_exists($new_file_path)){
            throw new Exception("fileExistsError");
        }

        if($_FILES['article_images']['size'][$i] > 5000000){
            throw new Exception("fileSizeError");
        }

        if(! move_uploaded_file($tmp_file_path,$_SERVER['DOCUMENT_ROOT'] . $new_file_path)){
            throw new Exception("moveError");        }

        $paths[] = $new_file_path ;
    }
    return join(",",$paths);
}

function get_articles(mysqli $conn, $author = ""):array{

    if($author !== ""){
        $stmt = "SELECT articleId,articleAuthor,articleCreationDate,articlePhoto,articleTitle,articleContent FROM articles WHERE articleAuthor = '$author' ORDER BY articleCreationDate DESC";
        return $conn->query($stmt)->fetch_all($mode=1);
    }

    $stmt = "SELECT articleId,articleAuthor,articleCreationDate,articlePhoto,articleTitle,articleContent FROM articles ORDER BY articleCreationDate DESC";
    return $conn->query($stmt)->fetch_all($mode=1); // assoc array mode
}

function get_article(mysqli $conn,int $article_id):array{
    $stmt = "SELECT * FROM articles WHERE articleId=$article_id";
    return $conn->query($stmt)->fetch_assoc();
}

function edit_article(
    mysqli $conn,
    int $article_id,
    $article_title,
    $article_content,
    $article_paths,
    ):bool{

    $time = time();
    $stmt = "UPDATE articles SET 
                    articleTitle='$article_title',
                    articleContent='$article_content',
                    articlePhoto='$article_paths',
                    articleModificationDate='$time'
             WHERE articleID=$article_id";

    return $conn->query($stmt);
}

function cut_article_content(string $content, int $length):string{
    $content = explode(" ",$content,$length);
    array_pop($content);
    return join(" ",$content);
}

function get_users(mysqli $conn):array{
    $stmt = "SELECT * FROM users";
    return $conn->query($stmt)->fetch_all(MYSQLI_ASSOC);
}

function set_user_status(mysqli $conn,string $id,string $status): bool{
    $stmt = "UPDATE users SET userStatus='$status' WHERE userId=$id";
    return $conn->query($stmt);
}

function delete_user(mysqli $conn,string $id): bool{
    $stmt = "DELETE FROM users where userId=$id";
    return $conn->query($stmt);
}

