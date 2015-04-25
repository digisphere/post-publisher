<?php
/**
 * Plugin Name: Post Publisher
 * Plugin URI: http://www.amitmoreno.com/
 * Description: Publish posts via the front-end.
 * Version: 1.0 beta
 * Author: Amit Moreno
 * Author URI: http://www.amitmoreno.com/
 * Text Domain: moreno
 * License: GPL2
 */
 
// load styles & scripts
function post_publisher_scripts() {
	wp_enqueue_style( 'style', plugins_url('style.css', __FILE__) );
	//wp_enqueue_script( 'jquery-validate', plugins_url( 'jquery.validate.min.js', __FILE__ ), array(), '1.0.0', true );
	//wp_enqueue_script( 'scripts', plugins_url( 'scripts.js', __FILE__ ), array(), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'post_publisher_scripts' );

function post_publisher() { ?>
<div id="post-publisher">
	<form id="new_post" name="new_post" method="post" action="<?php home_url();?>" class="post-publisher-form" enctype="multipart/form-data">
    	<div class="form-group">
		<input type="text" id="title" value="" tabindex="1" size="20" name="title" placeholder="כותרת הפוסט" class="form-title" />
		<textarea id="description" tabindex="3" name="description" cols="50" rows="6" placeholder="תוכן הפוסט" class="form-text" maxlength="620"></textarea>
        <fieldset>
	        <div class="photo-icon"></div>
			<input type="file" name="thumbnail" id="thumbnail" size="50" class="upload" />
            <select id="post_format" class="form-post-format" tabindex="4" name="post_format" title="Post Format">
                <option class="level-0" value="none">תבנית הפוסט</option>
                <option class="level-0" value="none">ללא תבנית</option>
                <option class="level-0" value="quote">ציטוט</option>
                <option class="level-0" value="link">קישור</option>
                <option class="level-0" value="video">וידאו</option>
            </select>
            <div class="pp-devider"></div>
            <input type="text" value="" tabindex="5" size="16" name="post_tags" id="post_tags" placeholder="תגיות" class="form-tags" />
            <input type="submit" value="פרסום" tabindex="6" id="submit" class="publish-post" name="submit" />
		</fieldset>
        
        </div>
		<input type="hidden" name="action" value="new_post" />
		<?php wp_nonce_field( 'new-post' ); ?>
	</form>
</div>
<?php 
}
if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post") {

    // Do some minor form validation to make sure there is content
    if (isset ($_POST['title'])) {
        $title =  $_POST['title'];
    } else {
        echo 'Please enter a post subject';
    }
    if (isset ($_POST['description'])) {
        $description = $_POST['description'];
    } else {
        echo 'Please enter your post';
    }
    $tags = $_POST['post_tags'];

    // Add the content of the form to $post as an array
    $new_post = array(
        'post_title'    => $title,
        'post_content'  => $description,
        'post_category' => array($_POST['cat']),  // Usable for custom taxonomies too
        'tags_input'    => array($tags),
        'post_status'   => 'publish',           // Choose: publish, preview, future, draft, etc.
        'post_type' => 'post'  //'post',page' or use a custom post type if you want to
    );
    //save the new post
    $pid = wp_insert_post($new_post);
	set_post_format($pid, $_POST['post_format'] );
	update_post_meta($pid, 'q_author', $_POST['q_author']);
	update_post_meta($pid, 'l_url', $_POST['l_url']);
	update_post_meta($pid, 'l_txt', $_POST['l_txt']);
    //insert taxonomies
	if ($_FILES) {
    	foreach ($_FILES as $file => $array) {
    		$newupload = insert_attachment($file,$pid);
    		// $newupload returns the attachment id of the file that
    		// was just uploaded. Do whatever you want with that now.
    	}
	}
}

// Shortcode
function post_publisher_shortcode() {
	post_publisher();
}
add_shortcode( 'publisher', 'post_publisher_shortcode' );