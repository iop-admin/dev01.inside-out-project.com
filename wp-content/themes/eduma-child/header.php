<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package thim
 */

//include('inc/top-cache.php');


?>
<!DOCTYPE html>
<html itemscope itemtype="https://schema.org/WebPage" <?php language_attributes(); ?>>
<head>
     <meta charset="<?php bloginfo( 'charset' ); ?>">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="profile" href="https://gmpg.org/xfn/11">
     <link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>">
     <base href="https://dev01.inside-out-project.com/">
     <?php wp_head(); ?>
     <script type="text/javascript">
          <?php
               $pty = 'none';
               if(get_post_type()):
                   $pty = get_post_type();
               else:
                   $pty = get_post_format();
               endif;     
          ?>
          var iopApp = {
               appName: "inside out project",
               app_version: "1.0.0.4",
               postId: <?php the_ID(); ?>,
               postType: "<?php echo $pty; ?>",
               sitePath: "<?php echo $_SERVER['HTTP_HOST']; ?>",
               globalResourcesPath: "https://dev01.inside-out-project.com/global_resources/",
               appPath: this.sitePath + "iop_app/",
               includesPath: this.appPath + "includes/",
               adminPath: this.sitePath + "wp-admin/",
               defaultApi: this.sitePath + "wp-json/wp/v2/",
               globalIncludesPath: this.globalResourcesPath + "includes/",
               globalIcons: this.globalResourcesPath + "icons/",
               loaderPagesPath: this.globalResourcesPath + "loader-pages/",
               topTabs: {},
               resourceList: [],
               ignoreLink: [ 'login', '#', 'wp-admin' ],
               curId: '',
               isAdminUser: 0,
               isInIFrame: ( window.location !== window.parent.location ),
               appInfo: function () {
                    return this.appName + " " + this.app_version;
               }
          };
     </script>
     <?php if (strpos($_SERVER['REQUEST_URI'], 'lesson') !== false) { ?>
     <link rel="stylesheet" href="iop_app/iop_lp_widget_prd/iop_lp_widget.css">
     <!--
     <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
     <script async src="https://hypothes.is/embed.js"></script>
     -->
     <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/0.95.1/js/materialize.min.js"></script>
     <?php } ?>
     <script src="iop_app/iop_lp_widget_prd/iop_lp_widget.js"></script>
</head>

