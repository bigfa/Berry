<?php

class  berrySetting
{
    public $config;

    function __construct($config = [])
    {
        $this->config = $config;
        add_action('admin_menu', [$this, 'setting_menu']);
        add_action('admin_enqueue_scripts', [$this, 'setting_scripts']);
        add_action('wp_ajax_berry_setting', array($this, 'setting_callback'));
        //add_action('wp_ajax_nopriv_Berry_setting', array($this, 'setting_callback'));
    }

    function clean_options(&$value)
    {
        $value = stripslashes($value);
    }

    function setting_callback()
    {
        $data = $_POST[BERRY_SETTING_KEY];
        array_walk_recursive($data,  array($this, 'clean_options'));
        $this->update_setting($data);
        return wp_send_json([
            'code' => 200,
            'message' => __('Success', 'Berry'),
            'data' => $this->get_setting()
        ]);
    }

    function setting_scripts()
    {
        if (isset($_GET['page']) && $_GET['page'] == 'berry') {
            wp_enqueue_style('berry-setting', get_template_directory_uri() . '/build/css/setting.min.css', array(), BERRY_VERSION, 'all');
            wp_enqueue_script('berry-setting', get_template_directory_uri() . '/build/js/setting.min.js', ['jquery'], BERRY_VERSION, true);
            wp_localize_script(
                'berry-setting',
                'obvInit',
                [
                    'is_single' => is_singular(),
                    'post_id' => get_the_ID(),
                    'restfulBase' => esc_url_raw(rest_url()),
                    'nonce' => wp_create_nonce('wp_rest'),
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'success_message' => __('Setting saved success!', 'Berry'),
                    'upload_title' => __('Upload Image', 'Berry'),
                ]
            );
        }
    }

    function setting_menu()
    {
        add_menu_page(__('Theme Setting', 'Berry'), __('Theme Setting', 'Berry'), 'manage_options', 'berry', [$this, 'setting_page'], '', 59);
    }

