<?php if ( ! defined( 'ABSPATH' ) ) { exit; } 
// 搜索列表请到 inc\search-list.php 文件修改
include( get_theme_file_path('/inc/search-list.php') ); 
?> 
<div class="s-search">
<div id="search" class="s-search mx-auto">
    <div id="search-list-menu" class="hide-type-list">
        <div class="s-type">
            <div class="s-type-list big">
                <div class="anchor" style="position: absolute; left: 50%; opacity: 0;"></div>
                <?php $index=0; foreach ($search_list as $value) {
                    echo '<label for="'.$value['default'].'" '.( $index==0?'class="active"':'').' data-id="'.$value['id'].'"><span>'.$value['name'].'</span></label>';
                    $index++;
                } ?>
            </div>
        </div>
    </div>
    <form action="<?php echo home_url() ?>?s=" method="get" target="_blank" class="super-search-fm">
        <input type="text" id="search-text" class="form-control smart-tips search-key" zhannei="" placeholder="<?php _e( '输入关键字搜索', 'i_theme' ); ?>" style="outline:0" autocomplete="off">
        <button type="submit"><i class="iconfont icon-search"></i></button>
    </form> 
    <div id="search-list" class="hide-type-list">
        <?php $i=0; foreach ($search_list as $value) {
            echo '<div class="search-group '.$value['id'].' '.( $i==0?'s-current':'').'">';
            echo '<ul class="search-type">';
            foreach ($value['list'] as $s) {
                if($i==0 && $s['id']==$value['default'])
                    echo '<li><input checked="checked" hidden type="radio" name="type" id="'.$s['id'].'" value="'.$s['url'].'" data-placeholder="'.$s['placeholder'].'"><label for="'.$s['id'].'"><span class="text-muted">'.$s['name'].'</span></label></li>';
                else
                    echo '<li><input hidden type="radio" name="type" id="'.$s['id'].'" value="'.$s['url'].'" data-placeholder="'.$s['placeholder'].'"><label for="'.$s['id'].'"><span class="text-muted">'.$s['name'].'</span></label></li>';
            }
            echo '</ul>';
            echo '</div>';
            $i++;
        } ?>
    </div>
    <div class="card search-smart-tips" style="display: none">
      <ul></ul>
    </div>
</div>
</div>