<body <?php body_class(); ?> id="thim-body">
     <script>
          console.log("POST TYPE: <?php echo $pty; ?>");
          console.log("URI PATH: <?php echo $_SERVER['REQUEST_URI']; ?>");
     </script>
     <?php if (strpos($_SERVER['REQUEST_URI'], 'lesson') !== false) { ?>
     <div id="resourceDisplay" style="display: none;">
          <div class="wrapper">
               <header>
                    <div class="title"></div>
                    <nav><a href="" target="_blank" class="window-cur-link"><i class="fa fa-external-link"></i></a><i class="fa fa-times-circle close-button"></i>
                    </nav>
               </header><iframe src="global_resources/loader-pages/loading-010.html" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
          </div>
     </div>
     <div id="lessonResourcesDiv" class="resourceMenu">
          <div class="titleItem addResMenu"><button type="button" class="close resourceClose" aria-label="Close">X</button><strong><i class="fa fa-laptop fa-lg"></i><span class="ttlTxt"></strong>
               </span>
          </div>
          <div class="additional-resources-container">
               <div class="row" style="min-height: 200px;">
                    <div class="board">
                         <div class="board-inner">
                              <ul class="nav nav-tabs" id="resourceTabs">
                                   
                                   <li class="" id="featured_videoResTabLi" style="display: none;"> <a href="#featured_videoResTab" data-toggle="tab" title="featured_videoResTab" aria-expanded="true"> <span class="round-tabs two"> <i class="fa fa-youtube"></i> Videos</span> </a> </li>
                                   
                                   <li class="" id="webtoolResTabLi" style="display: none;"> <a href="#webtoolResTab" data-toggle="tab" title="webtoolResTab" aria-expanded="false"> <span class="round-tabs two"> <i class="fa fa-book"></i> Web Tools</span> </a> </li>
                                   
                                   <li class="" id="webpageResTabLi" style="display: none;"> <a href="#webpageResTab" data-toggle="tab" title="webpageResTab" aria-expanded="false"> <span class="round-tabs two"> <i class="fa fa-external-link"></i> Web Pages</span> </a> </li>
                                   
                                   <li class="" id="codeResTabLi" style="display: none;"> <a href="#codeResTab" data-toggle="tab" title="codeResTab" aria-expanded="false"> <span class="round-tabs two"> <i class="fa fa-code"></i> Code</span> </a> </li>
                                   
                              </ul>
                         </div>
                         <div class="tab-content">
                              <div class="tab-pane" id="featured_videoResTab" style="display: none;"></div>
                              <div class="tab-pane" id="webtoolResTab" style="display: none;"></div>
                              <div class="tab-pane" id="webpageResTab" style="display: none;"></div>
                              <div class="tab-pane" id="codeResTab" style="display: none;"></div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div id="settingsResourcesDiv" class="resourceMenu">
          <div class="titleItem settingsMenu"><button type="button" class="close resourceClose" aria-label="Close">X</button><strong><i class="fa fa-gear fa-lg"></i> <span class="ttlTxt"></span></strong>
          </div>
     </div>
     <div id="commentsResourcesDiv" class="resourceMenu">
          <div class="titleItem addCommentMenu"><button type="button" class="close resourceClose" aria-label="Close">X</button><strong><i class="fa fa-comment fa-lg"></i><span class="ttlTxt"></strong>
               </span>
          </div>
     </div>
     <?php } ?>
     <?php do_action( 'thim_before_body' ); ?>

     <!-- Mobile Menu-->
     <?php if ( wp_is_mobile() ): ?>
     <div class="mobile-menu-wrapper">
          <div class="mobile-menu-inner">
               <div class="icon-wrapper">
                    <div class="menu-mobile-effect navbar-toggle close-icon" data-effect="mobile-effect">
                         <span class="icon-bar"></span>
                         <span class="icon-bar"></span>
                         <span class="icon-bar"></span>
                    </div>
               </div>
               <nav class="mobile-menu-container mobile-effect">
                    <?php get_template_part( 'inc/header/menu-mobile' ); ?>
               </nav>
          </div>
     </div>
     <?php endif; ?>

     <div id="wrapper-container" class="wrapper-container">
          <div class="content-pusher">

               <?php if(!isset($_REQUEST['iframe'])) { ?>
               <!-- This page was not loaded in an iframe. -->
               <header id="masthead" class="site-header affix-top<?php thim_header_class(); ?>">
                    <?php
                    //Toolbar
                    if ( get_theme_mod( 'thim_toolbar_show', true ) ) {
                         get_template_part( 'inc/header/toolbar' );
                    }

                    //Header style
                    if ( get_theme_mod( 'thim_header_style', 'header_v1' ) ) {
                         get_template_part( 'inc/header/' . get_theme_mod( 'thim_header_style', 'header_v1' ) );
                    }

                    ?>
               </header>
               <?php }else{  ?>
               <!-- This page has been loaded in an iframe. -->
               <style type="text/css">
                    html[class],
                    html[lang] {
                         margin-top: 0px !important;
                    }
                    
                    html {
                         margin-top: 02px !important;
                    }
                    
                    * html body {
                         margin-top: 0px !important;
                    }
                    
                    .site-content {
                         padding: 0px;
                    }
                    
                    .ea-bootstrap form .col-md-6 {
                         width: 50%;
                         display: inline-block;
                    }
                    
                    @media screen and ( max-width: 782px) {
                         html {
                              margin-top: 0px !important;
                         }
                         * html body {
                              margin-top: 0px !important;
                         }
                    }
               </style>
               <?php }  ?>


               <div id="main-content">