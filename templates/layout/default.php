<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = 'ARS';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?> - 
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('jquery.dataTables.min.css') ?>
    <?= $this->Html->css('styles.css') ?>
    <?= $this->Html->css('datepicker3.css') ?>
    <?= $this->Html->css('font-awesome.min.css') ?>

    <?= $this->Html->css('fonts.css') ?>
    <?= $this->Html->css('select2.min.css') ?>

    <?= $this->Html->script("jquery-1.11.1.min.js") ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <?php echo $this->element('admin'); ?>


    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <?= $this->fetch('content') ?>
        <footer>

        </footer>
    </div>
    <?= $this->Html->script("jquery-1.11.1.min.js") ?>
    <?= $this->Html->script("datatable/jquery.datatable.min.js") ?>
    <?= $this->Html->script("datatable/dataTables.buttons.min.js") ?>
    <?= $this->Html->script("datatable/buttons.flash.min.js") ?>
    <?= $this->Html->script("datatable/jszip.min.js") ?>
    <?= $this->Html->script("datatable/pdfmake.min.js") ?>
    <?= $this->Html->script("datatable/vfs_fonts.js") ?>
    <?= $this->Html->script("datatable/buttons.html5.min.js") ?>
    <?= $this->Html->script("datatable/buttons.print.min.js") ?>
    <?= $this->Html->script("datatable/dataTables.fixedColumns.min.js") ?>
    <?= $this->Html->script("bootstrap.js") ?>
    <?= $this->Html->script("bootstrap-datepicker.js") ?>
    <?= $this->Html->script("custom.js") ?>
    <?= $this->Html->script("select2.min.js") ?>
    
    <style type="text/css">

        .select2-container .select2-selection--single{
            height:45px!important;
        }
        div.message.success{
            background: #dff0d8;
            padding: 13px;
            margin: 14px;
            text-align: center;
        }
        div.message.error{
            background: #f2dede;
            padding: 13px;
            margin: 14px;
            text-align: center;
        }
        /*.breadcrumb{
            margin-top:-20px!important;
        }*/
        .fa-plus{
            margin-top:10px!important;
        }

        .select2-container{
            width:100%!important;
        }

        select.form-control{
            height:46px!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height:45px!important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
    margin-top: 6px;
}
    </style>

    <script type="text/javascript">
        $(function(){
            $('.select2').select2();
        })
    </script>
<!-- Start of LiveChat (www.livechat.com) code -->
<script>
    window.__lc = window.__lc || {};
    window.__lc.license = 14120061;
    ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};!n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
</script>
<noscript><a href="https://www.livechat.com/chat-with/14120061/" rel="nofollow">Chat with us</a>, powered by <a href="https://www.livechat.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>

<script src="https://global.localizecdn.com/localize.js"></script>
<script>!function(a){if(!a.Localize){a.Localize={};for(var e=["translate","untranslate","phrase","initialize","translatePage","setLanguage","getLanguage","getSourceLanguage","detectLanguage","getAvailableLanguages","untranslatePage","bootstrap","prefetch","on","off","hideWidget","showWidget"],t=0;t<e.length;t++)a.Localize[e[t]]=function(){}}}(window);</script>

<script>
  Localize.initialize({
    key: 'BafBUhqcbxEzo',
    rememberLanguage: true,
  });
</script>
<!-- End of LiveChat code -->
</body>
</html>
