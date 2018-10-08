<?php
/**
 * Created by PhpStorm.
 * User: Jermaine Durham
 * Date: 8/18/18
 * Time: 11:08 AM
 */
session_start();

require "../core/config.php";
require "../core/upload.php";
require "../core/notification.php";

require "../model/uploadd.php";
require "../model/profiled.php";
require "../model/notificationd.php";

require "../views/member_photo.php";

$config = new config();

//if(!empty($_POST)){
switch (true) {
    case $_POST['member_photo_data']: {
        $description = $_POST['photo_description_txt'];
        $description = addslashes(trim($description));

        namespace\upload::add_member_photo($config->get_session_id(), $config->get_session_id(), $description, $_FILES);
        $friends = [];
        $friends[] = friendd::my_friends_list()['tomemberid'];

        //NOTIFCIATION ADD REPILED POST COMMENT
        for ($i = 0; $i < count($friends); $i++) {
            if ($friends[$i] != $config->get_session_id()) {
                notification::notification_add($friends[$i], $config->get_session_id(), notification::$ADDED_PHOTO, "", $_POST['save_comment']);
            }
        }

        break;
    }

    case $_POST['load_member_photo']: {

        $memberid = $_POST['load_member_photo'];

        $photos[] = namespace\uploadd::load_member_photo_DB($memberid, 1);
        $source = "views/profile/" . $memberid . "/photo/";

        for ($i = 0; $i < count($photos[0]); $i++) {
            ?>
            <table id="member_photo_tb<?php echo $photos[0][$i]['fileid']; ?>" class="member_photo_tb"
                   onclick="member_photo_viewer_show('<?php echo $photos[0][$i]['fileid']; ?>', '<?php echo $photos[0][$i]['filename']; ?>','<?php echo $source . $photos[0][$i]['filename']; ?>', '<?php echo $photos[0][$i]['description']; ?>', '<?php echo profiled::MemberFirstName($memberid) . " Photo"; ?>');">
                <tr>
                    <td>
                        <img class="member_photo_img" src="<?php echo $source . $photos[0][$i]['filename']; ?>"/>
                    </td>
                </tr>
            </table>
            <?php
        }
        break;
    }
    case $_POST['set_profile_picture']: {
        $filename = $_POST['set_profile_picture'];
        $currentfile_location = "../views/profile/" . $config->get_session_id() . "/photo/";
        $newfile_location = "../views/profile/" . $config->get_session_id() . "/profile-picture";

        if (!is_dir($newfile_location)) {
            @mkdir($newfile_location, 0777);
        }

        if (copy($currentfile_location . $filename, $newfile_location . "/" . $filename)) {
            profiled::set_profile_picture($config->get_session_id(), $filename);
            $im = imagecreatefromjpeg($newfile_location . "/" . $filename);

            $cropped = imagecropauto($im, IMG_CROP_DEFAULT);
            if ($cropped !== false) { // in case a new image resource was returned
                imagedestroy($im);    // we destroy the original image
                $im = $cropped;       // and assign the cropped image to $im
            }

        }
        break;
    }

    case $_POST['photo_delete']: {
        $currentfile_location = "../views/profile/" . $config->get_session_id() . "/photo/";
        if (profiled::MemberDeletePhoto($_POST['fileid'], $_POST['filename'])) {
            @unlink($currentfile_location . $_POST['filename']);
        }
        break;
    }

}
//}