    function setting_page()
    { ?>
        <div class="wrap">
            <h2><?php _e('Theme Setting', 'Berry') ?>
                <a href="https://docs.wpista.com/" target="_blank" class="page-title-action"><?php _e('Documentation', 'Berry') ?></a>
            </h2>
            <div class="pure-wrap">
                <div class="leftpanel">
                    <ul class="nav">
                        <?php foreach ($this->config['header'] as $val) {
                            $id = $val['id'];
                            $title = __($val['title'], 'Berry');
                            $icon = $val['icon'];
                            $class = ($id == "basic") ? "active" : "";
                            echo "<li class=\"$class\"><span id=\"tab-title-$id\"><i class=\"dashicons-before dashicons-$icon\"></i>$title</span></li>";
                        } ?>
                    </ul>
                </div>
                <form id="pure-form" method="POST" action="options.php">
                    <?php
                    foreach ($this->config['body'] as $val) {
                        $id = $val['id'];
                        $class = $id == "basic" ? "div-tab" : "div-tab hidden";
                    ?>
                        <div id="tab-<?php echo $id; ?>" class="<?php echo $class; ?>">
                            <?php if (isset($val['docs'])) : ?>
                                <div class="pure-docs">
                                    <a href="<?php echo $val['docs']; ?>" target="_blank"><?php _e('Documentation', 'Berry') ?></a>
                                </div>
                            <?php endif; ?>
                            <table class="form-table">
                                <tbody>
                                    <?php
                                    $content = $val['content'];
                                    foreach ($content as $k => $row) {
                                        switch ($row['type']) {
                                            case 'textarea':
                                                $this->setting_textarea($row);
                                                break;

                                            case 'switch':
                                                $this->setting_switch($row);
                                                break;

                                            case 'input':
                                                $this->setting_input($row);
                                                break;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <div class="pure-save"><span id="pure-save" class="button--save"><?php _e('Save', 'Berry') ?></span></div>
                </form>
            </div>
        </div>
    <?php }

    function get_setting($key = null)
    {
        $setting = get_option(BERRY_SETTING_KEY);

        if (!$setting) {
            return false;
        }

        if ($key) {
            if (array_key_exists($key, $setting)) {
                return $setting[$key];
            } else {
                return false;
            }
        } else {
            return $setting;
        }
    }

    function update_setting($setting)
    {
        update_option(BERRY_SETTING_KEY, $setting);
    }

    function empty_setting()
    {
        delete_option(BERRY_SETTING_KEY);
    }

    function setting_input($params)
    {
        $default = $this->get_setting($params['name']);
    ?>
        <tr>
            <th scope="row">
                <label for="pure-setting-<?php echo $params['name']; ?>"><?php echo __($params['label'], 'Berry'); ?></label>
            </th>
            <td>
                <input type="text" id="pure-setting-<?php echo $params['name']; ?>" name="<?php printf('%s[%s]', BERRY_SETTING_KEY, $params['name']); ?>" value="<?php echo $default; ?>" class="regular-text">
                <?php printf('<br /><br />%s', __($params['description'], 'Berry')); ?>
            </td>
        </tr>
    <?php }

    function setting_textarea($params)
    { ?>
        <tr>
            <th scope="row">
                <label for="pure-setting-<?php echo $params['name']; ?>"><?php echo __($params['label'], 'Berry'); ?></label>
            </th>
            <td>
                <textarea name="<?php printf('%s[%s]', BERRY_SETTING_KEY, $params['name']); ?>" id="pure-setting-<?php echo $params['name']; ?>" class="large-text code" rows="5" cols="50"><?php echo $this->get_setting($params['name']); ?></textarea>
                <?php printf('<br />%s', __($params['description'], 'Berry')); ?>
            </td>
        </tr>
    <?php }

    function setting_switch($params)
    {
        $val = $this->get_setting($params['name']);
        $val = $val ? 1 : 0;
    ?>
        <tr>
            <th scope="row">
                <label for="pure-setting-<?php echo $params['name']; ?>"><?php echo __($params['label'], 'Berry'); ?></label>
            </th>
            <td>
                <a class="pure-setting-switch<?php if ($val) echo ' active'; ?>" href="javascript:;" data-id="pure-setting-<?php echo $params['name']; ?>">
                    <i></i>
                </a>
                <br />
                <input type="hidden" id="pure-setting-<?php echo $params['name']; ?>" name="<?php printf('%s[%s]', BERRY_SETTING_KEY, $params['name']); ?>" value="<?php echo $val; ?>" class="regular-text">
                <?php printf('<br />%s', __($params['description'], 'Berry')); ?>
            </td>
        </tr>
<?php }
}
global $berrySetting;
$berrySetting = new berrySetting(
    [
        "header" => [
            [
                'id' => 'basic',
                'title' => __('Basic Setting', 'Berry'),
                'icon' => 'basic'
            ],
            [
                'id' => 'feature',
                'title' => __('Feature Setting', 'Berry'),
                'icon' => 'slider'

            ],
            [
                'id' => 'singluar',
                'title' => __('Singluar Setting', 'Berry'),
                'icon' => 'feature'
            ],
            [
                'id' => 'meta',
                'title' => __('SNS Setting', 'Berry'),
                'icon' => 'social-contact'
            ],
            [
                'id' => 'custom',
                'title' => __('Custom Setting', 'Berry'),
                'icon' => 'interface'
            ]
        ],
        "body" => [
            [
                'id' => 'basic',
                'content' => [
                    [
                        'type' => 'textarea',
                        'name' => 'description',
                        'label' => __('Description', 'Berry'),
                        'description' => __('Site description', 'Berry'),
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'headcode',
                        'label' => __('Headcode', 'Berry'),
                        'description' => __('You can add content to the head tag, such as site verification tags, and so on.', 'Berry'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'og_default_thumb',
                        'label' => __('Og default thumb', 'Berry'),
                        'description' => __('Og meta default thumb address.', 'Berry'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'favicon',
                        'label' => __('Favicon', 'Berry'),
                        'description' => __('Favicon address', 'Berry'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'title_sep',
                        'label' => __('Title sep', 'Berry'),
                        'description' => __('Default is', 'Berry') . '<code>-</code>',
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'disable_block_css',
                        'label' => __('Disable block css', 'Berry'),
                        'description' => __('Do not load block-style files.', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'gravatar_proxy',
                        'label' => __('Gravatar proxy', 'Berry'),
                        'description' => __('Gravatar proxy domain,like <code>cravatar.cn</code>', 'Berry'),
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'rss_tag',
                        'label' => __('RSS Tag', 'Berry'),
                        'description' => __('You can add tag in rss to verify follow.', 'Berry'),
                    ],
                ]
            ],
            [
                'id' => 'feature',
                'docs' => 'https://docs.wpista.com/config/feature.html',
                'content' => [
                    [
                        'type' => 'switch',
                        'name' => 'auto_update',
                        'label' => __('Update notice', 'Berry'),
                        'description' => __('Get theme update notice.', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'upyun',
                        'label' => __('Upyun CDN', 'Berry'),
                        'description' => __('Make sure all images are uploaded to Upyun, otherwise thumbnails may not display properly.', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'oss',
                        'label' => __('Aliyun OSS CDN', 'Berry'),
                        'description' => __('Make sure all images are uploaded to Aliyun OSS, otherwise thumbnails may not display properly.', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'qiniu',
                        'label' => __('Qiniu OSS CDN', 'Berry'),
                        'description' => __('Make sure all images are uploaded to Qiniu OSS, otherwise thumbnails may not display properly.', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'darkmode',
                        'label' => __('Dark Mode', 'Berry'),
                        'description' => __('Enable dark mode', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'default_thumbnail',
                        'label' => __('Default thumbnail', 'Berry'),
                        'description' => __('Default thumbnail address', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'back2top',
                        'label' => __('Back to top', 'Berry'),
                        'description' => __('Enable back to top', 'Berry')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'loadmore',
                    //     'label' => __('Load more', 'Berry'),
                    //     'description' => __('Enable load more', 'Berry')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_author',
                    //     'label' => __('Author info', 'Berry'),
                    //     'description' => __('Enable author info in homepage', 'Berry')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_cat',
                    //     'label' => __('Category info', 'Berry'),
                    //     'description' => __('Enable category info in homepage', 'Berry')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_like',
                    //     'label' => __('Like info', 'Berry'),
                    //     'description' => __('Enable like info in homepage', 'Berry')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_image_count',
                    //     'label' => __('Image count', 'Berry'),
                    //     'description' => __('Show image count of the post', 'Berry')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'hide_home_cover',
                        'label' => __('Hide home cover', 'Berry'),
                        'description' => __('Hide home cover', 'Berry')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'exclude_status',
                    //     'label' => __('Exclude status', 'Berry'),
                    //     'description' => __('Exclude post type status in homepage', 'Berry')
                    // ],
                ]
            ],

            [
                'id' => 'singluar',
                'content' => [
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'bio',
                    //     'label' => __('Author bio', 'Berry'),
                    //     'description' => __('Enable author bio', 'Berry')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'author_sns',
                    //     'label' => __('Author sns icons', 'Berry'),
                    //     'description' => __('Show author sns icons, will not show when author bio is off.', 'Berry')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'related',
                        'label' => __('Related posts', 'Berry'),
                        'description' => __('Enable related posts', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'postlike',
                        'label' => __('Post like', 'Berry'),
                        'description' => __('Enable post like', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'post_navigation',
                        'label' => __('Post navigation', 'Berry'),
                        'description' => __('Enable post navigation', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'show_copylink',
                        'label' => __('Copy link', 'Berry'),
                        'description' => __('Enable copy link', 'Berry')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'category_card',
                    //     'label' => __('Category card', 'Berry'),
                    //     'description' => __('Show post category info after post.', 'Berry')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'show_parent',
                        'label' => __('Show parent comment', 'Berry'),
                        'description' => __('Enable show parent comment', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'toc',
                        'label' => __('Table of content', 'Berry'),
                        'description' => __('Enable table of content', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'toc_start',
                        'label' => __('Start heading', 'Berry'),
                        'description' => __('Start heading,default h3', 'Berry')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'show_rss_btn',
                    //     'label' => __('RSS Button', 'Berry'),
                    //     'description' => __('Show RSS Button in meta', 'Berry')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'disable_comment_link',
                        'label' => __('Disable comment link', 'Berry'),
                        'description' => __('Disable comment author url', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'no_reply_text',
                        'label' => __('No reply text', 'Berry'),
                        'description' => __('Text display when no comment in current post.', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'friend_icon',
                        'label' => __('Friend icon', 'Berry'),
                        'description' => __('Show icon when comment author url is in blogroll.', 'Berry')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'image_zoom',
                    //     'label' => __('Post image zoom', 'Berry'),
                    //     'description' => __('Zoom image when a tag link to image url.', 'Berry')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'update_time',
                    //     'label' => __('Post update time', 'Berry'),
                    //     'description' => __('Show the last update time of post.', 'Berry')
                    // ],
                ]
            ],
            [
                'id' => 'meta',
                'docs' => 'https://docs.wpista.com/config/sns.html',
                'content' => [
                    [
                        'type' => 'switch',
                        'name' => 'footer_sns',
                        'label' => __('Footer SNS Icons', 'Berry'),
                        'description' => __('Show sns icons in footer, if this setting is on, the footer menu won\',t be displayed.', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'telegram',
                        'label' => __('Telegram', 'Berry'),
                        'description' => __('Telegram link', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'email',
                        'label' => __('Email', 'Berry'),
                        'description' => __('Your email address', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'instagram',
                        'label' => __('Instagram', 'Berry'),
                        'description' => __('Instagram link', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'twitter',
                        'label' => __('Twitter', 'Berry'),
                        'description' => __('Twitter link', 'Berry')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'rss',
                        'label' => __('RSS', 'Berry'),
                        'description' => __('RSS link', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'github',
                        'label' => __('Github', 'Berry'),
                        'description' => __('Github link', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'discord',
                        'label' => __('Discord', 'Berry'),
                        'description' => __('Discord link', 'Berry')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'mastodon',
                        'label' => __('Mastodon', 'Berry'),
                        'description' => __('Mastodon link', 'Berry')
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'custom_sns',
                        'label' => __('Custom', 'Berry'),
                        'description' => __('Custom sns link,use html.', 'Berry')
                    ],
                ]
            ],
            [
                'id' => 'custom',
                'content' => [
                    [
                        'type' => 'textarea',
                        'name' => 'css',
                        'label' => __('CSS', 'Berry'),
                        'description' => __('Custom CSS', 'Berry')
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'javascript',
                        'label' => __('Javascript', 'Berry'),
                        'description' => __('Custom Javascript', 'Berry')
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'copyright',
                        'label' => __('Copyright', 'Berry'),
                        'description' => __('Custom footer content', 'Berry')
                    ],
                ]
            ],
        ]
    ]
);
