<div class="hcf_form">
    <div class="hcf_field">
        <label for="hcf_author">Author: </label>
        <select id="hcf_author">
            <?php
            $posts = array(wp_get_current_user());
            foreach ($posts as $post) {
                echo "<option value=\"$post->user_login\">$post->user_login</option>";
            }
            ?>
        </select>
    </div>
    <div class="hcf">
        <input type="hidden" name="date" value="<?php echo date('d.m.y') ?>">
        <input type="hidden" name="current_user" value="<?php echo wp_get_current_user()->user_login ?>">
    </div>
</div>